<?php
require_once "../utils.php";
check_session('customers');

$title='Customer\'s Dashboard';
$mindate=date('Y-m-d',time()+86400);
$maxdate=date('Y-m-d',time()+86400*3);

$stmt=$conn->query('SELECT * FROM customers WHERE id='.$_SESSION['id']);
$r=$stmt->fetch(PDO::FETCH_ASSOC);

$cooldown=false;

$stmt=execSQL('SELECT * FROM orders WHERE customer=? AND date>?',array($_SESSION['id'],date('Y-m-d',time()-86400*7)));
// $stmt2=execSQL('SELECT id FROM waterproviders WHERE state=? AND city=? AND zone=? AND ward=? ORDER BY RAND() LIMIT 1',array($r['state'],$r['city'],$r['zone'],$r['ward']));

if($stmt->rowCount()>0)
{
    $cooldown=true;
    $s=$stmt->fetch(PDO::FETCH_ASSOC);
    if($s['payment_id']=='null')
    {
        $_SESSION['msg']='<div class="alert alert-warning">Your last payment attemp was unsuccessful ! <a href="'.$s['url'].'">try again</a></div>';
    }
    $form=<<<_END
        Your last order was delivered on date: {$s['date']}<br>
        Your last innvoice id: {$s['invoice_id']}<br><br>
        Your OTP : <span class="text-lg">{$s['cotp']}</span><br><br>
        You can only book water tanker once every 7 days.
    _END;
}
else
{
    $form=<<<_END
        <form method="post" action="start-payment.php" name="bookwater">
            <div class="form-group">
                <label for="date">Date of Delivery:</label>
                <input id="date" class="form-control" type="date" name="date" required min="{$mindate}" max="{$maxdate}">
            </div>
            <div class="form-group">
                <label for="volume">Quantity of Water :</label>
            </div>
            <div class="form-check">
                <input id="i1" class="form-check-input" type="radio" name="quantity" value="1">
                <label for="i1" class="form-check-label">1 kL</label>
            </div>
            <div class="form-check">
                <input id="i2" class="form-check-input" type="radio" name="quantity" value="3">
                <label for="i2" class="form-check-label">3 kL</label>
            </div>
            <div class="form-check">
                <input id="i3" class="form-check-input" type="radio" name="quantity" value="6">
                <label for="i3" class="form-check-label">6 kL</label>
            </div>
            <input type="hidden" id="price" name="price" value="0">
            <br><br>
            <div class="form-group">
                <label for="price">Price : Rs. <span class="text-primary text-lg" id="pricespan">0</span> </label>
            </div>
            <div class="text-center"><input type="submit" value="Pay" class="btn btn-success"></div>
            <script>
                transportprice={$transportprice};
                waterprice={$waterprice};
                inp=document.getElementById("price");
                pspan=document.getElementById("pricespan");
                var radios = document.forms["bookwater"].elements["quantity"];
                for(var i = 0, max = radios.length; i < max; i++) {
                    radios[i].onclick = function() {
                        console.log(this.value);
                        inp.value=transportprice+waterprice*this.value;
                        pspan.innerHTML=transportprice+waterprice*this.value;
                    }
                }
            </script>
        </form>
    _END;
}





$msg='';
if(isset($_SESSION['msg']))
{
    $msg= $_SESSION['msg'].'<br>';
    unset($_SESSION['msg']);
}
$stmt=$conn->query('SELECT * FROM orders WHERE status=2 AND customer='.$_SESSION['id']);
$table='';
foreach($stmt as $x)
{
    $table.='<tr><td>'.$x['quantity'].'kL</td><td>Rs. '.$x['price'].'</td><td>'.$x['date'].'</td><td>'.$x['invoice_id'].'</td></tr>';
}
$content=<<<_END
{$msg}
<div class="row">
    <div class="col-md-6">
        <div class="card shadow mb-4 ">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Instructions</h6>
            </div>
            <div class="card-body">
                <p>Welcome! We are here to provide you water in the hour of need. The main idea of this system is to be able to utilise rainwater to its maximum and make it available to the people directly through our portal. We take pride in the fact that this scheme could be a life saver if implemented properly in the cities its needed the most. All we do is this, -Join hands with the institutions willing to contribute and provide them subsidy to setup the rainwater harvesting unit. - Make use of this harvested water to provide it to the people on demand. Make sure to join hands with us! That is, if you want your city to sustain.</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow mb-4 ">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">New Orders</h6>
            </div>
            <div class="card-body">
                {$form}
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card shadow mb-4 ">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">History</h6>
            </div>
            <div class="card-body">
                <table class="table table-light">
                    <thead class="thead-dark">
                        <tr>
                            <th>Volume</th>
                            <th>Price</th>
                            <th>Date</th>
                            <th>Invoice Id</th>
                        </tr>
                    </thead>
                    <tbody>
                        {$table}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

_END;
require_once "../templates/dash-temp.php";
?>