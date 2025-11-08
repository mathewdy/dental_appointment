<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/Appointments/appointments.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$first_name = $_SESSION['first_name'];
$user_id_patient = $_SESSION['user_id'];
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
                        <h4 class="page-title">My Requests</h4>
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
                                <a href="appointments.php">Appointments</a>
                            </li>
                            <li class="separator">
                                <i class="icon-arrow-right"></i>
                            </li>
                            <li class="nav-item">
                                <a href="#">Appointment Requests</a>
                            </li>
                        </ul>
                    </span>    
                </span>
            </div>
            <div class="page-category">
                <div class="card p-5">
                <div class="table-responsive">
                <table class="display table table-hover" id="dataTable">
                    <thead>
                        <tr>
                            <th>Appointment Date & Time</th>
                            <th>Dentist</th>
                            <th>Concern</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $run_appointments = getAllRequestsById($conn, $user_id_patient);
                            if(mysqli_num_rows($run_appointments) > 0){
                                foreach($run_appointments as $row_appointment){
                                    ?>
                                    <tr>
                                        <td><?php echo $row_appointment['appointment_date']. " " . $row_appointment['appointment_time']?></td>
                                        <td>Dr. <?php echo $row_appointment['doctor_first_name'] . " " . $row_appointment['doctor_last_name']?></td>
                                    <td><?php echo $row_appointment['concern']?></td>
                                    <td>
                                      <?php
                                        $handler = match($row_appointment['confirmed']){
                                            1 => '<span class="badge text-dark text-body-secondary fw-bold" style="background: #94f7c9; border: #94f7c9;"><i class="fas fa-check-circle"></i> Confirmed</span>',
                                            2 => '<span class="badge text-dark text-body-secondary fw-bold" style="background: #f79494; border: #f79494;"><i class="fas fa-times-circle"></i> Cancelled</span>',
                                            3 => '<span class="badge text-dark text-body-secondary fw-bold" style="background: #fab273; border: #fab273;"><i class="fas fa-times"></i> No Show</span>',
                                            default => '<span class="badge text-dark text-body-secondary fw-bold" style="background: #fae373; border: #fae373;"><i class="fas fa-clock"></i> Pending</span>'
                                        };
                                        echo $handler;
                                      ?>
                                    </td>
                                    <td>
                                      <?php
                                        if($row_appointment['confirmed'] == 0) {
                                          ?>
                                          <div class="text-center text-danger">
                                            <a href="request-action.php?id=<?= $row_appointment['appointment_id']?>&status=2" class="status"><i class="fas fa-trash"></i></a>
                                          </div>
                                          <?php
                                        } else {
                                          ?>
                                          <div class="text-center text-danger" style="opacity: 50%;">
                                            <a href="#" class="status" style="pointer-events:none;"><i class="fas fa-trash"></i></a>
                                          </div>
                                          <?php
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
<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/scripts.php'); 
?>
<script>
$(document).ready(function() {
  $('.status').on('click', function(e) {
    e.preventDefault();
    confirmBeforeRedirect("Do you want to update this appointment?", $(this).attr('href'))
  });
});
</script>