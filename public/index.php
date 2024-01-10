<?php

const BASE_PATH = __DIR__ . '/../';    

require BASE_PATH . 'core/function.php';
require base_path('core/role.php');
require_once base_path('core/db.php');
require_once base_path('model/profile.php');

if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}

if (isset($_SESSION['id'])) {
    //if the user using web but teacher delete this user, logout
    $config = require base_path('config.php');
    $db = new Database($config['database']['dsn'], $config['database']['username'], $config['database']['password']);
    $profile_db = new Profile($db);
    if ($profile_db->selectById($_SESSION['id']) == 'fail') {
        require base_path("controller/logout_controller.php");
    }
}

require base_path('routes.php');