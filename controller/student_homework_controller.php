<?php

session_start();

require_once base_path("model/homework.php");
require_once base_path("model/exercise.php");
require_once base_path("model/profile.php");
require_once base_path("model/homework_file.php");

if (!isset($_SESSION['logged']) || $_SESSION['role'] != Role::TEACHER ) {
    header("Location: /");
    die();
}

$heading = '';
$homework_id = explode('/', $_SERVER['REQUEST_URI'])[2];

$config = require base_path('config.php');
$db = new Database($config['database']['dsn'], $config['database']['username'], $config['database']['password']);

$homework_db = new Homework($db);
$profile_db = new Profile($db);
$exercise_db = new Exercise($db);
$homework_file_db = new HomeworkFile($db);

$homework = $homework_db->selectByID($homework_id);

if ($homework == 'fail') {
    abort(404);
}

$student_name = $profile_db->selectById($homework['student_id'])['fullName'];
$exercise = $exercise_db->selectByID($homework['exercise_id']);
$teacher_name = $profile_db->selectById($exercise['teacher_id'])['fullName'];
$homework_files = $homework_file_db->selectByHomeworkID($homework_id); 

require base_path("view/student_homework_view.php");
