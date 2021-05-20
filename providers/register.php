<?php
require_once "../utils.php";

function signupO()
{
    $var=array('name','email','phone','password','address','state','city','pincode','zone','ward');
    $a=array(null);
    foreach($var as $v)
    {
        if(!isset($_POST[$v]) || empty($_POST[$v]))
        return $v.' not filled.';
        if($v=='password')
        {
            array_push($a,hash('md5',$GLOBALS['salt1'].$_POST['password'].$GLOBALS['salt2']));
        }
        else
        array_push($a,$_POST[$v]);
    }

    $email=htmlentities($_POST['email']);
    $stmt=execSQL('SELECT status FROM waterproviders WHERE email=?',array($email));
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    if ( $row !== false )
    {
        $status=$row['status'];
        if($status==1)
        {
            $_SESSION['msg']='<div class="alert alert-danger">This email already exists in our database please log in.</div><br>';
            header('location: login.php');
            exit(0);
        }
        elseif($status==2)
        {
            $_SESSION['msg']='<div class="alert alert-danger">Your account is blocked by admin.Please contact us on <a href="../contactus.php">Contact Us</a> page.</div><br>';
            header('location: login.php');
            exit(0);
        }
        elseif($status==0)
        {
            $_SESSION['msg']='<div class="alert alert-danger">Your account already exists in our databse but You have not verified your email.Please verify your email.</div><br>';
            header('location: login.php');
            exit(0);
        }
    }
    $key=hash('md5',$GLOBALS['salt1'].$email.'providers'.$GLOBALS['salt2']);
    array_push($a,0,0,0);
    $stmt=execSQL("INSERT INTO waterproviders VALUES(?,?,?,?,?,?,?,?,?,?,?,?)",$a);
    mail($email,'Confirmation Email : WDS.com','If You have Signed Up for WDS please verify you account by going to following link:<br><br>
http://wds.com/organisers/verifyemail.php?email='.$email.'&key='.$key.'

If you haven\'t signed up at our site please ignore this email.We wont bother You with any other mail.',$headers);
    return 1;
}

if($_SERVER["REQUEST_METHOD"]== "POST")
{
    $x=signupO();
    if($x==1)
    {
        $_SESSION['msg']='<div class="alert alert-success">You are successfully registerd! Please verify your email by going to verification link sent to your email.</div><br>';
        header('location: login.php');
        exit(0);
    }
    else
    {
        $_SESSION['msg']='<div class="alert alert-danger alert-dismissible fade show">'.$x.'</div><br>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Water Provider Register</title>

  <!-- Custom fonts for this template-->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">
  <link href="../css/nav.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">
  <?php require_once "../templates/nav.php"; ?>
  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
          <div class="col-lg-7">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                <?php
                if(isset($_SESSION['msg']))echo $_SESSION['msg'];
                ?>
              </div>
              <form class="user" method="POST">
                <div class="form-group">
                  <input type="text" name="name" class="form-control form-control-user" id="name" placeholder="Name">
                </div>
                <div class="form-group">
                  <input type="email" name="email" class="form-control form-control-user" id="email" placeholder="Email Address">
                </div>
                <div class="form-group">
                  <input type="text" name="phone" class="form-control form-control-user" id="phone" placeholder="Phone Number">
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="password" name="password" class="form-control form-control-user" id="password" placeholder="Password">
                  </div>
                  <div class="col-sm-6">
                    <input type="password" name="re_password" class="form-control form-control-user" id="re_password" placeholder="Repeat Password">
                  </div>
                </div>
                <div class="form-group">
                  <input type="text" name="address" class="form-control form-control-user" id="address" placeholder="Your Address">
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <select type="text" name="state" class="form-control" id="state" onchange="print_city('city', this.selectedIndex);">
                      <option value="">Select State</option>
                    </select>
                  </div>
                  <div class="col-sm-6">
                    <select type="text" name="city" class="form-control" id="city">
                      <option value="">Select City</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" name="zone" class="form-control form-control-user" id="zone" placeholder="Zone">
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="ward" class="form-control form-control-user" id="ward" placeholder="Ward">
                  </div>
                </div>
                <div class="form-group">
                  <input type="text" name="pincode" class="form-control form-control-user" id="pincode" placeholder="Area Pincode">
                </div>
                <input type="submit" value="Register Account" class="btn btn-primary btn-user btn-block">
              </form>
              <hr>
              <div class="text-center">
                <a class="small" href="forgot-password.php">Forgot Password?</a>
              </div>
              <div class="text-center">
                <a class="small" href="login.php">Already have an account? Login!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="../js/cities.js"></script>
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../js/sb-admin-2.min.js"></script>
  <script type="text/javascript">
    function check() {
        if($('input[name="password"]').val()!=$('input[name="re_password"]').val())
        {
            alert('Password and Retyped Password do not match.');
            return false;
        }
        return true;
    }
    print_state("state");
    </script>

</body>

</html>
