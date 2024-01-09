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

        .delete-icon {
            cursor: pointer;
            font-size: 20px;
            color: red;
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
            cursor: pointer;
        }

        .mb-0 {
            margin-bottom: 0px;
        }

        .mt-5 {
            margin-top: 5px;
        }

        .title-container {
            display: flex;
            justify-content: space-between;
        }

        .center {
            align-self: center;
        }

        .ml-10 {
            margin-left: 10px;
        }

        .icon {
            font-size: 20px;
            cursor: pointer;
        }

        .inline-block {
            display: inline-block;
        }

        .display-none {
            display: none;
        }

        .cancel-button {
            color: red;
            cursor: pointer;
        }

        .ok-button {
            color: #3498db;
            cursor: pointer;
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
        <div id="exercise-head">
            <div class="title-container">
                <h2 class="mb-0">Bài tập: <?= $exercise['title']?></h2>
                <?php if ($_SESSION['role'] == Role::TEACHER && $_SESSION['id'] == $exercise['teacher_id']): ?>
                    <div class="center">
                        <i class="fas fa-edit icon" id="first-icon" onclick="editExercise()"></i>
                        <form id="delete-exercise" class="inline-block" method="POST">
                            <input type="hidden" name="delete">
                            <i class="ml-10 fas fa-trash-alt icon" id="second-icon" onclick="deleteExercise()"></i>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
            <p class="italic mt-5">Giáo viên: <?= $exercise['teacher_name']?></p>
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
        </div>
        
        <?php if ($_SESSION['role'] == Role::TEACHER && $_SESSION['id'] == $exercise['teacher_id']) : ?>
            <div class="display-none" id="edit-exercise">
                <div class="title-container">
                    <h2>Chỉnh sửa bài tập</h2>
                    <div class="center" id="cancel">
                        <p class="cancel-button" onclick="cancel()">Huỷ</p>
                    </div>
                </div>
                <form id="editForm" method="POST" enctype="multipart/form-data">
                    <div class="mb-20">
                        <label for="title">Tiêu đề:</label>
                        <input type="text" name="title" value="<?= $exercise['title']?>" required>
                    </div>
                    <div class="mb-20">
                        <label for="file">Chọn tệp:</label>
                        <input type="file" id="file" name="exercise-file" accept=".pdf, .docx, .zip, .tar" required>
                    </div>
                    <div class="button-container">
                        <button type="submit"><i class="fas fa-upload"></i> Lưu</button>
                    </div>
                </form>
            </div>
        <?php endif; ?>

        <?php if ($_SESSION['role'] == Role::STUDENT) : ?>
            <h2>Nộp bài tập</h2>
            <form method="POST" enctype="multipart/form-data">
                <label for="file">Chọn tệp:</label>
                <input type="file" id="file" name="homework-file" accept=".pdf, .docx, .zip, .tar" required>
                
                <button type="submit"><i class="fas fa-upload"></i> Nộp</button>
            </form>
        <?php endif; ?>    
        <div>
            <?php if ($_SESSION['role'] == Role::STUDENT) : ?>
                <div class="title-container">
                    <h2>Danh sách bài tập của bạn</h2>
                    <div class="center" id="cancel">
                        <p id="delete-homework-button" class="cancel-button" onclick="homeworkDelete(<?=count($homework_files)?>)">Xoá</p>
                    </div>
                </div>
                <div class="list-item">
                    <?php for ($i = 0; $i < count($homework_files); $i++): ?>
                        <?php $homework_file = $homework_files[$i] ?>
                        <div class="file-tile">
                            <div class="file-info">
                                <i class="fas fa-file file-icon"></i>
                                <div class="file-name"><?=$homework_file['name']?></div>
                            </div>
                            <div class="size"><?=formatBytes($homework_file['size'])?></div>
                            <a id="download-form-<?=$i?>" href="/<?= $homework_file['file_path']?>" download="<?= $homework_file['name']?>">
                                <i class="fas fa-download download-icon"></i>
                            </a>
                            <form id="delete-form-<?=$i?>" method="POST" class="display-none" onclick="onClickDeleteIcon(<?=$i?>)">
                                <input type="hidden" name="delete-homework-file-id" value="<?=$homework_file['id']?>">
                                <i class="fas fa-trash-alt delete-icon"></i>
                            </form>
                        </div>
                    <?php endfor; ?>
                </div>
            <?php else : ?>
                <h2>Danh sách bài tập của học sinh</h2>
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

        function editExercise() {
            var editExercise = document.getElementById('edit-exercise');
            var exerciseHead = document.getElementById('exercise-head');

            if (editExercise) {
                if (editExercise.classList.contains('display-none')) {
                    editExercise.classList.remove('display-none');
                }
            }

            if (exerciseHead) {
                if (!exerciseHead.classList.contains('display-none')) {
                    exerciseHead.classList.add('display-none');
                }
            }

        }

        function deleteExercise() {
            var form = document.getElementById('delete-exercise');

            if (form) {
                form.submit();
            }
        }

        function homeworkDelete(length) {
            var deleteHomeworkButton = document.getElementById('delete-homework-button');

            if (deleteHomeworkButton) {
                deleteHomeworkButton.innerHTML = deleteHomeworkButton.innerHTML == 'Xoá' ? 'Xong' : 'Xoá';

                if (deleteHomeworkButton.classList.contains('cancel-button')) {
                    deleteHomeworkButton.classList.remove('cancel-button');
                    deleteHomeworkButton.classList.add('ok-button');
                } else {
                    deleteHomeworkButton.classList.remove('ok-button');
                    deleteHomeworkButton.classList.add('cancel-button');
                }
            }

            for (let i = 0; i < length; i++) {
                var downloadForm = document.getElementById('download-form-' + i);
                var deleteForm = document.getElementById('delete-form-' + i);

                if (downloadForm && deleteForm) {
                    if (downloadForm.classList.contains('display-none')) {
                        downloadForm.classList.remove('display-none');
                        deleteForm.classList.add('display-none');
                    } else {
                        downloadForm.classList.add('display-none');
                        deleteForm.classList.remove('display-none');
                    }
                }
            }
        }

        function onClickDeleteIcon(index) {
            var deleteForm = document.getElementById('delete-form-' + index);

            if (deleteForm) {
                deleteForm.submit();
            }
        }

        function cancel() {
            var editExercise = document.getElementById('edit-exercise');
            var exerciseHead = document.getElementById('exercise-head');

            if (editExercise) {
                if (!editExercise.classList.contains('display-none')) {
                    editExercise.classList.add('display-none');
                }
            }

            if (exerciseHead) {
                if (exerciseHead.classList.contains('display-none')) {
                    exerciseHead.classList.remove('display-none');
                }
            }

        }
    </script>

</body>
</html>
