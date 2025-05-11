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
                                <a href="patients.php">Patients</a>
                            </li>
                            <li class="separator">
                                <i class="icon-arrow-right"></i>
                            </li>
                            <li class="nav-item">
                                <a href="#">Add Patient</a>
                            </li>
                        </ul>
                    </span>    
                </span>
            </div>
            <div class="page-category">
                <div class="card p-5">
                <?php
                    if(isset($_GET['user_id'])){
                        $user_id_patient = $_GET['user_id'];
                        $query_patients = "SELECT users.user_id, users.first_name,users.middle_name,users.last_name,users.mobile_number,users.email,users.password,users.date_of_birth,users.address, appointments.appointment_id,appointments.concern,appointments.confirmed,appointments.appointment_date,appointments.remarks
                        FROM users
                        LEFT JOIN appointments
                        ON users.user_id = appointments.user_id WHERE users.role_id = '1' AND users.user_id = '$user_id_patient'";

                        $run_patients = mysqli_query($conn,$query_patients);

                        if(mysqli_num_rows($run_patients) > 0){
                            foreach($run_patients as $row_patients){
                                ?>

                                <form action="" method="POST">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h2>Patient's Info</h2>
                                        </div>
                                        <div class="col-lg-4 mb-4">
                                            <label for="">First Name</label>
                                            <input type="text" class="form-control" name="first_name" value="<?php echo $row_patients['first_name']?>">
                                        </div>
                                        <div class="col-lg-4 mb-4">
                                            <label for="">Middle Name</label>
                                            <input type="text" class="form-control" name="middle_name" value="<?php echo $row_patients['middle_name']?>">
                                        </div>
                                        <div class="col-lg-4 mb-4">
                                            <label for="">Last Name</label>
                                            <input type="text" class="form-control" name="last_name" value="<?php echo $row_patients['last_name']?>">
                                        </div>
                                        <div class="col-lg-6 mb-4">
                                            <label for="">Mobile Number</label>
                                            <input type="text" class="form-control" name="mobile_number" value="<?php echo $row_patients['mobile_number']?>">
                                        </div>
                                        <div class="col-lg-6 mb-4">
                                            <label for="">Email</label>
                                            <input type="email" class="form-control" name="email" value="<?php echo $row_patients['email']?>">
                                        </div>
                                        <div class="col-lg-6 mb-4">
                                            <label for="">Date of Birth</label>
                                            <input type="date" class="form-control" name="date_of_birth" value="<?php echo $row_patients['date_of_birth']?>">
                                        </div>
                                        <div class="col-lg-6 mb-4">
                                            <label for="">Address</label>
                                            <input type="text"  class="form-control" name="address" value="<?php echo $row_patients['address']?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h2>Patient's Appointments</h2>
                                        </div>
                                        <div class="col-lg-12 mb-4">
                                            <label for="">Appointment Date</label>
                                            <p><?php echo $row_patients['appointment_date']?></p>
                                        </div>
                                        <div class="col-lg-12 mb-4">
                                            <label for="">Status</label>
                                            <p>
                                            
                                                <?php 
                                                
                                                $status = (int)$row_patients['confirmed'];
                                                if ($status === 0) {
                                                    echo "Unverified / No Data";
                                                } elseif ($status === 1) {
                                                    echo "Confirmed";
                                                } elseif ($status === 2) {
                                                    echo "Canceled";
                                                }
                                                
                                                ?>
                                            </p>
                                        </div>
                                        <div class="col-lg-12 mb-4">
                                            <label for="">Doctor's Remarks</label>
                                            <p><?= $row_patients['remarks'] ?? 'N/A'?></p>
                                        </div>
                                        <div class="col-lg-12 text-end">
                                            <a href="patients.php" class="btn btn-danger">Cancel</a>
                                            <input type="submit" class="btn btn-primary" name="update" value="Update">
                                        </div>
                                    </div>
                                </form>
                                <!-- <form action="send_reset_password.php" method="POST">

                                    <h3>Send Reset Password</h3>
                                        
                                    <input type="submit" name="send_reset_password" value="Send Email">
                                    <input type="hidden" name="email" value="<?php echo $row_patients['email']?>">

                                </form> -->
                                <?php
                                
                            }
                        }
                    }

                    ?>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include "../../includes/scripts.php"; ?>
</body>
</html>

    <h1>Edit Patient</h1>
    <a href="patients.php">Back</a>

    
</body>
</html>

<?php

if(isset($_POST['update'])){

    date_default_timezone_set("Asia/Manila");
    $date = date('y-m-d');
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $mobile_number = $_POST['mobile_number'];
    $email = $_POST['email'];
    $date_of_birth = $_POST['date_of_birth'];
    $address = $_POST['address'];
    $user_id_patient = $_GET['user_id'];

    $query_update = "UPDATE users SET first_name = '$first_name', middle_name = '$middle_name',last_name='$last_name',mobile_number = '$mobile_number', email = '$email', date_of_birth =  '$date_of_birth', address = '$address', date_updated = '$date' WHERE user_id = '$user_id_patient'" ;
    $run_update = mysqli_query($conn,$query_update);

    if($run_update){
        echo "updated";
    }else{
        echo "error";
    }




}



?>