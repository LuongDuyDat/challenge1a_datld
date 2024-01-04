<?php

require 'core/validator.php';
require 'core/function.php';
require 'model/account.php';
require 'core/db.php';

session_start();

if (isset($_SESSION['logged']) && $_SESSION['logged'] == true) {
    header("Location: /");
    die();
}

$config = require 'config.php';
$db = new Database($config['database'], 'root', 'dat123');

$errors = [];

$visible = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $validation_username = Validator::string($_POST['username'], "ten dang nhap", 6, 45);
    $validation_password = Validator::string($_POST['password'], "mat khau", 6, 45);

    $errors["username"] = $validation_username;
    $errors["password"] = $validation_password;

    if ($errors["username"] == '' && $errors["password"] == '') {
        $account = new Account($db);

        if ($account->loginVerify($_POST['username'], $_POST['password'])) {
            session_start();
            $_SESSION["logged"] = true;
            $_SESSION["username"] = $_POST['username'];
            $_SESSION["password"] = $_POST['password'];
            header("Location: /");
        }
    }
}

require './view/login/login_view.php';