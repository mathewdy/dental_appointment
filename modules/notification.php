<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/security.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$first_name = $_SESSION['first_name'];
?>

    <div class="wrapper">
      
        <?php 
        include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/sidebar.php');
        ?>

        <div class="main-panel">
            <?php
            include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/topbar.php');
            ?>
            <div class="container">
                <div class="page-inner">
                    <div class="page-header">
                        <span class="d-flex justify-content-between align-items-center w-100">
                            <span class="d-flex">
                                <h4 class="page-title">Notification</h4>
                                <ul class="breadcrumbs d-flex justify-items-center align-items-center">
                                    <li class="nav-home">
                                    <a href="dashboard.php">
                                        <i class="icon-home"></i>
                                    </a>
                                    </li>
                                    <li class="separator">
                                        <i class="icon-arrow-right"></i>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#">Notification</a>
                                    </li>
                                </ul>
                            </span>    
                        </span>
                    </div>
                    <div class="page-category">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card p-4">
                                    <div class="table-responsive">
                                        <table class="display table" id="notif-table">
                                          <thead>
                                            <tr>
                                                <th>Type</th>
                                                <th>Message</th>
                                                <th>Time</th>
                                            </tr>
                                          </thead>
                                          <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            <div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/scripts.php');
?>