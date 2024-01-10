<?php

if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}

require_once base_path('model/exercise.php');
require_once base_path('model/homework_file.php');
require_once base_path('model/homework.php');
require_once base_path('model/profile.php');

if (!isset($_SESSION['logged']) || !$_SESSION['logged']) {
    header("Location: /");
    die();
}

$heading = '';

$exercise_id = explode('/', $_SERVER['REQUEST_URI'])[2];
$config = require base_path('config.php');
$db = new Database($config['database']['dsn'], $config['database']['username'], $config['database']['password']);
$exercise_db = new Exercise($db);
$profile_db = new Profile($db);
$homework_db = new Homework($db);
$exercise = $exercise_db->selectByID($exercise_id);

//If there is no exercise have exercise_id from URL
if ($exercise == 'fail') {
    abort(404);
}

//Get all the student that have at list one submitted file for this exercise
$homeworks = $homework_db->selectByExerciseID($exercise_id);

if ($_SESSION['role'] == Role::STUDENT) {
    $homework_file_db = new HomeworkFile($db);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Student submit homework file
    if (isset($_FILES["homework-file"]) && $_FILES["homework-file"]['size'] != 0) {
        //check role
        if (!isset($_SESSION['role']) || $_SESSION['role'] != Role::STUDENT) {
            abort(403);
        }

        //check file size
        if ($_FILES['homework-file']['size'] > 20000000) {
            $errors["file"] = "Tệp của bạn có dung lượng quá lớn";
        } else {
            $target_dir = "assets/homework/";            
            $target_file = $target_dir . uniqueUploadFile() . basename($_FILES["homework-file"]["name"]);

            //check if the directory prepare for upload file is exist
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            if (!move_uploaded_file($_FILES['homework-file']["tmp_name"], $target_file) || $_FILES['homework-file']["tmp_name"] == '') {
                $errors["file"] = "Không thể đăng tệp";
            } else {
                //find if the student had submitted to this exercise or not
                $find = false;
                foreach ($homeworks as $homework) {
                    if ($homework['student_id'] == $_SESSION['id']) {
                        $find = true;
                        break;
                    }
                }

                //if there is no submit, create one row to homework db
                if (!$find) {
                    $homework_db->add($exercise_id, $_SESSION['id']);
                }

                //add data to homeworkfile db
                $homework_id = $homework_db->select($exercise_id, $_SESSION['id'])['id'];

                $homework_file_db->add($homework_id, $target_file, basename($_FILES["homework-file"]["name"]), $_FILES["homework-file"]['size']);
            };
        }
    }

    //Teacher who is owner of this exercise edit exercise
    if (isset($_FILES["exercise-file"]) && $_FILES["exercise-file"]['size'] != 0) {
        //check role
        if (!isset($_SESSION['role']) || $_SESSION['role'] != Role::TEACHER || $_SESSION['id'] != $exercise['teacher_id']) {
            abort(403);
        }

        //check file size
        if ($_FILES['exercise-file']['size'] > 20000000) {
            $errors["file"] = "Tệp của bạn có dung lượng quá lớn";
        } else {
            $target_dir = "assets/exercise/";       
            //location of upload file in server     
            $target_file = $target_dir . uniqueUploadFile() . basename($_FILES["exercise-file"]["name"]);

            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            if (!move_uploaded_file($_FILES['exercise-file']["tmp_name"], $target_file) || $_FILES['exercise-file']["tmp_name"] == '') {
                $errors["file"] = "Không thể tải tệp lên hệ thống";
            } else {
                //delete old file of exercise
                unlink($exercise['file_path']);
                $exercise_db->update($exercise_id, $_POST['title'], basename($_FILES["exercise-file"]["name"]), $_FILES["exercise-file"]['size'], $target_file);
            };
        }
    }

    //Teacher who is the owner of the exercise delete exercise
    if (isset($_POST['delete'])) {
        if (!isset($_SESSION['role']) || $_SESSION['role'] != Role::TEACHER || $_SESSION['id'] != $exercise['teacher_id']) {
            abort(403);
        }

        //delete homework file of this exercise in server
        foreach ($homeworks as $homework) {
            $homework_file_db = new HomeworkFile($db);
            $homework_files = $homework_file_db->selectByHomeworkID($homework['id']);

            foreach ($homework_files as $homework_file) {
                unlink($homework_file['file_path']);
            }
        }

        //delete exercise file in server
        unlink($exercise['file_path']);
        $exercise_db->deleteById($exercise_id);
        header("Location: /exercise");
    }

    //Student delete their submitted file
    if (isset($_POST['delete-homework-file-id'])) {
        if (!isset($_SESSION['role']) || $_SESSION['role'] != Role::STUDENT) {
            abort(403);
        }

        $homework_file_db = new HomeworkFile($db);
        $homework_file = $homework_file_db->selectByID($_POST['delete-homework-file-id']);
        unlink($homework_file['file_path']);
        $homework_file_db->deleteByID($homework_file['id']);

        $homework_id = $homework_file['homework_id'];

        //if there is not submit of student in this exercise, delete data from homework db
        $homework_files = $homework_file_db->selectByHomeworkID($homework_id);
        if (count($homework_files) == 0) {
            $homework_db->deleteByID($homework_id);
        }
    }
}

$exercise = $exercise_db->selectByID($exercise_id);
$profile = $profile_db->selectById($exercise['teacher_id']);
$exercise['teacher_name'] = $profile['fullName'];

//Get homework file that student submitted for this exercise
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

//Get student who submitted
if ($_SESSION['role'] == Role::TEACHER) {
    for ($i = 0; $i < count($homeworks); $i++) {
        $homework = $homeworks[$i];
        $homework['studentName'] = $profile_db->selectById($homework['student_id'])['fullName'];
        $homeworks[$i] = $homework;
    }
}

require base_path('view/homework_view.php');