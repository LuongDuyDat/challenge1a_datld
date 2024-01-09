<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homework</title>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-...." crossorigin="anonymous" />
    <link rel="stylesheet" href="../css/homework.css">
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
        <!-- Exercise Information -->
        <div id="exercise-head">
            <div class="title-container">
                <h2 class="mb-0">Bài tập: <?= $exercise['title']?></h2>
                <!--If user is the owner of this exercise, edit and delete button -->
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
        
        <!--Edit exercise -->
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
                        <input type="text" name="title" value="<?= $exercise['title']?>" required 
                            oninvalid="this.setCustomValidity('Mời bạn điền tiêu đề ')" oninput="this.setCustomValidity('')">
                    </div>
                    <div class="mb-20">
                        <label for="file">Chọn tệp:</label>
                        <input type="file" id="file" name="exercise-file" accept=".pdf, .docx, .zip, .tar" required
                            oninvalid="this.setCustomValidity('Mời bạn tải tệp lên')" oninput="this.setCustomValidity('')">
                    </div>
                    <div class="button-container">
                        <button type="submit"><i class="fas fa-upload"></i> Lưu</button>
                    </div>
                </form>
            </div>
        <?php endif; ?>

        <!-- User that is student can submit file -->
        <?php if ($_SESSION['role'] == Role::STUDENT) : ?>
            <h2>Nộp bài tập</h2>
            <form method="POST" enctype="multipart/form-data">
                <label for="file">Chọn tệp:</label>
                <input type="file" id="file" name="homework-file" accept=".pdf, .docx, .zip, .tar" required
                    oninvalid="this.setCustomValidity('Mời bạn tải tệp lên')" oninput="this.setCustomValidity('')">
                
                <button type="submit"><i class="fas fa-upload"></i> Nộp</button>
            </form>
        <?php endif; ?>    
        <!-- Student User: Show list of file that student user had been submitted for this exercise -->
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
                <!--Show list of student that submmited for this exercise -->
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
        //redirect to page that show the list filed one student had submitted
        function redirectToStudentHomework(id) {
            var url = "../homework/" + id;

            window.location.href = url;
        }

        //click on edit button
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

        //delete exercise
        function deleteExercise() {
            var form = document.getElementById('delete-exercise');

            if (form) {
                form.submit();
            }
        }

        //delete one homework file
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

        //click on delete icon on homework file tile
        function onClickDeleteIcon(index) {
            var deleteForm = document.getElementById('delete-form-' + index);

            if (deleteForm) {
                deleteForm.submit();
            }
        }

        //cancel the edit exercise process
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
