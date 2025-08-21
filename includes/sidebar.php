<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/config.php');
$role = $_SESSION['role_id']; 
echo '
<div class="sidebar sidebar-style-2" data-background-color="dark">
    <div class="sidebar-logo">
        <div class="logo-header" data-background-color="dark">
        <a href="#" class="logo">
            <img
            src="' . BASE_PATH . '/assets/img/banner-2.png"
            alt="navbar brand"
            class="navbar-brand"
            height="40"
            /> 
        </a>
        <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
            <i class="gg-menu-right"></i>
            </button>
            <button class="btn btn-toggle sidenav-toggler">
            <i class="gg-menu-left"></i>
            </button>
        </div>
        <button class="topbar-toggler more">
            <i class="gg-more-vertical-alt"></i>
        </button>
    </div>
</div>
<div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
    <ul class="nav nav-secondary">
        <li class="nav-item">
            <a href="dashboard.php">
                <i class="fas fa-home"></i>
                <p>Home</p>
            </a>
        </li>
        ';

        if($role == 1){
                // Patient
                echo '
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                        </span>
                        <h4 class="text-section">Pages</h4>
                    </li>

                    <li class="nav-item">
                        <a href="appointments.php">
                            <i class="fas fa-calendar-alt"></i>
                            <p>Appointments</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="history.php">
                            <i class="fas fa-book"></i>
                            <p>History</p>
                        </a>
                    </li>
                    ';
            }
        if($role == 2){
            // Admin
            echo '
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                    <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Pages</h4>
                </li>
                <li class="nav-item">
                    <a href="appointments.php">
                        <i class="fas fa-calendar-alt"></i>
                        <p>Appointments</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="payments.php">
                        <i class="fas fa-dollar-sign"></i>
                        <p>Payments</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                    <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">User Management</h4>
                </li>
                <li class="nav-item">
                    <a href="view-dentists.php">
                        <i class="fas fa-user-md"></i>
                        <p>Dentists</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="patients.php">
                        <i class="fas fa-user-alt"></i>
                        <p>Patients</p>
                    </a>
                </li>

                ';
        }
        if($role == 3){
            // Dentists 
            echo '
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                    <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Pages</h4>
                </li>
                <li class="nav-item">
                    <a href="view-appointments.php">
                        <i class="fas fa-calendar-alt"></i>
                        <p>Appointments</p>
                    </a>
                </li>
                ';
            }
            
            echo '

    </ul>
    </div>
</div>
</div>
';
?>
