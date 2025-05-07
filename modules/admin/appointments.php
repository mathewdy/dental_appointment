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

    <table>
    <tr>
      <th>Name of Patient</th>
      <th>Date & Time</th>
      <th>Status</th>
    </tr>
    <?php
      $query_appointments = "SELECT appointments.user_id, appointments.user_id_patient, appointments.concern, appointments.appointment_date, users.first_name, users.middle_name, users.last_name, schedule.start_time, schedule.end_time, appointments.confirmed
      FROM appointments
      LEFT JOIN users
      ON
      appointments.user_id = users.user_id
      LEFT JOIN schedule 
      ON appointments.user_id = schedule.user_id";
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
                      echo "Unverified";
                      } elseif ($status === 1) {
                          echo "Confirmed";
                      } elseif ($status === 2) {
                          echo "Canceled";
                      }
                    ?>
                  </td>
              </tr>
            <?php
        }
      }else{
        echo "No Data";
      }
    ?>
    
  </table>
  <?php include "../../includes/scripts.php"; ?>
</body>
</html>