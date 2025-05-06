<?php
include('../../connection/connection.php');
ob_start();
session_start();
$first_name = $_SESSION['first_name'];


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include '../../includes/styles.php'; ?>
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
              <h4 class="page-title">Appointments</h4>
            </div>
            <div class="page-category">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="card p-5">
                            <div id="calendar"></div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="card p-5">
                            <h1>Select Dentist</h1>
                            <a href="dashboard.php">Back</a>
                            <form action="" method="POST">
                                <select name="dentist">
                                    <option value="">--Select--</option>
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
                                        <option value="<?php echo $row_dentist['user_id']?>"><?php echo $row_dentist['first_name']. " " . $row_dentist['last_name']; ?></option>

                                        <?php
                                    }
                                
                                ?>
                                </select>


                                <input type="submit" name="select_dentist" value="Select">

                            </form>
                        </div>
                    </div>
                </div>
                
            </div>
          </div>
        </div>
      </div>
    </div>
    <a href="appointments.php">Appointment</a>
    <?php include "../../includes/scripts.php"; ?>
</body>
</html>
<?php

if(isset($_POST['select_dentist'])){
    $row_dentist = $_POST['dentist'];
    $user_id = $_SESSION['user_id'];



}

?>