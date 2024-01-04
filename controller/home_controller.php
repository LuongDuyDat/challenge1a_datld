<?php

session_start();

if (!isset($_SESSION['logged']) || $_SESSION['logged'] == false) {
    header("Location: /");
    die();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {       
    if ($_POST['logout'] == 'Logout')
    {
        $_SESSION = array();
        session_destroy();
        header("Location: /");
        die();
    }
    
}

require 'view/home/home_view.php';