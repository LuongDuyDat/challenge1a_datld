<?php

require base_path('core/validator.php');
require base_path('model/account.php');
require base_path('model/profile.php');

session_start();
$heading = '';
$errors = [];

$config = require base_path('config.php');
$db = new Database($config['database']['dsn'], $config['database']['username'], $config['database']['password']);
$account_db = new Account($db);
$profile_db = new Profile($db);
$profile_id = $_GET['user_id'] ?? $_SESSION['id'];
$account = $account_db->selectById($profile_id);
$profile = $profile_db->selectById($profile_id);

if ($_SESSION['id'] != $profile_id && ($_SESSION['role'] != Role::TEACHER || $account['role'] != Role::STUDENT)) {
    $editable = false;
} else {
    $editable = true;
}

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    if (isset($_POST["Save-profile"])) {
        if (!$editable) {
            abort(403);
        }
        $errors["username"] = Validator::string($_POST['username'], "ten dang nhap", 6, 45);
        $errors["password"] = Validator::string($_POST['password'], "mat khau", 6, 45);

        if ($errors["password"] == '' && $_SESSION['role'] == Role::STUDENT) {
            $account_db->update($profile_id, $account['username'], $_POST['password']);
            $profile_db->update($profile_id, $profile['fullName'], $_POST['email'], $_POST['phone']);
        } else if ($errors["username"] == '' && $errors["password"] == ' ' && $_SESSION['role'] == Role::TEACHER){
            $account_db->update($profile_id, $_POST['username'], $_POST['password']);
            $profile_db->update($profile_id, $_POST['fullName'], $_POST['email'], $_POST['phone']);
        }
    }
}
$account = $account_db->selectById($profile_id);
$profile = $profile_db->selectById($profile_id);

require base_path("view/profile_view.php");