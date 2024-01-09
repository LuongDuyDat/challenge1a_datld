<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href='css/search.css'>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php require base_path("controller/partition/header_controller.php")?>
    <div class="body">
        <div class="tile">
            <form method="POST">
                <div class="search-bar">
                    <input type="hidden" name="type" value="search">
                    <input name="search-input" class="search-input" type="text" placeholder="Tìm kiếm..." value=<?=$_POST['search-input'] ?? '' ?>>
                    <i class="fa fa-search search-icon"></i>
                    <button type="submit" class="search-button">Tìm kiếm</button>
                </div>
            </form>
            <form method="POST">
                <input type="hidden" name="type" value="search">
                <input type="hidden" name="search-input" value="">
                <button type="submit" class="show-all-text-button">Xem tất cả</button>
            </form>
            <table>
                <tr>
                    <th>Họ và tên</th>
                    <th>Email</th>
                    <th>Điên thoại</th>
                </tr>
                <?php foreach ($users as $user): ?>
                    <tr onclick="redirectToProfile(<?=$user['id']?>)">
                        <td><?=$user["fullName"]?></td>
                        <td><?=$user["email"]?></td>
                        <td><?=$user["phone"]?> </td>
                    </tr>
                <?php endforeach ?>
            </table>
        </div>
    </div>
    <script src="js/search.js"></script>
</body>
</html>