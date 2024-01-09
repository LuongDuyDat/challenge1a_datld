<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/add_student.css">
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
                    <input placeholder="Họ và tên" id="fullname" name="fullName" type="text" class="edit-mode" value="<?=$_POST['fullName'] ?? '' ?>">
                </div>
                <div class="profile-field">
                    <label for="username"><i class="fas fa-user icon"></i>Tên đăng nhập:</label>
                    <input placeholder="Tên đăng nhập" id="username" name="username" type="text" class="edit-mode" value="<?=$_POST['username'] ?? ''?>">
                </div>
                <div class="profile-field">
                    <label for="password"><i class="fas fa-key icon"></i>Mật khẩu:</label>
                    <input placeholder="Mật khẩu" id="password" name="password" size="30" type="text" class="edit-mode" value="<?=$_POST['password'] ?? ''?>">
                </div>

                <div class="profile-field">
                    <label for="email"><i class="fas fa-envelope icon"></i>Email:</label>
                    <input placeholder="Email" id="email" name="email" type="text" class="edit-mode" value="<?=$_POST['email'] ?? ''?>">
                </div>
                <div class="profile-field">
                    <label for="phone"><i class="fas fa-phone-alt icon"></i>Điện thoại:</label>
                    <input placeholder="Điện thoại" id="phone" name="phone" type="text" class="edit-mode" value="<?=$_POST['phone'] ?? ''?>">
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

        //Preview avatar
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
