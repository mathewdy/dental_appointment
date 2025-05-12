<?php
include('../../connection/connection.php');
ob_start();
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$first_name = $_SESSION['first_name'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include '../../includes/styles.php'; ?>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <title>Document</title>
</head>
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
                        <h4 class="page-title">Add Appointment</h4>
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
                            <a href="patients.php">Patient</a>
                            </li>
                            <li class="separator">
                            <i class="icon-arrow-right"></i>
                            </li>
                            <li class="nav-item">
                            <a href="#">Set Doctor</a>
                            </li>
                        </ul>
                    </span>    
                </span>
            </div>
            <div class="page-category">
                <div class="card p-5">
                    <div class="table-responsive">
                        <table class="display table table-hover table-striped table-bordered" id="dataTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Schedule</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <?php

                                    if(isset($_GET['user_id_patient'])){
                                        $user_id_patient = $_GET['user_id_patient'];

                                        $query_dentist = "SELECT users.user_id AS user_id, users.first_name AS first_name, users.middle_name AS middle_name, users.last_name AS last_name, users.mobile_number AS mobile_number, users.email AS email, schedule.user_id AS schedule_user_id, schedule.day AS day , schedule.start_time AS start_time , schedule.end_time AS end_time
                                        FROM users 
                                        LEFT JOIN schedule 
                                        ON users.user_id = schedule.user_id 
                                        WHERE users.role_id = '3'";

                                        $run_dentist = mysqli_query($conn, $query_dentist);
                                        $all_dentists = mysqli_fetch_all($run_dentist, MYSQLI_ASSOC);
                                        foreach ($all_dentists as $row_dentist) {
                                        ?>

                                            <form action="" method="GET">
                                                <tr>
                                                    <td><?php echo "Dr. " . $row_dentist['first_name'] . " " . $row_dentist['last_name']?></td>
                                                    <td><?php echo $row_dentist['day']. " " . date("g:i A",strtotime($row_dentist['start_time'])) . " - " . date("g:i A", strtotime($row_dentist['end_time']))?></td>
                                                    <td>
                                                    <a href="set-schedule.php?user_id_dentist=<?php echo $row_dentist['user_id']; ?>&user_id_patient=<?php echo $user_id_patient; ?>">Select</a>

                                                    </td>
                                                </tr>
                                            </form>

                                            <?php
                                        }

                                    }



                                    ?>
                            </tbody>
                        </table>
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
