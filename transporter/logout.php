<?php
session_start();
unset($_SESSION['type']);
unset($_SESSION['name']);
unset($_SESSION['id']);
$_SESSION['msg']='<div class="alert alert-success alert-dismissible fade show">Successfully Logged Out.</div><br>';
header('Location: login.php');
?>