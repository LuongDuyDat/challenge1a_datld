<?php

require base_path('core/validator.php');
require base_path('model/account.php');

session_start();

if (isset($_SESSION['logged']) && $_SESSION['logged'] == true) {
    header("Location: /");
    die();
}

$config = require base_path('config.php');
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
        $result = $account->select($_POST['username'], $_POST['password']);

        if ($result == 'fail') {
            $errors["login"] = "Tai khoan hoac mat khau khong dung";
        } else {
            session_start();
            $_SESSION["logged"] = true;         
            $_SESSION["id"] = $result["id"];
            $_SESSION["username"] = $_POST['username'];
            $_SESSION["password"] = $_POST['password'];
            $_SESSION["role"] = $result["role"];
            header("Location: /");
        }
    }
}

require base_path('view/login_view.php');