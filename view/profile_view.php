<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/profile.css">
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

    <!--Profile container-->
    <div class="profile-container">
        <!--Profile avatar-->
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
        <!--Profile information-->
        <div class="profile-information">
            <?php if ($editable_profile) : ?>
                <form id="editProfileForm" method="POST">
                    <input name="Save-profile" type="hidden">
                    <div class="edit-icon" <?=$_SESSION['role'] == Role::STUDENT ? "style='right: 20px;'" : '' ?> onclick="<?="editProfile({$_SESSION['role']})"?>">
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
                <?php if ($_SESSION['role'] == Role::TEACHER): ?>
                    <form id="deleteProfileForm" method="POST">
                        <input type="hidden" name="delete" value="">
                        <div class="delete-icon" onclick="deleteProfile()">
                            <i class="fas fa-trash-alt"></i>
                        </div>
                    </form>
                <?php endif; ?>    
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

        </ul>
    </div>

    <script src="js/profile.js"></script>

</body>
</html>
