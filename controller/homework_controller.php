<?php

session_start();
require base_path('model/exercise.php');
require base_path('model/homework_file.php');
require base_path('model/homework.php');
require_once base_path('model/profile.php');

if (!isset($_SESSION['logged']) || !$_SESSION['logged']) {
    header("Location: /");
    die();
}

$exercise_id = explode('/', $_SERVER['REQUEST_URI'])[2];
$config = require base_path('config.php');
$db = new Database($config['database']['dsn'], $config['database']['username'], $config['database']['password']);
$exercise_db = new Exercise($db);
$profile_db = new Profile($db);
$homework_db = new Homework($db);
$homeworks = $homework_db->selectByExerciseID($exercise_id);

if ($_SESSION['role'] == Role::STUDENT) {
    $homework_file_db = new HomeworkFile($db);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_FILES["homework-file"]) && $_FILES["homework-file"]['size'] != 0) {
        if (!isset($_SESSION['role']) || $_SESSION['role'] != Role::STUDENT) {
            abort(403);
        }

        if ($_FILES['homework-file']['size'] > 20000000) {
            $errors["file"] = "Your file is too large";
        } else {
            $target_dir = "assets/homework/";            
            $target_file = $target_dir . basename($_FILES["homework-file"]["name"]);

            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            if (!move_uploaded_file($_FILES['homework-file']["tmp_name"], $target_file) || $_FILES['homework-file']["tmp_name"] == '') {
                $errors["file"] = "Cannot upload the avatar";
            } else {
                $find = false;
                foreach ($homeworks as $homework) {
                    if ($homework['student_id'] == $_SESSION['id']) {
                        $find = true;
                        break;
                    }
                }

                if (!$find) {
                    $homework_db->add($exercise_id, $_SESSION['id']);
                }

                $homework_id = $homework_db->select($exercise_id, $_SESSION['id'])['id'];

                $homework_file_db->add($homework_id, $target_file, basename($_FILES["homework-file"]["name"]), $_FILES["homework-file"]['size']);
            };
        }
    }
}

$exercise = $exercise_db->selectByID($exercise_id);
$profile = $profile_db->selectById($exercise['teacher_id']);
$exercise['teacher_name'] = $profile['fullName'];
if ($_SESSION['role'] == Role::STUDENT) {
    foreach ($homeworks as $homework) {
        if ($homework['student_id'] == $_SESSION['id']) {
            $homework_id = $homework['id'];
            break;
        }
    }
    if (isset($homework_id)) {
        $homework_files = $homework_file_db->selectByHomeworkID($homework_id);
    } else {
        $homework_files = [];
    }
    
}

if ($_SESSION['role'] == Role::TEACHER) {
    for ($i = 0; $i < count($homeworks); $i++) {
        $homework = $homeworks[$i];
        $homework['studentName'] = $profile_db->selectById($homework['student_id'])['fullName'];
        $homeworks[$i] = $homework;
    }
}

require base_path('view/homework_view.php');