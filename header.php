<nav>
    <div class="container">
        <div class="left-menu">
            <a href="index.php"><img src="./Images/logo.svg" alt="logo" id="logo"></a>
            <div class="open-menu">
                <i class="fa-solid fa-bars"></i>
            </div>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="#">Topics</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>

        <div class="right-menu">
            <li><a onclick="logConfirm()" style="cursor: pointer;">Logout</a></li>
        </div>
    </div>
</nav>

<script>
    logConfirm = () => {
        if (confirm("Are you sure you want to logout?")) {
            window.location.assign("logout.php");
        } else {
            return;
        }
    };
</script>