<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercise Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #FFFFFF;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        form {
            margin-bottom: 20px;
        }

        #exerciseList {
            margin-top: 20px;
        }

        #list {
            list-style-type: none;
            padding: 0;
        }

        .list-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #ddd;
            padding: 10px;
        }

        .list-item i {
            margin-right: 10px;
            font-size: 20px;
        }

        .list-item:hover {
            cursor: pointer;
        }

        .file-info {
            display: flex;
            flex-direction: column;  /* This should be column */
            align-items: flex-start;
            margin-right: 10px;
        }

        .file-name {
            font-size: 18px;
            font-weight: bold;
            display: inline-block;
        }

        .size-uploader {
            display: contents;
            align-items: flex-end;
            text-align: right;
        }

        .uploader {
            font-size: 14px;
            color: #555;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .mb-20 {
            margin-bottom: 20px;
        }

        .button-container {
            text-align: center;
        }
    </style>
</head>
<body>

    <?php 
        if (isset($errors['file']) && $errors['file'] != '') {
            echo "<script>
            alert({$errors['file']}});
            </script>";
        }
    ?>

    <?php require base_path("controller/partition/header_controller.php")?>

    <div class="container">
        <?php if ($_SESSION['role'] == Role::TEACHER) : ?>
            <h1>Tạo bài tập</h1>
            <form id="uploadForm" method="POST" enctype="multipart/form-data">
                <div class="mb-20">
                    <label for="title">Tiêu đề:</label>
                    <input type="text" name="title" required 
                        oninvalid="this.setCustomValidity('Mời bạn điền tiêu đề ')" oninput="this.setCustomValidity('')">
                </div>
                <div class="mb-20">
                    <label for="file">Chọn tệp:</label>
                    <input type="file" id="file" name="exercise-file" accept=".pdf, .docx, .zip, .tar" required 
                        oninvalid="this.setCustomValidity('Mời bạn tải tệp lên')" oninput="this.setCustomValidity('')">
                </div>
                <div class="button-container">
                    <button type="submit"><i class="fas fa-upload"></i> Tạo</button>
                </div>
            </form>
        <?php endif; ?>    

        <div id="exerciseList">
            <h2>Danh sách bài tập</h2>
            <ul id="list">
                <?php foreach ($exercises as $exercise) : ?>
                    <li class="list-item" onclick="redirectToSpecifyExercise(<?=$exercise['id']?>)">
                        <div>
                            <i class="fas fa-tasks"></i>
                            <div class="file-name"><?=$exercise['title']?></div>
                        </div>
                            <div class="size-uploader">
                                <div class="uploader">đăng bởi <?=$exercise['teacher_name']?></div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <script>
        function redirectToSpecifyExercise(id) {
            // Construct the URL with the user_id parameter
            var url = '/exercise/' + id;

            // Redirect to the profile page
            window.location.href = url;
        }
    </script>
</body>
</html>
