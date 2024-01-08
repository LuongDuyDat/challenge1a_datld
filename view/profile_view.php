<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/header.css">
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

        .edit-icon {
            position: absolute;
            top: 20px;
            right: 50px;
            font-size: 20px;
            cursor: pointer;
            color: #555;
        }

        .delete-icon {
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

        .message-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .message-item {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .message-item p,
        .message-item input {
            margin: 0;
            flex-grow: 1;
            display: block;
        }

        .message-item input {
            display: none;
        }

        .message-item i {
            font-size: 18px;
            cursor: pointer;
            margin-left: 10px;
        }

        .message-button {
            background-color: #4caf50;
            color: #fff;
            padding: 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .message-button:hover {
            background-color: #45a049;
        }

        .display-content {
            display: contents;
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
            alert({$errors['username']}});
            </script>";
        } else if (isset($errors['password']) && $errors['password'] != '') {
            echo "<script>
            alert('{$errors['password']}');
            </script>";
        }

        if (isset($errors['avatar']) && $errors['avatar'] != '') {
            echo "<script>
            alert({$errors['avatar']}});
            </script>";
        }
    ?>

    <div class="profile-container">
        <div class="profile-image">
            <img src="<?=$profile['avatar']?>" alt="Avatar">
            <?php if ($editable_profile) :?>
                <form id="avatar-form" method="POST" enctype="multipart/form-data">
                    <label for="avatar-input" class="avatar-button">Thay ảnh đại diện</label>
                    <input name="avatar" type="hidden" value="avatar">
                    <input name="avatar-input" type="file" id="avatar-input" class="avatar-input" accept="image/*" onchange="uploadAvatar(this)">
                </form>
            <?php endif; ?>    
        </div>
        <div class="profile-information">
            <?php if ($editable_profile) : ?>
                <form id="editProfileForm" method="POST">
                    <input name="Save-profile" type="hidden">
                    <div class="edit-icon" onclick="<?="editProfile({$_SESSION['role']})"?>">
                        <i class="fas fa-edit"></i>
                    </div>
                    <div class="profile-field">
                        <label for="fullname" id="label-name" style="display: none;"><i class="fas fa-user icon"></i>Họ và tên:</label>
                        <span name="not-none" class="larger"><?=$profile['fullName']?></span>
                        <input id="fullname" name="fullName" type="text" class="edit-mode" style="display:none" value="<?=$profile['fullName'] ?>">
                    </div>
                    <div class="profile-field">
                        <label for="username"><i class="fas fa-user icon"></i>Tên đăng nhập:</label>
                        <span name="not-none"><?=$account['username']?></span>
                        <input id="username" name="username" type="text" class="edit-mode" style="display:none" value="<?=$account['username']?>">
                    </div>
                    <div class="profile-field">
                        <label for="password"><i class="fas fa-key icon"></i>Mật khẩu:</label>
                        <span><?=$account['password']?></span>
                        <input id="password" name="password" size="30" type="text" class="edit-mode" style="display:none" value="<?=$account['password']?>">
                    </div>

                    <div class="profile-field">
                        <label for="email"><i class="fas fa-envelope icon"></i>Email:</label>
                        <span><?=$profile['email']?></span>
                        <input id="email" name="email" type="text" class="edit-mode" style="display:none" value="<?=$profile['email']?>">
                    </div>
                    <div class="profile-field">
                        <label for="phone"><i class="fas fa-phone-alt icon"></i>Điện thoại:</label>
                        <span><?=$profile['phone']?></span>
                        <input id="phone" name="phone" type="text" class="edit-mode" style="display:none" value="<?=$profile['phone']?>">
                    </div>
                </form>
                <form id="deleteProfileForm" method="POST">
                    <input type="hidden" name="delete" value="">
                    <div class="delete-icon" onclick="<?="deleteProfile({$_SESSION['role']})"?>">
                        <i class="fas fa-trash-alt"></i>
                    </div>
                </form>
            <?php else : ?>
                <div class="profile-field">
                    <p for="fullname" id="label-name" style="display: none;"><i class="fas fa-user icon"></i>Họ và tên:</p>
                    <span class="larger"><?=$profile['fullName']?></span>
                </div>

                <div class="profile-field">
                    <p style="margin: 10px 0;"><i class="fas fa-envelope icon"></i>Email:</p>
                    <span><?=$profile['email']?></span>
                </div>
                <div class="profile-field">
                    <p style="margin: 10px 0;"><i class="fas fa-phone-alt icon"></i>Điện thoại:</p>
                    <span><?=$profile['phone']?></span>
                </div>
            <?php endif ?>    
        </div>
    </div>

    <div class="message-container">
        <h2>Tin nhắn</h2>

        <!-- Message Form -->
        <form method="POST">
            <div class="message-form">
                <textarea name="message-create" placeholder="Write your message..."></textarea>
                <button class="message-button" type="submit">Gửi tin nhắn</button>
            </div>
        </form>

        <!-- Message List -->
        <ul class="message-list">
            <!-- Sample Message Item -->
            <?php for ($i = 0; $i < count($messages); $i++):?>
                <li class="message-item">
                    <p><strong><?=$messages[$i]["sender_fullname"]?>:</strong> <?=$messages[$i]['content']?></p>
                    <?php if ($messages[$i]['sender_id'] == $_SESSION['id']): ?>
                        <form class="display-content" id="edit-message-form-<?=$i?>" method="POST">
                            <input type="text" name='message-edit-content' value="<?=$messages[$i]['content']?>">
                            <input name="message-edit-id" type="hidden" value="<?=$messages[$i]['id']?>">
                            <i class="fas fa-edit" onclick="editMessage(this, <?=$i?>)"></i>
                        </form>
                    <?php endif; ?>   
                    <?php if ($messages[$i]['sender_id'] == $_SESSION['id']): ?>
                        <form id="delele-message-form-<?=$i?>" method="POST">
                            <input name="message-delete-id" type="hidden" value="<?=$messages[$i]['id']?>">
                            <i class="fas fa-trash-alt" onclick="deleteMessage(<?=$i?>)"></i>
                        </form>
                    <?php endif; ?>    
                </li>
            <?php endfor; ?>

            <!-- Add more message items dynamically based on user comments -->
        </ul>
    </div>

    <script>
        function editProfile(role) {
            var editModeElements = document.querySelectorAll('.edit-mode');
            editModeElements.forEach(function(element) {
                if (role == 0 || (element.getAttribute('name') != 'username' && element.getAttribute('name') != 'fullName')) {
                    element.style.display = element.style.display === 'none' ? 'block' : 'none';
                }
            });

            var spanElements = document.querySelectorAll('.profile-field span');
            spanElements.forEach(function(element) {
                if (role == 0 || element.getAttribute('name') != 'not-none') {
                    element.style.display = element.style.display === 'none' ? 'block' : 'none';
                }
            });

            if (role == 0) {
                var lableName = document.getElementById('label-name');
                lableName.style.display = lableName.style.display === 'none' ? 'block' : 'none';
            }

            var form = document.getElementById('editProfileForm');
            var editIcon = document.querySelector('.edit-icon i');
            if (editIcon.classList.contains('fa-edit')) {
                editIcon.classList.remove('fa-edit');
                editIcon.classList.add('fa-save');
            } else {
                form.submit();
            }
            
        }

        function deleteProfile() {
            var form = document.getElementById('deleteProfileForm');
            if (form) {
                form.submit();
            }    
        }

        function editMessage(icon, i) {
            console.log(icon);
            var messageItem = icon.closest('.message-item');
            var messageText = messageItem.querySelector('p');
            var messageInput = messageItem.querySelector('input');

            if (icon.classList.contains('fa-edit')) {
                icon.classList.remove('fa-edit');
                icon.classList.add('fa-save');
                messageText.style.display = 'none';
                messageInput.style.display = 'block';
                messageInput.focus();
            } else {
                var formId = "edit-message-form-" + i;
                var form = document.getElementById(formId);

                if (form) {
                    form.submit();
                }
            }

        }

        function deleteMessage(i) {
            var formId = "delele-message-form-" + i;
            var form = document.getElementById(formId);

            if (form) {
                form.submit();
            }
        }

        function uploadAvatar(input) {
            const file = input.files[0];

            if (file) {
                console.log(file);
                // Display the selected image
                var formId = "avatar-form";
                var form = document.getElementById(formId);

                if (form) {
                    form.submit();
                }
            }
        }        

    </script>

</body>
</html>
