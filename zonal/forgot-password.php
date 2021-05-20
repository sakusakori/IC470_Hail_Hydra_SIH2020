<?php
require_once "../utils.php";
if($_SERVER["REQUEST_METHOD"]== "POST" && isset($_POST['email']) && !empty($_POST['email']))
{
    $email=htmlentities($_POST['email']);
    $stmt=execSQL('SELECT Count(*) FROM zonal WHERE email=?',array($email));
    if($stmt->fetchColumn() >0)
    {
        $key=hash('md5',$salt1.$email.$salt2);
        mail($email,'Reset Password : http://water.coolpage.biz/zonal/reset-password.php?email=','Password Reset Link :
        http://water.coolpage.biz/zonal/reset-password.php?email='.$email.'&key='.$key,$headers);
        $_SESSION['msg']='<div class="alert alert-success">Password Reset Email sent.</div><br>';
    }
    else
    $_SESSION['msg']='<div class="alert alert-danger">Email doesn\'t exists our database, Please Sign Up .</div><br>';
}
$msg='';
if(isset($_SESSION['msg']))
    {
        $msg= $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
$title= 'Forgot Password';
$content= '
<div class="row">
    <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
    <div class="col-lg-6">
    <div class="p-5">
        <div class="text-center">
        <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
        '. $msg . <<<_END
        <p class="mb-4">We get it, stuff happens. Just enter your email address below and we'll send you a link to reset your password!</p>
        </div>
        <form class="user">
        <div class="form-group">
            <input type="email" name="email" class="form-control form-control-user" id="email" aria-describedby="emailHelp" placeholder="Enter Email Address...">
        </div>
        <input type="submit" value="Reset Password" class="btn btn-primary btn-user btn-block">
        </form>
        <hr>
        
        <div class="text-center">
        <a class="small" href="login.php">Already have an account? Login!</a>
        </div>
    </div>
    </div>
</div>
_END;
require_once "../templates/login-temp.php";
?>