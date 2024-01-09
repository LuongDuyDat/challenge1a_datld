<header>
    <nav class="navbar">
        <div class="title-and-nav">
            <div class="title">Learning Management</div>
            <ul class="nav-items">
                <li><a href="/home" class=<?=$heading == 'Home' ? "nav-button-on" : "nav-button"?>>Trang chủ</a></li>
                <li><a href="/exercise" class=<?=$heading == 'Exercise' ? "nav-button-on" : "nav-button"?>>Bài tập</a></li>
                <li><a href="/search" class=<?=$heading == 'Search' ? "nav-button-on" : "nav-button"?>>Tìm kiếm</a></li>
                <?php 
                    if (isset($_SESSION['role']) && $_SESSION['role'] == Role::TEACHER) {
                        $style = $heading == 'Add Student' ? 'nav-button-on' : 'nav-button';
                        echo "<li><a href='/student/add' class=$style >Thêm sinh viên</a></li>";
                    }
                ?>    
            </ul>
        </div>
        <div class="user-avatar" id="avatar">
            <img src="../<?= $avatar ?>" alt="User Avatar" width="50" height="50">
            <i class="fa fa-caret-down dropdown-icon fa-lg"></i>
            <div class="dropdown" id="dropdown">
                <a href="/profile">Trang cá nhân</a>
                <a href="/logout">Đăng xuất</a>
            </div>
        </div>
    </nav>
</header>

<script>

    //add listener when click to avatar
    document.addEventListener("DOMContentLoaded", function () {
        var avatar = document.getElementById("avatar");
        var dropdown = document.getElementById("dropdown");

        avatar.addEventListener("click", function (event) {
            event.stopPropagation(); // Prevents the click event from reaching the document

            dropdown.classList.toggle("show");
        });

        // Close the dropdown if the user clicks outside of it
        document.addEventListener("click", function (event) {
            if (!event.target.matches('.user-avatar') && !event.target.matches('.dropdown a')) {
                dropdown.classList.remove('show');
            }
        });
    });

</script>