<?php
session_start();
$time = date('Y-m-d H:i:s');
$specificDuration = $_SESSION["duration"];

echo gmdate("H:i:s", $specificDuration);
