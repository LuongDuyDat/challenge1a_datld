<?php

$heading = 'Exercise';

session_start();

if (!isset($_SESSION['logged']) || !$_SESSION['logged']) {
    header("Location: /");
    die();
}

require base_path("model/exercise.php");
require base_path("model/profile.php");

$config = require base_path('config.php');
$db = new Database($config['database']['dsn'], $config['database']['username'], $config['database']['password']);
$exercise_db = new Exercise($db);
$profile_db = new Profile($db);

$exercises = $exercise_db->selectAll();

//Query Teacher name From teacher Id
foreach ($exercises as $exercise) {
    $profile = $profile_db->selectById($exercise['teacher_id']);
    $exercise['teacher_name'] = $profile['fullName'];
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    //check if it is a file posted
    if (isset($_FILES["exercise-file"]) && $_FILES["exercise-file"]['size'] != 0) {
        //check if user have permiss to upload exercise
        if (!isset($_SESSION['role']) || $_SESSION['role'] != Role::TEACHER) {
            abort(403);
        }

        //check file size
        if ($_FILES['exercise-file']['size'] > 20000000) {
            $errors["file"] = "Tệp của bạn có dung lượng quá lớn";
        } else {
            $target_dir = "assets/exercise/";
            //make file path in server            
            $target_file = $target_dir . uniqueUploadFile() . basename($_FILES["exercise-file"]["name"]);

            //check if directory is already exists in server
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            if (!move_uploaded_file($_FILES['exercise-file']["tmp_name"], $target_file) || $_FILES['exercise-file']["tmp_name"] == '') {
                $errors["file"] = "Không thể tải tệp lên hệ thống";
            } else {
                $exercise_db->add($_POST['title'], basename($_FILES["exercise-file"]["name"]), $_FILES["exercise-file"]['size'], $_SESSION['id'], $target_file);
            };
        }
    }
}

$exercises = $exercise_db->selectAll();

//fetch exercise again to update new exercise that upload from POST method 
for ($i = 0; $i < count($exercises); $i++) {
    $exercise = $exercises[$i];
    $profile = $profile_db->selectById($exercise['teacher_id']);
    $exercise['teacher_name'] = $profile['fullName'];
    $exercises[$i] = $exercise;
}
$exercises = array_reverse($exercises);


require base_path('view/exercise_view.php');