<?php
include('../../connection/connection.php');
ob_start();
session_start();
$first_name = $_SESSION['first_name'];
$user_id_patient = $_SESSION['user_id'];
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
                <table>
                    <tr>
                        <th>Appointment Date & Time</th>
                        <th>Dentist</th>
                        <th>Concern</th>
                        <th>Action</th>
                    </tr>
                    
                    <?php 

                        $query_appointments = "SELECT appointments.user_id, appointments.user_id_patient, appointments.concern, appointments.appointment_date, users.first_name, users.middle_name, users.last_name, schedule.start_time, schedule.end_time, appointments.confirmed
                        FROM appointments
                        LEFT JOIN users
                        ON
                        appointments.user_id = users.user_id
                        LEFT JOIN schedule 
                        ON appointments.user_id = schedule.user_id WHERE appointments.user_id_patient =  '$user_id_patient'";
                        $run_appointments = mysqli_query($conn,$query_appointments);
                        if(mysqli_num_rows($run_appointments) > 0){
                            foreach($run_appointments as $row_appointment){
                                ?>
                                <tr>
                                    <td><?php echo $row_appointment['appointment_date']. " " . date("g:i A",strtotime($row_appointment['start_time'])). "-". date("g:i A",strtotime($row_appointment['end_time']))?></td>
                                    <td>Dr. <?php echo $row_appointment['first_name'] . " " . $row_appointment['last_name']?></td>
                                <td><?php echo $row_appointment['concern']?></td>
                                <td>
                                    <?php

                                        $status = (int)$row_appointment['confirmed'];

                                        if ($status === 0) {
                                            ?>

                                            <!-- <form action="accepted.php" method="POST">
                                                <input type="submit" name="accept" value="Confirmed">
                                                <input type="hidden" name="appointment_date" value="<?php echo $row_appointment['appointment_date']?>">
                                                
                                            </form> -->
                                            <form action="declined.php" method="POST">
                                                <input type="submit" name="decline" value="Cancel">
                                                <input type="hidden" name="appointment_date" value="<?php echo $row_appointment['appointment_date']?>">
                                            </form>
                                            <?php
                                             
                                        } elseif ($status === 1) {
                                            echo "Confirmed";
                                        } elseif ($status === 2) {
                                            echo "Cancelled";
                                        }
                                    ?>
                                        
                                    </td>
                                
                                </tr>
                                <?php
                            }
                        }
                    ?>
                </table>
                    <div class="col-lg-5">
                        <div class="card p-5">
                            <h1>Dentist</h1>
                            <a href="dashboard.php">Back</a>
                            <form action="" method="POST">
                                <table>
                                    <tr>
                                        <th>Name</th>
                                        <th>Schedule</th>
                                        <th>Action</th>
                                    </tr>

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
                                                        <a href="select-dentist.php?user_id=<?php echo $row_dentist['user_id']?>">Select</a>
                                                    </td>
                                                </tr>
                                            <?php
                                        }
                                    ?>
                                   
                                </table>
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


