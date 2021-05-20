<?php
$msg='';
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['g-recaptcha-response']))
{
  $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=6LfHdrkZAAAAAOGHrvpFsT9m4sXRQf1QWf4TGYCJ&response=' . urlencode($_POST['g-recaptcha-response']));
    $responseKeys = json_decode($response,true);
    if(!$responseKeys["success"])
    {
        $msg= '<div class="alert alert-danger alert-dismissible fade show">Captcha not filled.</div>';
    }
    else
    {
      require_once "utils.php";
      $stmt=execSQL("INSERT INTO feedback VALUES(?,?,?,?,?)",array(null,$_POST['name'],$_POST['email'],$_POST['invoiceid'],$_POST['feedback']));
      $msg= '<div class="alert alert-success alert-dismissible fade show">Form submitted successfully.</div>';
    }
}
$title='FeedBack';
$content=<<<_END
<h2 style="text-align:center;">FeedBack</h2>
{$msg}
<form method="post">
  <div class="form-group">
    <label for="name">Name</label>
    <input type="text" class="form-control" name="name" id="name" placeholder="Name" required>
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">Email address</label>
    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
  </div>
  <div class="form-group">
    <label for="orderNumber">Invoice Id</label>
    <input type="text" class="form-control" id="orderNumber" name="invoiceid" placeholder="order number" required>
  </div>
  <div class="form-group">
    <label for="exampleFormControlTextarea1">Your suggestions/feedback/complaints </label>
    <textarea class="form-control" name="feedback" id="exampleFormControlTextarea1" rows="3" placeholder="Type your response here..." required></textarea>
  </div>
  <div class="g-recaptcha" data-sitekey="6LfHdrkZAAAAAA4USEkqHpT0L5CF44KWq-Hz1k6C"></div>
  <br/>
  <input type="submit" value="Submit" class="btn btn-primary btn-lg">
</form>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
_END;
require_once "templates/template1.php";
?>
