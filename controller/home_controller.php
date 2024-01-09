<?php

$heading = 'Home';

session_start();

if (!isset($_SESSION['logged']) || !$_SESSION['logged']) {
    header("Location: /");
    die();
}

require base_path('view/home_view.php');