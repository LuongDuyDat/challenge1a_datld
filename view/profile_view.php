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
            text-align: center;
        }

        .profile-image img {
            width: 100%;
            max-width: 200px;
            height: auto;
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
        }

        .avatar-button:hover {
            background-color: #45a049;
        }

        .edit-icon {
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
    </style>
</head>
<body>

    <?php require base_path('view/partition/header.php') ?>

    <div class="profile-container">
        <div class="profile-image">
            <img src="assets/images/default_avatar.jpg" alt="Avatar">
            <?= $editable ? '<button class="avatar-button" onclick="saveProfile()">Change Avatar</button>' : '' ?>
        </div>
        <div class="profile-information">
            <?php if ($editable) : ?>
                <form id="editProfileForm" method="POST">
                    <input name="Save-profile" type="hidden">
                    <div class="edit-icon" onclick="<?="editProfile({$_SESSION['role']})"?>">
                        <i class="fas fa-edit"></i>
                    </div>
                    <div class="profile-field">
                        <label id="label-name" style="display: none;"><i class="fas fa-user icon"></i>Full Name:</label>
                        <span name="not-none" class="larger"><?=$profile['fullName']?></span>
                        <input name="fullName" type="text" class="edit-mode" style="display:none" value="<?=$profile['fullName'] ?>">
                    </div>
                    <div class="profile-field">
                        <label><i class="fas fa-user icon"></i>Username:</label>
                        <span name="not-none"><?=$account['username']?></span>
                        <input name="username" type="text" class="edit-mode" style="display:none" value="<?=$account['username']?>">
                    </div>
                    <div class="profile-field">
                        <label><i class="fas fa-key icon"></i>Password:</label>
                        <span><?=$account['password']?></span>
                        <input name="password" size="30" type="text" class="edit-mode" style="display:none" value="<?=$account['password']?>">
                    </div>

                    <div class="profile-field">
                        <label><i class="fas fa-envelope icon"></i>Email:</label>
                        <span><?=$profile['email']?></span>
                        <input name="email" type="text" class="edit-mode" style="display:none" value="<?=$profile['email']?>">
                    </div>
                    <div class="profile-field">
                        <label><i class="fas fa-phone-alt icon"></i>Phone:</label>
                        <span><?=$profile['phone']?></span>
                        <input name="phone" type="text" class="edit-mode" style="display:none" value="<?=$profile['phone']?>">
                    </div>
                </form>
            <?php else : ?>
                <div class="profile-field">
                    <label for="fullname" id="label-name" style="display: none;"><i class="fas fa-user icon"></i>Full Name:</label>
                    <span class="larger"><?=$profile['fullName']?></span>
                </div>

                <div class="profile-field">
                    <label for="email"><i class="fas fa-envelope icon"></i>Email:</label>
                    <span><?=$profile['email']?></span>
                </div>
                <div class="profile-field">
                    <label for="phone"><i class="fas fa-phone-alt icon"></i>Phone:</label>
                    <span><?=$profile['phone']?></span>
                </div>
            <?php endif ?>    
        </div>
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
    </script>

</body>
</html>
