<?php

require base_path('model/profile.php');

session_start();

if (!isset($_SESSION['logged']) || $_SESSION['logged'] == false) {
    header("Location: /");
    die();
}

$users = [];
$config = require base_path('config.php');
$db = new Database($config['database'], 'root', 'dat123');
$profile =  new Profile($db);

$users = $profile->selectAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {     
    if (isset($_POST['logout']) && $_POST['logout'] == 'Logout')
    {
        $_SESSION = array();
        session_destroy();
        header("Location: /");
        die();
    }
    if (isset($_POST['type']) && $_POST['type'] == 'search') {
        if ($_POST['search-input'] == '') {
            $users = $profile->selectAll();
        } else {
            $users = $profile->search($_POST['search-input']);
        }
    }
}

require base_path('view/home/home_view.php');