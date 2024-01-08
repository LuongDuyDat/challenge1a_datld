<?php

require base_path('core/validator.php');
require base_path('model/account.php');
require base_path('model/profile.php');

session_start();

if ($_SESSION['role'] != Role::TEACHER) {
    header("Location: /");
    die();
}

$heading = 'Add Student';
$errors = [];

$config = require base_path('config.php');
$db = new Database($config['database']['dsn'], $config['database']['username'], $config['database']['password']);
$account_db = new Account($db);
$profile_db = new Profile($db);

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    if (isset($_POST["Add-student"])) {

        $errors["username"] = Validator::string($_POST['username'], "ten dang nhap", 6, 45);
        $errors["password"] = Validator::string($_POST['password'], "mat khau", 6, 45);
        $errors['avatar'] = '';

        if ($_FILES['avatar-input']['size'] != 0) {
            if ($_FILES['avatar-input']['size'] > 10000000) {
                $errors["avatar"] = "Your file is too large";
            }
        }

        if ($errors["username"] == '' && $errors["password"] == '' && $errors['avatar'] == ''){
            $result = $account_db->add($_POST['username'], $_POST['password']);
            if ($result == "Username already exists") {
                $errors["username"] = $result;

            } else {
                $account = $account_db->select($_POST['username'], $_POST['password']);
                $target_dir = "assets/images/";
                $image_file_type = strtolower(pathinfo(basename($_FILES['avatar-input']['name']),PATHINFO_EXTENSION));
                $target_file = $target_dir . "avatar-{$account['id']}" . ".$image_file_type";

                move_uploaded_file($_FILES['avatar-input']["tmp_name"], $target_file);
                $profile_db->add($account["id"], $_POST['fullName'], $_POST['email'], $_POST['phone'], $target_file ?? null);
                header("Location: /");
            }
        }
    }
}

require base_path("view/add_student_view.php");