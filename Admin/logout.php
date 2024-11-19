<?php
session_start();
unset($_SESSION["AdminID"]);
echo "
<script>
window.location='adminLogin.php'
</script>";
