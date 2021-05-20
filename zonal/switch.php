<?php
require_once "../utils.php";
check_session('zonal');
if(isset($_GET['id']) && isset($_GET['switch']))
{
    if($_GET['switch']=='on')
    {
        execSQL('UPDATE transporter SET status=1 WHERE id=?',array($_GET['id']));
        header('location: dashboard.php');
    }
    else
    {
        execSQL('UPDATE transporter SET status=3 WHERE id=?',array($_GET['id']));
        header('location: dashboard.php');
    }
}
?>