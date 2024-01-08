<?php

$heading = 'Exercise';

session_start();

require base_path("model/exercise.php");
require base_path("model/profile.php");

$config = require base_path('config.php');
$db = new Database($config['database']['dsn'], $config['database']['username'], $config['database']['password']);
$exercise_db = new Exercise($db);
$profile_db = new Profile($db);

$exercises = $exercise_db->selectAll();

foreach ($exercises as $exercise) {
    $profile = $profile_db->selectById($exercise['teacher_id']);
    $exercise['teacher_name'] = $profile['fullName'];
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    if (isset($_FILES["exercise-file"]) && $_FILES["exercise-file"]['size'] != 0) {
        if (!isset($_SESSION['role']) || $_SESSION['role'] != Role::TEACHER) {
            abort(403);
        }

        if ($_FILES['exercise-file']['size'] > 20000000) {
            $errors["file"] = "Your file is too large";
        } else {
            $target_dir = "assets/exercise/";            
            $target_file = $target_dir . basename($_FILES["exercise-file"]["name"]);

            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            if (!move_uploaded_file($_FILES['exercise-file']["tmp_name"], $target_file) || $_FILES['exercise-file']["tmp_name"] == '') {
                $errors["file"] = "Cannot upload the avatar";
            } else {
                $exercise_db->add(basename($_FILES["exercise-file"]["name"]), $_FILES["exercise-file"]['size'], $_SESSION['id'], $target_file);
            };
        }
    }
}

$exercises = $exercise_db->selectAll();

for ($i = 0; $i < count($exercises); $i++) {
    $exercise = $exercises[$i];
    $profile = $profile_db->selectById($exercise['teacher_id']);
    $exercise['teacher_name'] = $profile['fullName'];
    $exercises[$i] = $exercise;
}
$exercises = array_reverse($exercises);


require base_path('view/exercise_view.php');