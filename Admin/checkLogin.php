<?php
session_start();
if (!isset($_SESSION['AdminID'])) {
    echo "<script>
    alert('Please Login');
    window.location.assign('adminLogin.php');
    </script>";
}
