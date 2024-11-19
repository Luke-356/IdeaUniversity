<div class="header">
    <a href="index.php" class="logo-wrap">
        <img src="../Images/logo.svg" alt="logo" id="logo">
    </a>

    <div class="nav-wrapper">
        <div class="nav-links">
            <div class="nav-hover" id="home">
                <img src="../Images/home.svg" alt="home-logo" id="home-icon">
                <label for="">Home</label>
            </div>
        </div>

        <div class="nav-links">
            <div class="nav-hover" id="register">
                <img src="../Images/register.svg" alt="home-logo" id="register-icon">
                <label for="">Register</label>
            </div>
        </div>

        <div class="nav-links">
            <div class="nav-hover" id="category">
                <img src="../Images/upload.svg" alt="home-logo" id="category-icon">
                <label for="">Category</label>
            </div>
        </div>

        <div class="nav-links">
            <div class="nav-hover" onclick="logConfirm()">
                <img src="../Images/sign-out-alt.svg" alt="home-logo" id="category-icon">
                <label for="">Logout</label>
            </div>
        </div>
    </div>
</div>

<script>
    const homeDirect = document.getElementById("home");
    homeDirect.addEventListener("click", () => {
        window.location.href = "index.php";
    });

    const registerDirect = document.getElementById("register");
    registerDirect.addEventListener("click", () => {
        window.location.href = "staffRegister.php";
    });

    const categoryDirect = document.getElementById("category");
    categoryDirect.addEventListener("click", () => {
        window.location.href = "addCategory.php";
    });

    logConfirm = () => {
        if (confirm("Are you sure you want to logout?")) {
            window.location.assign("logout.php");
        } else {
            return;
        }
    };
</script>