<?php

require base_path('core/validator.php');
require base_path('model/account.php');

session_start();

//if user logins successfully, redirect to home page
if (isset($_SESSION['logged']) && $_SESSION['logged'] == true) {
    header("Location: /");
    die();
}

$config = require base_path('config.php');
$db = new Database($config['database']['dsn'], $config['database']['username'], $config['database']['password']);

//array contain error messages and will be used to alert to user
$errors = [];

//if there is a login request to controller 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Validate username and password
    $validation_username = Validator::string($_POST['username'], "ten dang nhap", 6, 45);
    $validation_password = Validator::string($_POST['password'], "mat khau", 6, 45);

    $errors["username"] = $validation_username;
    $errors["password"] = $validation_password;

    if ($errors["username"] == '' && $errors["password"] == '') {
        $account = new Account($db);
        $result = $account->select($_POST['username'], $_POST['password']);

        if ($result == 'fail') {
            $errors["login"] = "Tài khoản hoặc mật khẩu không đúng";
        } else {
            //login successfully. Start session and add information of user to global variable $_SESSION 
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