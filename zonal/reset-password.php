<?php
require_once "../utils.php";
if($_SERVER["REQUEST_METHOD"]== "POST" && isset($_POST['password']) && !empty($_POST['password']) && isset($_POST['repassword']) && !empty($_POST['repassword']) && $_POST['password']==$_POST['repassword'] && isset($_SESSION['email']))
{
    $pwd=hash('md5',$salt1.htmlentities($_POST['password']).$salt2);
    $stmt=execSQL('UPDATE zonal SET password=? WHERE email=?',array($pwd,$_SESSION['email']));
    $_SESSION['msg']='<div class="alert alert-success">Password successfully changed.</div><br>';
    unset($_SESSION['email']);
    header('location: login.php');
    return;
}
if(isset($_GET['email']) && isset($_GET['key']) && !empty($_GET['email']) && !empty($_GET['key']))
{
    $email=htmlentities($_GET['email']);
    $key=htmlentities($_GET['key']);
    if($key==hash('md5',$salt1.$email.$salt2))
    {
        $_SESSION['email']=$email;
    }
    else
    {
        header('location: login.php');
        exit(0);
    }
}
else
{
    header('location: login.php');
    exit(0);
}
$title= 'Set a new Password';
$content= <<<_END
<div class="row">
    <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
    <div class="col-lg-6">
    <div class="p-5">
        <div class="text-center">
        <h1 class="h4 text-gray-900 mb-2">Reset Your Password?</h1>
        </div>
        <br>
        <form class="user">
        <div class="form-group">
            <input class="form-control form-control-user" type="password" name="password" placeholder="Your secure password" aria-label="Your secure password" aria-describedby="password" required>
        </div>
        <div class="form-group">
            <input class="form-control form-control-user" type="password" name="repassword" placeholder="Retype your password" aria-label="Retype your password" aria-describedby="repassword" required>
        </div>
        <input type="submit" value="Reset Password" class="btn btn-primary btn-user btn-block">
        </form>
        <hr>
        <div class="text-center">
        <a class="small" href="register.php">Create an Account!</a>
        </div>
        <div class="text-center">
        <a class="small" href="login.php">Already have an account? Login!</a>
        </div>
    </div>
    </div>
</div>
_END;
require_once "../templates/login-temp.php";
?>