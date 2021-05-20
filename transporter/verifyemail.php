<?php
require_once "../utils.php";
if(isset($_GET['email']) && isset($_GET['key']) && !empty($_GET['email']) && !empty($_GET['key']))
{
    $email=htmlentities($_GET['email']);
    $key=htmlentities($_GET['key']);
    if($key==hash('md5',$GLOBALS['salt1'].$email.'providers'.$GLOBALS['salt2']))
    {
        execSQL('UPDATE transporter SET status=1 WHERE email=?',array($email));
        $_SESSION['msg']='<div class="alert alert-success">Email Successfully Verified.</div><br>';
        header('location: login.php');
        exit(0);
    }
}
else
header('location: ../index.php');
?>