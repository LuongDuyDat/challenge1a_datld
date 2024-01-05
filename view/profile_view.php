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
    </style>
</head>
<body>

    <?php require base_path('view/partition/header.php') ?>

    <div class="profile-container">
        <div class="profile-image">
            <img src="assets/images/default_avatar.jpg" alt="Avatar">
            <button class="avatar-button" onclick="saveProfile()">Change Avatar</button>
        </div>
        <div class="profile-information">
            
            <div class="edit-icon" onclick="editProfile()">
                <i class="fas fa-edit"></i>
            </div>
            <div class="profile-field">
                <span class="larger">John Doe</span>
            </div>
            <div class="profile-field">
                <label for="username"><i class="fas fa-user icon"></i>Username:</label>
                <span>john_doe</span>
            </div>
            <div class="profile-field">
                <label for="password"><i class="fas fa-key icon"></i>Password:</label>
                <span>******</span>
            </div>

            <div class="profile-field">
                <label for="email"><i class="fas fa-envelope icon"></i>Email:</label>
                <span>john.doe@example.com</span>
            </div>
            <div class="profile-field">
                <label for="phone"><i class="fas fa-phone-alt icon"></i>Phone:</label>
                <span>+1234567890</span>
            </div>
        </div>
    </div>

    <script>
        function saveProfile() {
            // Add logic to save profile data (for demonstration purposes only)
            alert('Profile saved!');
        }

        function editProfile() {
            // Add logic to handle profile editing (for demonstration purposes only)
            alert('Editing profile...');
        }
    </script>

</body>
</html>
