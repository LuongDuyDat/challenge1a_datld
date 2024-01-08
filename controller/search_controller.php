<?php

$heading = "Search";

require base_path('model/profile.php');

session_start();

if (!isset($_SESSION['logged']) || $_SESSION['logged'] == false) {
    header("Location: /");
    die();
}

$users = [];
$config = require base_path('config.php');
$db = new Database($config['database']['dsn'], $config['database']['username'], $config['database']['password']);
$profile_db =  new Profile($db);

$users = $profile_db->selectAll();

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
            $users = $profile_db->selectAll();
        } else {
            $users = $profile_db->search($_POST['search-input']);
        }
    }
}

require base_path('view/search_view.php');