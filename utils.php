<?php

$p='http://localhost/SIH2020_IC470_Hail_Hydra_GitRepository_MLRIT';

$salt1='';
$salt2='';

$headers = "From: admin@water.coolpage.biz";

$transportprice=100;
$waterprice=100;

session_start();

require_once "conn.php";

function msg()
{
    if(isset($_SESSION['msg']))
    {
        echo $_SESSION['msg'].'<br>';
        unset($_SESSION['msg']);
    }
}

function msg2()
{
    if(isset($_SESSION['msg']))
    {
        return $_SESSION['msg'].'<br>';
        unset($_SESSION['msg']);
    }
    return '';
}

function execSQL($a,$b)
{
    foreach($b as $c)
    $c=htmlentities($c);
    $stmt = $GLOBALS['conn']->prepare($a);
    $stmt->execute($b);
    return $stmt;
}

function login($a,$e,$p)
{
    $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=6LfHdrkZAAAAAOGHrvpFsT9m4sXRQf1QWf4TGYCJ&response=' . urlencode($_POST['g-recaptcha-response']));
    $responseKeys = json_decode($response,true);
    if(!$responseKeys["success"])
    {
        return '<div class="alert alert-danger alert-dismissible fade show">Captcha not filled.</div>';
    }
    $stmt=execSQL("SELECT id,name,status FROM ".$a." WHERE email=? AND password=?",array(htmlentities($e),hash('md5',$GLOBALS['salt1'].htmlentities($p).$GLOBALS['salt2'])));
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    if ( $row !== false ) {
        if($row['status']==0)
            {
                return '<div class="alert alert-primary alert-dismissible fade show">Please verify your email before login.</div>';
            }
        $_SESSION['type'] = $a;
        $_SESSION['name'] = $row['name'];
        $_SESSION['id'] = $row['id'];
        return true;
    }
    else
    {
        return '<div class="alert alert-danger alert-dismissible fade show">Invalid login credentials !</div>';
    }
}

function loginadmin($a,$e,$p)
{
    $stmt=execSQL("SELECT id,name FROM ".$a." WHERE email=? AND password=?",array(htmlentities($e),hash('md5',$GLOBALS['salt1'].htmlentities($p).$GLOBALS['salt2'])));
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    if ( $row !== false ) {
        $_SESSION['type'] = $a;
        $_SESSION['name'] = $row['name'];
        $_SESSION['id'] = $row['id'];
        return true;
    }
    else
    {
        $error= <<<_END
            <div class="alert alert-danger alert-dismissible fade show">Invalid login credentials !</div><br>
        _END;
        return $error;
    }
}

function check_session($a)
{
    if(isset($_SESSION['type']) && isset($_SESSION['id']) && $_SESSION['type']==$a)
    return true;
    else{
        header('location:login.php');
        exit(0);
    }
}

function sendmail($email,$sub,$msg)
{
    $headers = "From: admin@hakvilla.000webhostapp.com";
    mail($email,$sub,$msg,$headers);
}


?>