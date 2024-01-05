<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <link rel="stylesheet" href="css/header.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            text-align: center;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .h-50 {
            height: 50px;
        }

        h1 {
            color: #e74c3c;
        }

        p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        a {
            color: #3498db;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php 
        session_start(); 
        if ($_SESSION['logged'] == true) {
            require base_path("view/partition/header.php");
        }
    ?>
    <div class="h-50"> </div>
    <div class="container">
        <h1>403 - Forbidden</h1>
        <p>Access to this resource is denied. You don't have the necessary permissions to view this page.</p>
        <p>Return to <a href="/">home</a>.</p>
    </div>
</body>
</html>