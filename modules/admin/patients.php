<?php

include('../../connection/connection.php');
session_start();
ob_start();
//errors
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
    <?php include '../../includes/styles.php' ?>
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
                    <a href="add-patient.php" class="btn btn-dark op-7">Add New Patient</a>
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
                                <th>Actions</th>
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
                                        <td>
                                            <a href="edit-patient.php?user_id=<?php echo $row_patients['user_id']?>">Edit</a>
                                            <a href="delete-patient.php?user_id=<?php echo $row_patients['user_id']?>">Delete</a>
                                            
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
    <?php include "../../includes/scripts.php"; ?>

</body>
</html>