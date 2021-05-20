<?php
require_once "../utils.php";
if($_SERVER["REQUEST_METHOD"]== "POST" && isset($_POST['email']) && isset($_POST['password']) && !empty($_POST['email']) && !empty($_POST['password']) && isset($_POST['g-recaptcha-response']))
{
    $x=login('zonal',$_POST['email'],$_POST['password']);
    if($x!==true)
    {
        $_SESSION['msg']=$x;
    }
    else
    {
        header('location:dashboard.php');
        exit(0);
    }
}
$msg='';
if(isset($_SESSION['msg']))
    {
        $msg= $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
$title= 'Zonal Office Login';
$content= '
<div class="row">
  <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
  <div class="col-lg-6">
    <div class="p-5">
      <div class="text-center">
      <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
      '. $msg . <<<_END
      </div>
      <form class="user" method="POST">
        <div class="form-group">
          <input type="email" name="email" class="form-control form-control-user" id="email" aria-describedby="emailHelp"
            placeholder="Enter Email Address..." />
        </div>
        <div class="form-group">
          <input type="password" name="password" class="form-control form-control-user" id="password"
            placeholder="Password" />
        </div>
        <div class="form-group">
          <div class="custom-control custom-checkbox small">
            <input type="checkbox" class="custom-control-input" id="customCheck" name="remember" />
            <label class="custom-control-label" for="customCheck">Remember Me</label>
          </div>
        </div>
        <div class="g-recaptcha" data-sitekey="6LfHdrkZAAAAAA4USEkqHpT0L5CF44KWq-Hz1k6C"></div>
        <br>
        <input type="submit" value="Login" href="index.html" class="btn btn-primary btn-user btn-block">
      </form>
      <hr />
      <div class="text-center">
        <a class="small" href="forgot-password.php">Forgot Password?</a>
      </div>
      
    </div>
  </div>
</div>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
_END;
require_once "../templates/login-temp.php";
?>