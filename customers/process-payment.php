<?php
if(isset($_GET['razorpay_payment_id']) && isset($_GET['razorpay_invoice_id']) && isset($_GET['razorpay_invoice_receipt']) && isset($_GET['razorpay_invoice_status']) && isset($_GET['razorpay_signature']) && $_GET['razorpay_invoice_status']=='paid')
{
    if(hash_hmac('sha256',$_GET['razorpay_invoice_id'] . '|' . $_GET['razorpay_invoice_receipt'] . '|' . $_GET['razorpay_invoice_status'] . '|' . $_GET['razorpay_payment_id'],'bMqrpkAVHF57AgI3ErclS7Ex') == $_GET['razorpay_signature'])
    {
        require_once '../utils.php';
        $stmt=execSQL('UPDATE orders SET payment_id=? WHERE invoice_id=?',array($_GET['razorpay_payment_id'],$_GET['razorpay_invoice_id']));
        $_SESSION['msg']='<div class="alert alert-success">Payment successful !</div>';
        header('location:dashboard.php');
    }
}
?>