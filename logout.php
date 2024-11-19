<?php
session_start();
unset($_SESSION["StaffID"]);
echo "
<script>
window.location='staffLogin.php'
</script>";
