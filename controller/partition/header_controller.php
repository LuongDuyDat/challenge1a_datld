<?php

if (!isset($config)) {
    $config = require base_path('config.php');
}

if (!isset($db)) {
    $db = new Database($config['database']['dsn'], $config['database']['username'], $config['database']['password']);
}

if (!isset($profile_db)) {
    require base_path('model/profile.php');

    $profile_db = new Profile($db);
}


$my_profile = $profile_db->selectById($_SESSION["id"]);
$avatar = $my_profile['avatar'];

require base_path("view/partition/header.php");

?>