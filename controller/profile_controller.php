<?php

require base_path('core/validator.php');
require base_path('model/account.php');
require_once base_path('model/profile.php');
require base_path('model/message.php');

session_start();

//check if the user is logged
if (!isset($_SESSION['logged']) || !$_SESSION['logged']) {
    header("Location: /");
    die();
}

$heading = '';
$errors = [];

$config = require base_path('config.php');
$db = new Database($config['database']['dsn'], $config['database']['username'], $config['database']['password']);
$account_db = new Account($db);
$profile_db = new Profile($db);
$message_db = new Message($db);

//Get profile_id of the profile user want to view. 
$profile_id = $_GET['user_id'] ?? $_SESSION['id'];
$account = $account_db->selectById($profile_id);
$profile = $profile_db->selectById($profile_id);
$messages = $message_db->selectAllByReceiverID($profile_id);

//The user can edit profile if they are teacher or the owner of the profile
if ($_SESSION['id'] != $profile_id && ($_SESSION['role'] != Role::TEACHER || $account['role'] != Role::STUDENT)) {
    $editable_profile = false;
} else {
    $editable_profile = true;
}

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    //Edit profile information
    if (isset($_POST["Save-profile"])) {
        if (!$editable_profile) {
            abort(403);
        }

        $errors["username"] = Validator::string($_POST['username'], "tên đăng nhập", 6, 45);
        $errors["password"] = Validator::string($_POST['password'], "mật khẩu", 6, 45);

        //Student cannot update username and fullName
        if ($errors["password"] == '' && $_SESSION['role'] == Role::STUDENT) {
            $account_db->update($profile_id, $account['username'], $_POST['password']);
            $profile_db->update($profile_id, $profile['fullName'], $_POST['email'], $_POST['phone'], $profile['avatar']);
        } else if ($errors["username"] == '' && $errors["password"] == ' ' && $_SESSION['role'] == Role::TEACHER){
            $result = $account_db->update($profile_id, $_POST['username'], $_POST['password']);
            if ($result == "Username already exists") {
                $errors["username"] = "Tài khoản đã tồn tại";
            } else {
                $profile_db->update($profile_id, $_POST['fullName'], $_POST['email'], $_POST['phone'], $profile['avatar']);
            }
        }
    }

    //Edit profile avatar
    if (isset($_POST['avatar'])) {
        if (!$editable_profile) {
            abort(403);
        }

        if ($_FILES['avatar-input']['size'] > 10000000) {
            $errors["avatar"] = "Tệp của bạn có dung lượng quá lớn";
        } else {
            $target_dir = "assets/images/";
            //get image file type
            $image_file_type = strtolower(pathinfo(basename($_FILES['avatar-input']['name']),PATHINFO_EXTENSION));
            //make path that the upload file will be stored on server
            $target_file = $target_dir . "avatar-$profile_id" . ".$image_file_type";

            if (!move_uploaded_file($_FILES['avatar-input']["tmp_name"], $target_file) || $_FILES['avatar-input']["tmp_name"] == '') {
                $errors["avatar"] = "Không thể cập nhật ảnh đại diện";
            } else {
                if ($profile['avatar'] != 'assets/images/default_avatar.jpg') {
                    unlink($profile['avatar']);
                }
                $profile_db->update($profile_id, $profile['fullName'], $profile['email'], $profile['phone'], $target_file);
            };
        }
    }

    //Delete Profile
    if (isset($_POST['delete'])) {
        if (!$editable_profile) {
            abort(403);
        }

        //delete file on server
        if ($profile['avatar'] != 'assets/images/default_avatar.jpg') {
            unlink($profile['avatar']);
        }
        $account_db->deleteByID($profile_id);
        header("Location: /");
    }

    //Add message
    if (isset($_POST["message-create"]) && $_POST["message-create"] != '') {
        $message_db->add($_SESSION['id'], $profile_id, $_POST["message-create"]);
    }

    //Delete message
    if (isset($_POST["message-delete-id"])) {
        $message_db->deleteById($_POST["message-delete-id"]);
    }

    //Edit message content
    if (isset($_POST["message-edit-id"])) {
        if ($_POST["message-edit-content"] == '') {
            $message_db->deleteById($_POST["message-edit-id"]);
        } else {
            $message_db->update($_POST["message-edit-id"], $_POST["message-edit-content"]);
        }
    }
}

//Get the content again to update the change if there are any modification after proccessing POST request
$account = $account_db->selectById($profile_id);
$profile = $profile_db->selectById($profile_id);
$messages = $message_db->selectAllByReceiverID($profile_id);

for ($i = 0; $i < count($messages); $i++) {
    $messages[$i]["sender_fullname"] = $profile_db->selectById($messages[$i]["sender_id"])["fullName"];
}

require base_path("view/profile_view.php");