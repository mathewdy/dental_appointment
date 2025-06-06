<?php
include('../../connection/connection.php');
ob_start();
session_start();
$first_name = $_SESSION['first_name'];
$user_id_patient = $_SESSION['user_id'];
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('../../includes/security.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include '../../includes/styles.php'; ?>
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
                    <span>
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#doctorModal">Add Appointment</a>
                        <a href="requests.php" class="btn btn-dark op-7">View All Requests</a>
                    </span>
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
    <div class="modal fade" id="doctorModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Dentists</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <form action="" method="POST">

                        <table class="table" id="dataTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Schedule</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $query_dentist = "SELECT users.user_id AS user_id, users.first_name AS first_name, users.middle_name AS middle_name, users.last_name AS last_name, users.mobile_number AS mobile_number, users.email AS email, schedule.user_id AS schedule_user_id, schedule.day AS day , schedule.start_time AS start_time , schedule.end_time AS end_time
                                    FROM
                                    users 
                                    LEFT JOIN schedule 
                                    ON users.user_id = schedule.user_id 
                                    WHERE users.role_id = '3'";
                                    $run_dentist = mysqli_query($conn,$query_dentist);
                                    while($row_dentist = mysqli_fetch_assoc($run_dentist)){
                                        ?>
                                            <tr>
                                                <td><?php echo $row_dentist['first_name']. " " . $row_dentist['last_name']?>
                                                </td>
                                                <td>
                                                    <?php 
                                                        $start = date("g:i A", strtotime($row_dentist['start_time']));
                                                        $end = date("g:i A", strtotime($row_dentist['end_time']));
                                                        echo $row_dentist['day'] . " " . $start . " - " . $end;
                                                    ?>
                                                </td>
                                                <td>
                                                    <input type="hidden" id="date">
                                                    <a href="select-dentist.php?user_id=<?php echo $row_dentist['user_id']?>" >Select</a>
                                                </td>
                                            </tr>
                                        <?php
                                    }
                                    ?>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="doctorModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Dentists</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <form action="" method="POST">

                        <table class="table" id="dataTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Schedule</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $query_dentist = "SELECT users.user_id AS user_id, users.first_name AS first_name, users.middle_name AS middle_name, users.last_name AS last_name, users.mobile_number AS mobile_number, users.email AS email, schedule.user_id AS schedule_user_id, schedule.day AS day , schedule.start_time AS start_time , schedule.end_time AS end_time
                                    FROM
                                    users 
                                    LEFT JOIN schedule 
                                    ON users.user_id = schedule.user_id 
                                    WHERE users.role_id = '3'";
                                    $run_dentist = mysqli_query($conn,$query_dentist);
                                    while($row_dentist = mysqli_fetch_assoc($run_dentist)){
                                        ?>
                                            <tr>
                                                <td><?php echo $row_dentist['first_name']. " " . $row_dentist['last_name']?>
                                                </td>
                                                <td>
                                                    <?php 
                                                        $start = date("g:i A", strtotime($row_dentist['start_time']));
                                                        $end = date("g:i A", strtotime($row_dentist['end_time']));
                                                        echo $row_dentist['day'] . " " . $start . " - " . $end;
                                                    ?>
                                                </td>
                                                <td>
                                                    <input type="hidden" id="date">
                                                    <a href="select-dentist.php?user_id=<?php echo $row_dentist['user_id']?>" >Select</a>
                                                </td>
                                            </tr>
                                        <?php
                                    }
                                    ?>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="appointmentInfo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Appointment Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="appointment_info" id="appointment_info"></div>
                </div>
            </div>
        </div>
    </div>


    
    <?php include "../../includes/scripts.php"; ?>
</body>
</html>


