<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="/css/header.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .profile-container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            position: relative;
        }

        .profile-image {
            flex: 1;
            height: 200px;
            text-align: center;
        }

        .profile-image img {
            width: 100%;
            max-width: 200px;
            height: 100%;
            overflow: hidden;
            border-radius: 50%;
        }

        .profile-information {
            flex: 2;
            padding-left: 20px;
        }

        .profile-field {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
            width: 50%;
        }

        .profile-field label {
            display: block;
            margin-bottom: 5px;
        }

        .profile-field span {
            display: block;
            font-size: 16px;
        }

        .profile-field .icon {
            margin-right: 5px;
        }

        .profile-field .larger {
            font-size: 24px;
            font-weight: bold;
        }

        .avatar-button {
            margin-top: 20px;
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: inline-block;
        }

        .avatar-button:hover {
            background-color: #45a049;
        }

        .save-icon {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 20px;
            cursor: pointer;
            color: #555;
        }

        .edit-mode input {
            padding: 5px;
            width: 30%;
        }

        .message-container {
            max-width: 800px;
            margin: 20px auto 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .message-form {
            margin-bottom: 20px;
        }

        .message-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        .avatar-input {
            display: none;
        }
    </style>
</head>
<body>

    <?php require base_path("controller/partition/header_controller.php")?>

    <?php 
        if (isset($errors['username']) && $errors['username'] != '') {
            echo "<script>
            alert('{$errors['username']}');
            </script>";
        } else if (isset($errors['password']) && $errors['password'] != '') {
            echo "<script>
            alert('{$errors['password']}');
            </script>";
        }

        if (isset($errors['avatar']) && $errors['avatar'] != '') {
            echo "<script>
            alert('{$errors['avatar']}');
            </script>";
        }
    ?>
    <form id="addStudentForm" method="POST" enctype="multipart/form-data">
        <input name="Add-student" type="hidden">
        <div class="profile-container">
            <div class="profile-image">
                <img id="avatar-image" src="/assets/images/default_avatar.jpg" alt="Avatar">
                <label for="avatar-input" class="avatar-button">Thay ảnh đại diện</label>
                <input name="avatar-input" type="file" id="avatar-input" class="avatar-input" accept="image/*" onchange="uploadAvatar(this)">  
            </div>
            <div class="profile-information">
                <div class="save-icon" onclick="<?="editProfile({$_SESSION['role']})"?>">
                    <i class="fas fa-save"></i>
                </div>
                <div class="profile-field">
                    <label for="fullname" id="label-name" ><i class="fas fa-user icon"></i>Họ và tên:</label>
                    <input id="fullname" name="fullName" type="text" class="edit-mode" value="<?=$_POST['fullName'] ?? '' ?>">
                </div>
                <div class="profile-field">
                    <label for="username"><i class="fas fa-user icon"></i>Tên đăng nhập:</label>
                    <input id="username" name="username" type="text" class="edit-mode" value="<?=$_POST['username'] ?? ''?>">
                </div>
                <div class="profile-field">
                    <label for="password"><i class="fas fa-key icon"></i>Mật khẩu:</label>
                    <input id="password" name="password" size="30" type="text" class="edit-mode" value="<?=$_POST['password'] ?? ''?>">
                </div>

                <div class="profile-field">
                    <label for="email"><i class="fas fa-envelope icon"></i>Email:</label>
                    <input id="email" name="email" type="text" class="edit-mode" value="<?=$_POST['email'] ?? ''?>">
                </div>
                <div class="profile-field">
                    <label for="phone"><i class="fas fa-phone-alt icon"></i>Điện thoại:</label>
                    <input id="phone" name="phone" type="text" class="edit-mode" value="<?=$_POST['phone'] ?? ''?>">
                </div>            
            </div>
        </div>       
    </form>

    <script>
        function editProfile(role) {
            var form = document.getElementById('addStudentForm');
            
            if (form) {
                form.submit();
            }
        }

        function uploadAvatar(input) {
            const file = input.files[0];

            if (file) {
                // Display the selected image
                const avatarImage = document.getElementById('avatar-image');
                const reader = new FileReader();

                reader.onload = function (e) {
                    avatarImage.src = e.target.result;
                    
                };
                reader.readAsDataURL(file);
            }
        }
    </script>

</body>
</html>
