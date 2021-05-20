<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-water"></i>
        </div>
        <div class="sidebar-brand-text mx-3">W.C.D.S</div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item <?php if(substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1)=='dashboard.php')echo " active" ?>">
        <a class="nav-link" href="dashboard.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <li class="nav-item<?php if(substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1)=='change-password.php')echo " active" ?>">
        <a class="nav-link" href="change-password.php">
            <i class="fas fa-fw fa-cog"></i>
            <span>Change Password</span></a>
    </li>
    <hr class="sidebar-divider d-none d-md-block">
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
