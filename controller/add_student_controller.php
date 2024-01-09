<?php

require base_path('core/validator.php');
require base_path('model/account.php');
require_once base_path('model/profile.php');

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
    //Add Student Request
    if (isset($_POST["Add-student"])) {

        //validate username and password
        $errors["username"] = Validator::string($_POST['username'], "tên đăng nhập", 6, 45);
        $errors["password"] = Validator::string($_POST['password'], "mật khẩu", 6, 45);
        $errors['avatar'] = '';

        //validate file
        if ($_FILES['avatar-input']['size'] != 0) {
            if ($_FILES['avatar-input']['size'] > 10000000) {
                $errors["avatar"] = "Tệp của bạn có dung lượng quá lớn";
            }
        }

        if ($errors["username"] == '' && $errors["password"] == '' && $errors['avatar'] == ''){
            $result = $account_db->add($_POST['username'], $_POST['password']);

            //check if there is username already exists in db
            if ($result == "Username already exists") {
                $errors["username"] = "Tài khoản đã tồn tại";

            } else {
                $account = $account_db->select($_POST['username'], $_POST['password']);
                if ($_FILES['avatar-input']['size'] != 0) {
                    $target_dir = "assets/images/";
                    $image_file_type = strtolower(pathinfo(basename($_FILES['avatar-input']['name']),PATHINFO_EXTENSION));
                    $target_file = $target_dir . "avatar-{$account['id']}" . ".$image_file_type";
                }

                move_uploaded_file($_FILES['avatar-input']["tmp_name"], $target_file);
                $profile_db->add($account["id"], $_POST['fullName'], $_POST['email'], $_POST['phone'], $target_file ?? null);
                header("Location: /");
            }
        }
    }
}

require base_path("view/add_student_view.php");