<?php 
session_start();
$_SESSION['role'] == "";
$_SESSION['user_code'] == "";
header("Location: login.php");
// destroy the session
session_destroy();
?>