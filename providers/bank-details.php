<?php
require_once "../utils.php";
check_session('waterproviders');
if($_SERVER['REQUEST_METHOD']=='POST')
{
    $stmt=execSQL('UPDATE waterproviders SET bank=?,bankaccount=?,ifsc=?,branch=? WHERE id=?',array($_POST['bank'],$_POST['account'],$_POST['ifsc'],$_POST['branch'],$_SESSION['id']));
    if($stmt->rowCount()==1)
    {
        $_SESSION['msg']='<div class="alert alert-success alert-dismissible fade show">Bank account details updated successfully!</div>';
        header('location:dashboard.php');
        exit(0);
    }
    else 
    {
        $_SESSION['msg']='<div class="alert alert-danger">Error</div>';
    }
}
$title='Update Bank Account Details';
$content=<<<_END
<div class="card shadow mb-4 " style="width: min(700px,90%);margin: auto;">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Update Bank Account Details</h6>
    </div>
    <div class="card-body">
        <form method="POST" action="">
            <?php msg(); ?>
            <div class="form-group">
                <label for="bank">Bank Name :</label>
                <input id="bank" class="form-control" type="text" name="bank">
            </div>
            <div class="form-group">
                <label for="account">Bank Account Number :</label>
                <input id="account" class="form-control" type="text" name="account">
            </div>
            <div class="form-group">
                <label for="ifsc">IFSC Code :</label>
                <input id="ifsc" class="form-control" type="text" name="ifsc">
            </div>
            <div class="form-group">
                <label for="branch">Branch Name :</label>
                <input id="branch" class="form-control" type="text" name="branch">
            </div>
            <input id="submit" type="submit" value="Update" class="btn btn-success">
            <a href="dashboard.php" class="btn">Cancel</a>
        </form>
    </div>
</div>
_END;
require_once "../templates/dash-temp.php";
?>