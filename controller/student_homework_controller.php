<?php

session_start();

if (!isset($_SESSION['logged']) || $_SESSION['role'] != Role::TEACHER ) {
    header("Location: /");
    die();
}

$heading = '';
$homework_id = explode('/', $_SERVER['REQUEST_URI'])[2];

