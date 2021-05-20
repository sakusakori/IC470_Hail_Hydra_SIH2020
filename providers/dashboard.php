<?php
require_once "../utils.php";
check_session('waterproviders');
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['waterupdate']) && isset($_POST['updated']) and $_POST['updated']!='')
{
    $stmt=execSQL('UPDATE waterproviders SET availablewater=? WHERE id=?',array($_POST['updated'],$_SESSION['id']));
    if($stmt->rowCount()==1)
    {
        $_SESSION['msg']='<div class="alert alert-success alert-dismissible fade show">Water availablity details updated successfully!</div>';
    }
}
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['otpsubmit']) && isset($_POST['otp']) and $_POST['otp']!='')
{
    $stmt=execSQL('UPDATE orders SET status=1,pickuptime=? WHERE dotp=? AND provider=? AND status=0',array(time(),$_POST['otp'],$_SESSION['id']));
    if($stmt->rowCount()==1)
    {
        $stmt=execSQL('SELECT quantity FROM orders WHERE dotp=? AND provider=?',array($_POST['otp'],$_SESSION['id']));
        $s=$stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['msg']='<div class="alert alert-success alert-dismissible fade show">OTP verified successfully!<br>Quantity to be supplied: '.$s['quantity'].'</div>';
    }
}
$stmt=$conn->query('SELECT availablewater FROM waterproviders WHERE id='.$_SESSION['id']);
$r=$stmt->fetch(PDO::FETCH_ASSOC);
$stmt2=$conn->query('SELECT date,SUM(quantity) AS sq FROM `orders` WHERE provider='.$_SESSION['id'].' AND date>=CURRENT_DATE() GROUP BY date');
$stmt3=$conn->query('SELECT SUM(quantity) AS sq,SUM(price-100) AS sp,count(*) as cnt FROM `orders` WHERE provider='.$_SESSION['id']);
$s=$stmt3->fetch(PDO::FETCH_ASSOC);
$stmt3=$conn->query('SELECT count(*) as cnt FROM `orders` WHERE status=0 AND provider='.$_SESSION['id']);
$s2=$stmt3->fetch(PDO::FETCH_ASSOC);
?>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Provider's Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

    <style type="text/css">
        /* Chart.js */
        
        @keyframes chartjs-render-animation {
            from {
                opacity: .99
            }
            to {
                opacity: 1
            }
        }
        
        .chartjs-render-monitor {
            animation: chartjs-render-animation 1ms
        }
        
        .chartjs-size-monitor,
        .chartjs-size-monitor-expand,
        .chartjs-size-monitor-shrink {
            position: absolute;
            direction: ltr;
            left: 0;
            top: 0;
            right: 0;
            bottom: 0;
            overflow: hidden;
            pointer-events: none;
            visibility: hidden;
            z-index: -1
        }
        
        .chartjs-size-monitor-expand>div {
            position: absolute;
            width: 1000000px;
            height: 1000000px;
            left: 0;
            top: 0
        }
        
        .chartjs-size-monitor-shrink>div {
            position: absolute;
            width: 200%;
            height: 200%;
            left: 0;
            top: 0
        }
    </style>
</head>

<body id="page-top" class="sidebar-toggled">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php require_once "../templates/provider-sidenav.php"; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php require_once "../templates/provider-topnav.php"; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Provider's Dashboard</h1>
                    </div>
                    <?php msg(); ?>
                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Water Dilivered</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$s['sq']?> kL</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Earnings</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">₹ <?=$s['sp']?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-rupee-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Orders</div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?=$s['cnt']?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Orders</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$s2['cnt']?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->

                    <!-- <div class="row">

                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-area">
                                        <div class="chartjs-size-monitor">
                                            <div class="chartjs-size-monitor-expand">
                                                <div class=""></div>
                                            </div>
                                            <div class="chartjs-size-monitor-shrink">
                                                <div class=""></div>
                                            </div>
                                        </div>
                                        <canvas id="myAreaChart" style="display: block; width: 981px; height: 400px;" width="981" height="400" class="chartjs-render-monitor"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Water Status</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <div class="chartjs-size-monitor">
                                            <div class="chartjs-size-monitor-expand">
                                                <div class=""></div>
                                            </div>
                                            <div class="chartjs-size-monitor-shrink">
                                                <div class=""></div>
                                            </div>
                                        </div>
                                        <canvas id="myPieChart" width="450" height="317" class="chartjs-render-monitor" style="display: block; width: 450px; height: 317px;"></canvas>
                                    </div>
                                    <div class="mt-4 text-center small">
                                        <span class="mr-2">
                        <i class="fas fa-circle text-success"></i> Delivered
                      </span>
                                        <span class="mr-2">
                        <i class="fas fa-circle text-warning"></i> Booked
                      </span>
                                        <span class="mr-2">
                        <i class="fas fa-circle text-primary"></i> Available
                      </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>--->

                    <div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-5 mb-4">

                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Current Orders</h6>
                                </div>
                                <div class="card-body row">
                                    <?php
                                    foreach($stmt2 as $x)
                                    {
                                        ?>
                                        <div class="col-lg-6 mb-4">
                                            <div class="card bg-info text-white shadow">
                                                <div class="card-body">
                                                    <?=$x['date']?>
                                                    <div class="font-weight-bold"><?=$x['sq']?> kL</div>
                                                    <div class="font-weight-bold">Rs. <?=$x['sq']*$waterprice?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 mb-4">
                        <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">OTP Verification</h6>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="" name="otpform">
                                        <div class="form-group">
                                            <label for="otp">OTP From transporter:</label>
                                            <input id="otp" class="form-control" type="number" name="otp" required>
                                        </div>
                                        <input type="submit" class="btn btn-success" value="Submit" name="otpsubmit">
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 mb-4">

                            <!-- Illustrations -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Water Availablity</h6>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="" name="waterform">
                                        <div class="form-group">
                                            <label for="current">Current water Availablity :</label>
                                            <input id="current" class="form-control" type="number" name="current" disabled value="<?=$r['availablewater']?>">
                                            <small class="form-text text-muted">In KiloLitre.</small>
                                        </div>
                                        <div class="form-group">
                                            <label for="updated">Updated water Availablity:</label>
                                            <input id="updated" class="form-control" type="number" name="updated" required>
                                        </div>
                                        <input type="submit" class="btn btn-success" value="Update" name="waterupdate">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php require_once "../templates/provider-footer.php"; ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/chart-area-demo.js"></script>
    <script src="../js/demo/chart-pie-demo.js"></script>

</body>
</html>