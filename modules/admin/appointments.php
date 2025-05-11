<?php
session_start();
ob_start();
include('../../connection/connection.php');
$first_name = $_SESSION['first_name'];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include '../../includes/styles.php' ?>
    <title>Document</title>
</head>
<style>
    .fc-button-primary{
        background: #50B6BB !important
    }
    .fc-event{
        background: #45969B;
    }
</style>
<body>
    <div class="wrapper">
      <?php include '../../includes/sidebar.php'; ?>
      <div class="main-panel">
        <?php include '../../includes/topbar.php'; ?>
        <div class="container">
          <div class="page-inner">
            <div class="page-header">
                <span class="d-flex justify-content-between align-items-center w-100">
                    <span class="d-flex">
                        <h4 class="page-title">Appointments</h4>
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
                            <a href="#">Appointments</a>
                            </li>
                        </ul>
                    </span>    

                    <a href="requests.php" class="btn btn-dark op-7">View All Requests</a>
                </span>
            </div>
            <div class="page-category">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card p-5">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php include "../../includes/scripts.php"; ?>
</body>
</html>