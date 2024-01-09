<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homework</title>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-...." crossorigin="anonymous" />
    <link rel="stylesheet" href="../css/student_homework.css">
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
        <h1 class="mb-0">Bài tập: <?= $exercise['title']?></h2>
        <p class="italic mt-5">Giáo viên: <?= $teacher_name?></p>
        <div>
            <h2>Bài tập của <?=$student_name?></h2>
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
        </div>
    </div>

</body>
</html>
