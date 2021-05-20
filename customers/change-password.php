<?php
require_once "../utils.php";
check_session('customers');
if($_SERVER['REQUEST_METHOD']=='POST')
{
    $stmt=execSQL('UPDATE customers SET password=? WHERE id=? and password=?',array(hash('md5',$salt1 . $_POST['new'] . $salt2),$_SESSION['id'],hash('md5',$salt1 . $_POST['old'] . $salt2)));
    if($stmt->rowCount()==1)
    {
        $_SESSION['msg']='<div class="alert alert-success alert-dismissible fade show">Password changed succesfully!</div>';
        header('location:dashboard.php');
        exit(0);
    }
    else 
    {
        $_SESSION['msg']='<div class="alert alert-danger">Entered current password is incorrect</div>';
    }
}
$title='Change Password';
$content=<<<_END
<div class="card shadow mb-4 " style="width: min(700px,90%);margin: auto;">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Change Password</h6>
    </div>
    <div class="card-body">
        <form method="POST" action="">
            <?php msg(); ?>
            <div class="form-group">
                <label for="old">Old Password :</label>
                <input id="old" class="form-control" type="password" name="old">
            </div>
            <div class="form-group">
                <label for="new">New Password :</label>
                <input id="new" class="form-control" type="password" name="new">
            </div>
            <div class="form-group">
                <label for="re">Retype Password :</label>
                <input id="re" class="form-control" type="password" name="re">
            </div>
            <input id="submit" type="submit" value="Change Password" class="btn btn-success">
            <a href="dashboard.php" class="btn">Cancel</a>
        </form>
    </div>
</div>
_END;
require_once "../templates/dash-temp.php";
?>