<?php
require_once "../utils.php";
check_session('transporter');
if($_SERVER["REQUEST_METHOD"]== "POST" && isset($_POST['id']) && $_POST['id']!='' && isset($_POST['lat']) && $_POST['lat']!='' && isset($_POST['lng']) && $_POST['lng']!='')
{
    $stmt=execSQL('UPDATE transporter SET lat=?,lng=? WHERE id=?',array($_POST['lat'],$_POST['lng'],$_POST['id']));
    if($stmt->rowCount()==1)
    {
        echo json_encode(array('status'=>1,'message'=>'location saved'));
    }
    else
    {
        echo json_encode(array('status'=>0,'message'=>'Update ERROR!'));

    }
}
else
{
    echo json_encode(array('status'=>0,'message'=>'Error!'));
}
?>