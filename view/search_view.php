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
    <?php require base_path("view/partition/header.php")?>
    <div class="body">
        <div class="tile">
            <form method="POST">
                <div class="search-bar">
                    <input type="hidden" name="type" value="search">
                    <input name="search-input" class="search-input" type="text" placeholder="Search..." value=<?=$_POST['search-input'] ?? '' ?>>
                    <i class="fa fa-search search-icon"></i>
                    <button type="submit" class="search-button">Search</button>
                </div>
            </form>
            <form method="POST">
                <input type="hidden" name="type" value="search">
                <input type="hidden" name="search-input" value="">
                <button type="submit" class="show-all-text-button">Show all</button>
            </form>
            <table>
                <tr>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
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
    <script>
        function redirectToProfile(userId) {
            // Construct the URL with the user_id parameter
            var profileUrl = '/profile?user_id=' + userId;

            // Redirect to the profile page
            window.location.href = profileUrl;
        }
    </script>
</body>
</html>