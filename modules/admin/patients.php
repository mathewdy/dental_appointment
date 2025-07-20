<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/security.php');
//errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$first_name = $_SESSION['first_name'];
include('../../includes/security.php');
?>
<style>
    .dataTables_paginate .paginate_button{
        border-radius: 0 !important;         /* Rounded corners */
        border: 2px solid black !important;
    }
    a.page_link {
        border-radius: 12px !important;
    }
</style>

    <div class="wrapper">
        <?php include '../../includes/sidebar.php'; ?>

      <div class="main-panel">
        <?php include '../../includes/topbar.php'; ?>
        <div class="container">
          <div class="page-inner">
            <div class="page-header">
                <span class="d-flex justify-content-between align-items-center w-100">
                    <span class="d-flex">
                        <h4 class="page-title">Patients</h4>
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
                                <a href="#">Patients</a>
                            </li>
                        </ul>
                    </span>    
                    <a href="add-patient.php" class="btn btn-sm btn-dark op-7">Add New Patient</a>
                </span>
            </div>
            <div class="page-category">
                <div class="card py-3">
                    <div class="table-responsive">
                    <table id="dataTable" class="display table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Mobile Number</th>
                                <th>Email</th>
                                <th style="width: 10%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $query_patients = "SELECT users.user_id, users.first_name,users.middle_name,users.last_name,users.mobile_number,users.email,users.password,users.date_of_birth,users.address, appointments.appointment_id,appointments.concern,appointments.confirmed,appointments.appointment_date,appointments.remarks
                            FROM users
                            LEFT JOIN appointments
                            ON users.user_id = appointments.user_id WHERE users.role_id = '1'";
                    
                            $run_patients = mysqli_query($conn,$query_patients);
                    
                            if(mysqli_num_rows($run_patients) > 0){
                                foreach($run_patients as $row_patients){
                                    ?>
                    
                                    <tr>
                                        <td><?php echo $row_patients['first_name'] . " " . $row_patients['last_name']?></td>
                                        <td><?php echo $row_patients['mobile_number']?></td>
                                        <td><?php echo $row_patients['email']?></td>
                                        <td class="d-flex justify-content-center">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-outline-primary rounded-circle d-flex justify-content-center align-items-center" style="width: 12px;" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <ul class="dropdown-menu"> 
                                                    <li>
                                                        <a href="set-doctor.php?user_id_patient=<?php echo $row_patients['user_id']?>" class="dropdown-item">Set Appointment</a>
                                                    </li>
                                                    <li>
                                                        <a href="edit-patient.php?user_id=<?php echo $row_patients['user_id']?>" class="dropdown-item">Edit</a>
                                                    </li>
                                                    <li>
                                                        <a href="delete-patient.php?user_id=<?php echo $row_patients['user_id']?>" class="dropdown-item">Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            
                                        </td>
                                    </tr>
                    
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
    <!-- <div class="modal fade" id="doctorModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                    <a href="add-appointment.php?user_id=<?php echo $row_dentist['user_id']?>" >Select</a>
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
        </div> -->
    </div>
    <?php include "../../includes/scripts.php"; ?>