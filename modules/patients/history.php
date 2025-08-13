<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/security.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$first_name = $_SESSION['first_name'];
$user_id_patients = $_SESSION['user_id'];
?>

    <div class="wrapper">
      <?php include '../../includes/sidebar.php'; ?>
      <div class="main-panel">
        <?php include '../../includes/topbar.php'; ?>
        <div class="container">
          <div class="page-inner">
            <div class="page-header">
              <span class="d-flex justify-content-between align-items-center w-100">
                    <span class="d-flex">
                        <h4 class="page-title">History</h4>
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
                            <a href="#">History</a>
                            </li>
                        </ul>
                    </span>    
                </span>
            </div>
            <div class="page-category">
                <div class="card p-5">
                  <div class="table-responsive">
                    <table class="display table table-striped table-hover" id="dataTable">
                      <thead>
                        <tr>
                            <th>Appointment Date & Time</th>
                            <th>Dentist</th>
                            <th>Concern</th>
                            <th>Doctor's Remarks</th>
                            <th>Status</th>
                        </tr>  
                      </thead>
                      <tbody>
                        <?php
                          $query_appointments = "SELECT appointments.user_id, appointments.user_id_patient, appointments.concern, appointments.appointment_date, users.first_name, users.middle_name, users.last_name, schedule.start_time, schedule.end_time, appointments.confirmed, appointments.remarks , appointments.appointment_time
                          FROM appointments
                          LEFT JOIN users
                          ON
                          appointments.user_id = users.user_id
                          LEFT JOIN schedule
                          ON appointments.user_id = schedule.user_id WHERE appointments.user_id_patient =  '$user_id_patients'";
                          $run_appointments = mysqli_query($conn,$query_appointments);
                          if(mysqli_num_rows($run_appointments) > 0){
                              foreach($run_appointments as $row_appointment){
                                  ?>
                                  <tr>
                                      <td><?php echo $row_appointment['appointment_date']. " " . $row_appointment['appointment_time']?></td>
                                      <td>Dr. <?php echo $row_appointment['first_name'] . " " . $row_appointment['last_name']?></td>
                                  <td><?php echo $row_appointment['concern']?></td>
                                  <td><?php echo $row_appointment['remarks']?></td>
                                  <td>
                                    <?php 
                                      if($row_appointment['confirmed'] === '1'){
                                        echo "Completed";
                                      }elseif($row_appointment['confirmed'] === '2'){
                                        echo "Cancelled";
                                      }elseif($row_appointment['confirmed'] === '3') {
                                        echo "Pending";
                                      }else{
                                        echo "Pending";
                                      }
                                    ?>
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
<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/scripts.php'); 
?>