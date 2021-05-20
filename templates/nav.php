<?php
$rt='http://localhost/SIH2020_IC470_Hail_Hydra_GitRepository_MLRIT/';
?>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <a class="navbar-brand" href="#">W.D.S</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item<?php if($title=='Homepage')echo ' active';?>">
                    <a class="nav-link" href="<?=$rt?>">Home</a>
                </li>
                <li class="nav-item<?php if($title=='About Us')echo ' active';?>">
                    <a class="nav-link" href="<?=$rt?>about-us.php">About Us </a>
                </li>
                <li class="nav-item<?php if($title=='Contact Us')echo ' active';?>">
                    <a class="nav-link" href="<?=$rt?>contact-us.php">Contact Us </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Customers
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?=$rt?>customers/login.php">Login</a>
                        <a class="dropdown-item" href="<?=$rt?>customers/register.php">Register</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Water Providers
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?=$rt?>providers/login.php">Login</a>
                        <a class="dropdown-item" href="<?=$rt?>providers/register.php">Register</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>