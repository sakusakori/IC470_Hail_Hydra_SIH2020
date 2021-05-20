<?php
require_once "../utils.php";
check_session('customers');
function get_payment_link()
{
    $stmt=$GLOBALS['conn']->query('SELECT * FROM customers WHERE id='.$_SESSION['id']);
    $r=$stmt->fetch(PDO::FETCH_ASSOC);
    $ch = curl_init();
    $fields = array();
    $fields["type"] = 'link';
    $fields["amount"] = $_POST['price']*100;
    $fields["description"] = 'Payment for water tanker.';
    $fields["customer"] = array('name'=>$r['name'],'email'=>$r['email'],'contact'=>$r['phone']);
    $fields["currency"] = 'INR';
    $fields["expire_by"] = time()+3600;
    $fields["callback_url"] = $GLOBALS['p'].'/customers/process-payment.php';
    $fields["callback_method"] = 'get';
    curl_setopt($ch, CURLOPT_URL, 'https://api.razorpay.com/v1/invoices');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_USERPWD, "rzp_test_ucJmNTft2erwgJ:bMqrpkAVHF57AgI3ErclS7Ex");
    $headers = array();
    $headers[] = 'Accept: application/json';
    $headers[] = 'Content-Type: application/json';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $data = curl_exec($ch);

    if (empty($data) OR (curl_getinfo($ch, CURLINFO_HTTP_CODE != 200))) {
       return FALSE;
    } else {
        $d= json_decode($data, TRUE);
        $code=mt_rand(10000000,99999999);
        $code2=mt_rand(10000000,99999999);
        $stmt=execSQL('SELECT id FROM waterproviders WHERE state=? AND city=? AND zone=? AND ward=? AND status=1 ORDER BY RAND() LIMIT 1',array($r['state'],$r['city'],$r['zone'],$r['ward']));
        $w=$stmt->fetch(PDO::FETCH_ASSOC);
        $stmt=execSQL('SELECT id FROM transporter WHERE state=? AND city=? AND zone=? AND status=1 ORDER BY RAND() LIMIT 1',array($r['state'],$r['city'],$r['zone']));
        $x=$stmt->fetch(PDO::FETCH_ASSOC);
        $stmt=execSQL('INSERT INTO orders VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',array(null,$_SESSION['id'],$w['id'],$x['id'],$_POST['date'],$_POST['quantity'],$_POST['price'],$d['id'],'null',stripslashes($d['short_url']),$code,$code2,0,time(),0,0));
        $contents = file_get_contents('https://2factor.in/API/V1/28bf7ead-d473-11ea-9fa5-0200cd936042/SMS/+91'.$r['phone'].'/'.$code);
        $st=execSQL('UPDATE waterproviders SET availablewater=availablewater-? Where id=?',array($_POST['quantity'],$w['id']));
        return stripslashes($d['short_url']);
    }
    curl_close($ch);
    return false;
}
$data=get_payment_link();
if ($data!=FALSE)
{
    header('location:'.$data);
}
else
{
    $_SESSION['msg']='<div class="alert alert-danger">Error</div><br>';
    header('location:dashboard.php');
}
?>