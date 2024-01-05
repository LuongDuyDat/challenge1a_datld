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
        if(isset($errors["login"]) && $errors["login"] != '') {
            echo "<div class='error-login'><p>". $errors['login'] . "</p></div>";
        }
    ?>
    <div class="login-container">
        <h2>Login</h2>
        <form class="login-form" method="POST" >
            <input name="username" type="text" placeholder="Username" value=<?= htmlspecialchars($_POST['username'] ?? '')?>>
            <div class="error-message"><?= $errors['username'] ?? '' ?></div>
            <div class="password-container">
                <input name="password" id="password" type="password" placeholder="Password" value=<?= htmlspecialchars($_POST['password'] ?? '')?>> 
                <i class="fa fa-eye password-toggle" onclick="togglePasswordVisibility()"></i>
            </div>
            <div class="error-message"><?= $errors['password'] ?? ''?></div>
            <button type="submit">Login</button>
            
        </form>
    </div>
    <script>
        function togglePasswordVisibility() {
            var passwordField = document.getElementById('password');
            var passwordToggle = document.querySelector('.password-toggle');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                passwordToggle.classList.remove('fa-eye');
                passwordToggle.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                passwordToggle.classList.remove('fa-eye-slash');
                passwordToggle.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>