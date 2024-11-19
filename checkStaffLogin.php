<?php
session_start();
if (!isset($_SESSION['StaffID'])) {
    echo "<script>
    alert('Please Login');
    window.location.assign('staffLogin.php');
    </script>";
}
