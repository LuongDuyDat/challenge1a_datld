<?php

require 'core/validator.php';

$errors = [];

$visible = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $validation_username = Validator::string($_POST['username'], "ten dang nhap", 6, 45);
    $validation_password = Validator::string($_POST['password'], "mat khau", 6, 45);

    $errors["username"] = $validation_username;
    $errors["password"] = $validation_password;

}

require './view/login/login_view.php';