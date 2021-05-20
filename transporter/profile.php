<?php
require_once "../utils.php";
check_session('transporter');

$stmt=execSQL('SELECT * FROM transporter WHERE id=?',array($_SESSION['id']));
$x=$stmt->fetch(PDO::FETCH_ASSOC);

$title='Transporter Profile';
$content=<<<_END
<div class="card shadow mb-4 " style="width: min(700px,90%);margin: auto;">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Customer's Profile</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
            Name : {$x['name']}<br>
            Email : {$x['email']}<br>
            </div>
            <div class="col-md-6">
                
            </div>
        </div>
        <div class="text-center"><a href="dashboard.php" class="btn btn-success">Back to Dashboard</a></div>
    </div>
</div>
_END;
require_once "../templates/dash-temp.php";
?>
