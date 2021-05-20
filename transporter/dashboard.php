<?php
require_once "../utils.php";
check_session('transporter');
if($_SERVER["REQUEST_METHOD"]== "POST" && isset($_POST['id']) && isset($_POST['otp']) && $_POST['id']!='' && $_POST['otp']!='')
{
    $stmt=execSQL('UPDATE orders SET status=2,deliverytime=? WHERE id=? AND cotp=? AND status=1',array(time(),$_POST['id'],$_POST['otp']));
    if($stmt->rowCount()==1)
    {
        $stmt=execSQL('SELECT quantity FROM orders WHERE id=?',array($_POST['id']));
        $s=$stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['msg']='<div class="alert alert-success alert-dismissible fade show">OTP verified successfully!<br>Quantity to be supplied: '.$s['quantity'].'</div>';
    }
}
$row=$conn->query('SELECT p.name as pn,p.address as pa,p.pincode as pp,dotp,p.phone as pph,c.name as cn,c.address as ca,c.pincode as cp,c.phone as cph,o.id as oid FROM orders o INNER JOIN customers c ON o.customer=c.id INNER JOIN waterproviders p ON o.provider=p.id WHERE o.status=1 AND o.date=CURDATE() AND o.transporter='.$_SESSION['id']);
$data='';
foreach($row as $r)
{
    $data.=<<<_END
        <div class="col-lg-6 mb-4">
            <div class="card bg-primary text-white shadow" style="height:100%;">
                <div class="card-body">
                    Fill At:<br>
                    {$r['pn']}<br>{$r['pa']}<br>{$r['pp']}<br>Contact - {$r['pph']}
                    <div class="font-weight-bold">OTP: {$r['dotp']}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card bg-white shadow" style="height:100%;">
                <div class="card-body">
                    Deliver To:<br>
                    {$r['cn']}<br>{$r['ca']}<br>{$r['cp']}<br>Contact - {$r['cph']}
                    <form method="post" action="">
                        <input name="id" type="hidden" value="{$r['oid']}">
                        <div class="input-group input-group-sm">
                            <input class="form-control" type="number" name="otp" placeholder="OTP" aria-label="OTP" aria-describedby="my-addon">
                            <div class="input-group-append">
                                <input type="submit" value="Submit" class="btn btn-success">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    _END;
}
$row=$conn->query('SELECT p.name as pn,p.address as pa,p.pincode as pp,dotp,p.phone as pph,c.name as cn,c.address as ca,c.pincode as cp,c.phone as cph FROM orders o INNER JOIN customers c ON o.customer=c.id INNER JOIN waterproviders p ON o.provider=p.id WHERE o.status=0 AND o.date=CURDATE() AND o.transporter='.$_SESSION['id']);
foreach($row as $r)
{
    $data.=<<<_END
        <div class="col-lg-6 mb-4">
            <div class="card bg-primary text-white shadow" style="height:100%;">
                <div class="card-body">
                    Fill At:<br>
                    {$r['pn']}<br>{$r['pa']}<br>{$r['pp']}<br>Contact - {$r['pph']}
                    <div class="font-weight-bold">OTP: {$r['dotp']}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card bg-white shadow" style="height:100%;">
                <div class="card-body">
                    Deliver To:<br>
                    {$r['cn']}<br>{$r['ca']}<br>{$r['cp']}<br>Contact - {$r['cph']}
                </div>
            </div>
        </div>
    _END;
}

$title='Transporter\'s Dashboard';
$content=<<<_END
<div class="card shadow mb-4 " style="width: min(1000px,90%);margin: auto;">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Current Orders</h6>
    </div>
    <div class="card-body row">
    {$data}
    </div>
</div>
<script>
      var track = {
        display : null,
        rider : {$_SESSION['id']},
        delay : 60000,
        timer : null,
        update : function () {
          navigator.geolocation.getCurrentPosition(function (pos) {
            // AJAX DATA
            var data = new FormData();
            data.append('id', track.rider);
            data.append('lat', pos.coords.latitude);
            data.append('lng', pos.coords.longitude);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', "track.php", true);
            xhr.onload = function () {
              console.log(this.response);
            };
            xhr.send(data);
          });
        }
      };
      window.addEventListener("load", function(){
        if (navigator.geolocation) {
          track.update();
          setInterval(track.update, track.delay);
        } else {
          alert("Geolocation is not supported by your browser!");
        }
      });
    </script>
_END;
require_once "../templates/dash-temp.php";
?>
?>