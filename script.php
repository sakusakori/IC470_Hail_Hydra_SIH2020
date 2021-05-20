<?php
require_once "utils.php";
$stmt=$conn->query('SELECT o.id FROM orders o INNER JOIN customers t ON o.customer=t.id WHERE o.transporter IS NULL ORDER BY t.city,t.zone,t.ward');
$rows=$stmt->fetch(PDO::FETCH_ASSOC);
$total=$stmt->rowCount();

?>