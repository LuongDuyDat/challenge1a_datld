<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href='css/login.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="text-logo">Learning Management</div>
    <?php
        //alert error message to user
        if(isset($errors["login"]) && $errors["login"] != '') {
            echo "<div class='error-login'><p>". $errors['login'] . "</p></div>";
        }
    ?>
    <div class="login-container">
        <h2>Đăng nhập</h2>
        <form class="login-form" method="POST" >
            <!--htmlspecialchars: make all input of user to literal -->
            <input name="username" type="text" placeholder="Tên đăng nhập" value=<?= htmlspecialchars($_POST['username'] ?? '')?>>
            <div class="error-message"><?= $errors['username'] ?? '' ?></div>
            <div class="password-container">
                <input name="password" id="password" type="password" placeholder="Mật khẩu" value=<?= htmlspecialchars($_POST['password'] ?? '')?>> 
                <i class="fa fa-eye password-toggle" onclick="togglePasswordVisibility()"></i>
            </div>
            <div class="error-message"><?= $errors['password'] ?? ''?></div>
            <button type="submit">Đăng nhập</button>
            
        </form>
    </div>
    <script src="js/login.js"></script>
</body>
</html>