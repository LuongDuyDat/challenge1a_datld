<?php

require base_path('core/validator.php');
require base_path('model/account.php');
require base_path('model/profile.php');
require base_path('model/message.php');

session_start();
$heading = '';
$errors = [];

$config = require base_path('config.php');
$db = new Database($config['database']['dsn'], $config['database']['username'], $config['database']['password']);
$account_db = new Account($db);
$profile_db = new Profile($db);
$message_db = new Message($db);
$profile_id = $_GET['user_id'] ?? $_SESSION['id'];
$account = $account_db->selectById($profile_id);
$profile = $profile_db->selectById($profile_id);
$messages = $message_db->selectAllByReceiverID($profile_id);

if ($_SESSION['id'] != $profile_id && ($_SESSION['role'] != Role::TEACHER || $account['role'] != Role::STUDENT)) {
    $editable_profile = false;
} else {
    $editable_profile = true;
}

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    if (isset($_POST["Save-profile"])) {
        if (!$editable_profile) {
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

    if (isset($_POST['avatar'])) {
        if (!$editable_profile) {
            abort(403);
        }

        if ($_FILES['avatar-input']['size'] > 10000000) {
            $errors["avatar"] = "Your file is too large";
        } else {
            $target_dir = "assets/images/";
            $image_file_type = strtolower(pathinfo(basename($_FILES['avatar-input']['name']),PATHINFO_EXTENSION));
            $target_file = $target_dir . "avatar-$profile_id" . ".$image_file_type";

            if (!move_uploaded_file($_FILES['avatar-input']["tmp_name"], $target_file) || $_FILES['avatar-input']["tmp_name"] == '') {
                $errors["avatar"] = "Cannot upload the avatar";
            } else {
                $profile_db->update($profile_id, $profile['fullName'], $profile['email'], $profile['phone'], $target_file);
            };
        }
    }

    if (isset($_POST["message-create"]) && $_POST["message-create"] != '') {
        $message_db->add($_SESSION['id'], $profile_id, $_POST["message-create"]);
    }

    if (isset($_POST["message-delete-id"])) {
        $message_db->deleteById($_POST["message-delete-id"]);
    }

    if (isset($_POST["message-edit-id"])) {
        if ($_POST["message-edit-content"] == '') {
            $message_db->deleteById($_POST["message-edit-id"]);
        } else {
            $message_db->update($_POST["message-edit-id"], $_POST["message-edit-content"]);
        }
    }
}
$account = $account_db->selectById($profile_id);
$profile = $profile_db->selectById($profile_id);
$messages = $message_db->selectAllByReceiverID($profile_id);

for ($i = 0; $i < count($messages); $i++) {
    $messages[$i]["sender_fullname"] = $profile_db->selectById($messages[$i]["sender_id"])["fullName"];
}

require base_path("view/profile_view.php");