<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homework</title>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-...." crossorigin="anonymous" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #FFFFFF;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .file-tile {
            max-width: 250px;
            min-width: 300px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 10px;
            background-color: #f4f4f4;
            border-radius: 10px;
            margin-bottom: 40px;
        }

        .homework-tile {
            width: 220px;
            align-items: center;
            padding: 15px 10px;
            background-color: #f2f6fc;
            border-radius: 10px;
            margin-bottom: 10px;
            display: flex;
        }

        .file-info {
            display: flex;
            align-items: center;
            flex-grow: 1;
            max-width: 150px;
        }

        .file-icon {
            font-size: 20px;
            margin-right: 10px;
        }

        .file-name {
            font-size: 14px;
            overflow: hidden;
        }

        .download-icon {
            cursor: pointer;
            font-size: 20px;
            color: #3498db;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .size {
            font-size: 12px;
        }

        .italic {
            font-style: italic;
        }

        .list-item {
            display: flex; 
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .item {
            display: flex; 
            justify-content: space-between;
        }

        .mb-0 {
            margin-bottom: 0px;
        }

        .mt-5 {
            margin-top: 5px;
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
        <h2 class="mb-0">Exercise: <?= $exercise['title']?></h2>
        <p class="italic mt-5">Author: <?= $exercise['teacher_name']?></p>
        <div class="file-tile">
            <div class="file-info">
                <i class="fas fa-file file-icon"></i>
                <div class="file-name"><?=$exercise['name']?></div>
            </div>
            <div class="size"><?=formatBytes($exercise['size'])?></div>
            <a href="/<?= $exercise['file_path']?>" download="<?= $exercise['name']?>">
                <i class="fas fa-download download-icon"></i>
            </a>
        </div>
        <?php if ($_SESSION['role'] == Role::STUDENT) : ?>
            <h2>Submit Homework</h2>
            <form method="POST" enctype="multipart/form-data">
                <label for="file">Choose File:</label>
                <input type="file" id="file" name="homework-file" accept=".pdf, .docx, .zip, .tar" required>
                
                <button type="submit"><i class="fas fa-upload"></i> Upload</button>
            </form>
        <?php endif; ?>    
        <div>
            <h2>Homework List</h2>
            <?php if ($_SESSION['role'] == Role::STUDENT) : ?>
                <div class="list-item">
                    <?php foreach ($homework_files as $homework_file): ?>
                        <div class="file-tile">
                            <div class="file-info">
                                <i class="fas fa-file file-icon"></i>
                                <div class="file-name"><?=$homework_file['name']?></div>
                            </div>
                            <div class="size"><?=formatBytes($homework_file['size'])?></div>
                            <a href="/<?= $homework_file['file_path']?>" download="<?= $homework_file['name']?>">
                                <i class="fas fa-download download-icon"></i>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <div class="list-item">
                    <?php foreach ($homeworks as $homework): ?>
                        <div class="item" onclick="redirectToStudentHomework(<?=$homework['id']?>)">
                            <div class="homework-tile">
                                <i class="fas fa-folder file-icon"></i>
                                <div class="file-name"><?=$homework['studentName']?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>    
        </div>
    </div>

    <script>
        function redirectToStudentHomework(id) {
            var url = "../homework/" + id;

            window.location.href = url;
        }
    </script>

</body>
</html>
