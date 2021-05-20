<?php
$title='Homepage';
$content=<<<_END
<h2 style="text-align:center;">Water Distribution System 2.0</h2><br>
<div class="row">
    <div class="col-sm-6">
        <h3>Customers</h3>
        Welcome! 
        We are here to provide you water in the hour of need. The main idea of this system is to be able to utilise rainwater to its maximum and make it available to the people directly through our portal. 
        We take pride in the fact that this scheme could be a life saver if implemented properly in the cities its needed the most. 
        All we do is this,
        -Join hands with the institutions willing to contribute and provide them subsidy to setup the rainwater harvesting unit.
        - Make use of this harvested water to provide it to the people on demand.

        Make sure to join hands with us! That is, if you want your city to sustain.

    </div>
    <div class="col-sm-6" style="display: grid;place-items: centre;align-items: centre;justify-content: center;text-align: center;">
        <a href="customers/dashboard.php" class="btn btn-success btn-lg" style="text-align: center;">Book Tanker</a><br>
        <a href="user-instructions.php" class="btn btn-success btn-lg" style="text-align: center;">Check User Instructions</a><br>
        <a href="institute_information.php" class="btn btn-success btn-lg" style="text-align: center;">Check Institute Instructions</a><br>
    </div>
</div>
_END;
require_once "templates/template1.php";
?>
