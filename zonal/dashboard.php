<?php
require_once "../utils.php";
check_session('zonal');

$title='Zonal Office\'s Dashboard';

$stmt=$conn->query('SELECT * FROM transporter');

$data='';
foreach($stmt as $x)
{
    $btn='';
    if($x['status']==3)
    {
        $btn='<a href="switch.php?switch=on&id='.$x['id'].'" class="btn btn-success">allow</a>';
    }
    else
    {
        $stmt=execSQL('SELECT id FROM transporter WHERE state=? AND city=? AND zone=? AND status=1',array($x['state'],$x['city'],$x['zone']));
        if($stmt->rowCount()>1)
        {
            $btn='<a href="switch.php?switch=off&id='.$x['id'].'" class="btn btn-warning">revoke</a>';
        }
    }
    $data.='<tr>
    <td>'.$x['id'].'</td>
    <td>'.$x['name'].'</td>
    <td>'.$x['email'].'</td>
    <td>'.$x['city'].'</td>
    <td>'.$x['zone'].'</td>
    <td><a href="http://maps.google.com/maps?q='.$x['lat'].','.$x['lng'].'" target="_blank">Google Maps</a></td>
    <td>'.$btn.'</td>
</tr>';
}


$msg='';
if(isset($_SESSION['msg']))
{
    $msg= $_SESSION['msg'].'<br>';
    unset($_SESSION['msg']);
}
$content=<<<_END
{$msg}
<div class="row">
    <div class="col-md-12">
        <div class="card shadow mb-4 ">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Transporter</h6>
            </div>
            <div class="card-body">
                <table class="table table-light">
                    <thead class="thead-dark">
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>City</th>
                            <th>Zone</th>
                            <th>location Id</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {$data}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
_END;
require_once "../templates/dash-temp.php";
?>