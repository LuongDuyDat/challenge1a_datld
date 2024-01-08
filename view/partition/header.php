<header>
    <nav class="navbar">
        <div class="title-and-nav">
            <div class="title">Learning Management</div>
            <ul class="nav-items">
                <li><a href="/home" class=<?=$heading == 'Home' ? "nav-button-on" : "nav-button"?>>Home</a></li>
                <li><a href="/exercise" class=<?=$heading == 'Exercise' ? "nav-button-on" : "nav-button"?>>Exercise</a></li>
                <li><a href="/search" class=<?=$heading == 'Search' ? "nav-button-on" : "nav-button"?>>Search</a></li>
                <?php 
                    if (isset($_SESSION['role']) && $_SESSION['role'] == Role::TEACHER) {
                        $style = $heading == 'Add Student' ? 'nav-button-on' : 'nav-button';
                        echo "<li><a href='/student/add' class=$style >Add Student</a></li>";
                    }
                ?>    
            </ul>
        </div>
        <div class="user-avatar" id="avatar">
            <img src="<?= $avatar ?>" alt="User Avatar" width="50" height="50">
            <div class="dropdown" id="dropdown">
                <a href="/profile">View Profile</a>
                <a href="/logout">Log Out</a>
            </div>
        </div>
    </nav>
</header>

<script>

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