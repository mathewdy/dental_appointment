<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/Appointments/appointments.php');

$first_name = $_SESSION['first_name'];
$user_id_patient = $_SESSION['user_id'];
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../../includes/security.php');
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
                        <h4 class="page-title">Appointment Requests</h4>
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
                                <a href="#">Requests</a>
                            </li>
                        </ul>
                    </span>    
                </span>
            </div>
            <div class="page-category">
              <div class="card p-5">
                <div class="table-responsive">
                  <table class="display table table-border table-hover" id="dataTable">
                    <thead>
                        <tr>
                            <th>Name of Patient</th>
                            <th>Date & Time</th>
                            <th>Doctor</th>
                            <th>Concern</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                          $run_appointments = getAllRequests($conn);
                          if(mysqli_num_rows($run_appointments) > 0){
                            foreach($run_appointments as $row_appointment){
                            ?>
                            <tr>
                              <td><?php echo $row_appointment['patient_first_name'] . " " . $row_appointment['patient_last_name']?></td>
                              <td><?php echo $row_appointment['appointment_date']. " ". $row_appointment['appointment_time']?></td>
                              <td>Dr. <?php echo $row_appointment['doctor_first_name'] . " " . $row_appointment['doctor_last_name']?></td>
                              <td><?php echo $row_appointment['concern']?></td>
                              <td>
                                  <?php
                                      $handler = match($row_appointment['confirmed']){
                                          1 => '<span class="badge bg-success">Confirmed</span>',
                                          2 => '<span class="badge bg-danger">Cancelled</span>',
                                          default => '<span class="badge bg-warning">Pending</span>'
                                      };
                                      echo $handler;
                                  ?>
                              </td>
                              <td>
                                <div class="d-flex justify-content-center align-items-center">
                                  <?php 
                                      if(!$row_appointment['confirmed']){
                                          ?>
                                          <form action="" method="POST">
                                              <input type="submit" value="Update Status" class="btn btn-sm btn-primary">
                                              <input type="hidden" name="update_status" value="1">
                                              <input type="hidden" name="appointment_id" value="<?php echo $row_appointment['appointment_id']?>">
                                          </form>
                                          <?php
                                      }else{
                                          ?>
                                              <p class="text-muted p-0 m-0">Updated</p>
                                          <?php
                                      }
                                  ?>  
                                </div>
                              </td>
                            </tr>
                            <?php
                        }
                    }else{
                        echo "No Data";
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
    $('form').on('submit', function(e) {
        e.preventDefault();
        confirmBeforeSubmit($(this), "Do you want to update this appointment?");
    });
});
</script>
<?php
if(isset($_POST['update_status'])){
    $appointment_id = $_POST['appointment_id'];

    $run_query = updateStatus($conn, $appointment_id);
    if($run_query){
		echo "<script> success('Updated successfully.', () => window.location.href = 'requests.php') </script>";
	}else{
		echo "<script> error('Something went wrong!', () => window.location.href = 'requests.php') </script>";
	}
}

?>