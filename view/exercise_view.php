<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercise Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/exercise.css">
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
        <!--Form for teacher to upload new exercise -->
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

        <!-- Exercise List -->
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

    <script src="js/exercise.js"></script>
</body>
</html>
