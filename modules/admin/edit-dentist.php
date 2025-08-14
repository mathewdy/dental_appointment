<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/Users/users.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/Users/dentists.php');

$first_name = $_SESSION['first_name'];
?>
  <div class="wrapper">
  <?php 
  include '../../includes/sidebar.php';
  ?>
    <div class="main-panel">
    <?php 
    include '../../includes/topbar.php';
    ?>
      <div class="container">
        <div class="page-inner">
          <div class="page-header">
            <span class="d-flex justify-content-between align-items-center w-100">
              <span class="d-flex">
                <h4 class="page-title">Edit Dentist</h4>
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
                      <a href="view-dentists.php">Dentists</a>
                  </li>
                  <li class="separator">
                      <i class="icon-arrow-right"></i>
                  </li>
                  <li class="nav-item">
                      <a href="#">Edit Dentist</a>
                  </li>
                </ul>
              </span>    
            </span>
          </div>
          <div class="page-category">
            <?php
            if(isset($_GET['user_id'])){
                $user_id = $_GET['user_id'];
                $run_dentist = getDentistById($conn, '3', $user_id);
                if(mysqli_num_rows($run_dentist) > 0){
                foreach($run_dentist as $row_dentist){
                ?>
                <form action="" method="POST">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="card p-4 shadow-none form-card rounded-1">
                        <div class="card-header">
                          <h3>Basic Information</h3>
                        </div>
                        <div class="card-body">
                          <div class="row gap-4">
                            <div class="col-lg-12">
                              <div class="row d-flex align-items-center w-100">
                                <div class="col-lg-2">
                                  <label for="first_name">First Name</label>
                                </div>
                                <div class="col-lg-10">
                                  <input type="text" class="form-control" name="first_name" value="<?= $row_dentist['first_name']?>">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12">
                              <div class="row d-flex align-items-center w-100">
                                <div class="col-lg-2">
                                  <label for="">Middle Name</label>
                                </div>
                                <div class="col-lg-10">
                                  <input type="text" class="form-control" name="middle_name" value="<?= $row_dentist['middle_name']?>">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12">
                              <div class="row d-flex align-items-center w-100">
                                <div class="col-lg-2">
                                  <label for="">Last Name</label>
                                </div>
                                <div class="col-lg-10">
                                  <input type="text" class="form-control" name="last_name" value="<?= $row_dentist['last_name']?>">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="card p-4 shadow-none form-card rounded-1">
                        <div class="card-header">
                          <h3>Schedule Information</h3>
                        </div>
                        <div class="card-body">
                          <div class="row gap-4">
                            <div class="col-lg-12">
                              <div class="row d-flex align-items-center w-100">
                                <div class="col-lg-2">
                                  <label for="">Start Time</label>
                                </div>
                                <div class="col-lg-10">
                                  <input type="time" class="form-control" name="start_time" id="start_time" min="10:00" max="17:00" value="<?= $row_dentist['start_time']?>">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12">
                              <div class="row d-flex align-items-center w-100">
                                <div class="col-lg-2">
                                  <label for="">End Time</label>
                                </div>
                                <div class="col-lg-10">
                                  <input type="time" class="form-control" name="end_time" id="end_time" min="10:00" max="17:00" value="<?= $row_dentist['end_time']?>">
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-12">
                              <div class="row d-flex align-items-start w-100">
                                <div class="col-lg-2">
                                  <label for="">Working Days:</label>
                                </div>
                                <div class="col-lg-10">
                                  <?php
                                    $saved_days = explode(', ', $row_dentist['day']); // e.g., "Monday, Tuesday"
                                    $all_days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

                                    foreach ($all_days as $day) {
                                      $checked = in_array($day, $saved_days) ? 'checked' : '';
                                      echo "
                                      <span class='d-flex align-items-center gap-2'>
                                        <input type='checkbox' name='schedule[]' value='$day' $checked> $day 
                                      </span>
                                      ";
                                    }
                                    ?>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-12 text-end">
                      <a href="view-dentists.php" class="btn btn-sm btn-danger">Cancel</a>
                      <input type="hidden" name="update_dentist" value="1">
                      <input type="submit" class="btn btn-sm btn-primary" value="Save">	
                    </div>
                  </div>                        
                </form>
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
<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/scripts.php'); 
?>
<script>
$(document).ready(function() {
    $('form').on('submit', function(e) {
        e.preventDefault();
        confirmBeforeSubmit($(this), "You\'ve made changes. Do you want to save them?", function() {
            return validate('start_time', 'end_time');
        });
    });
});
</script>
<?php

if(isset($_POST['update_dentist'])){
  $user_id = $_GET['user_id'];
  $first_name = $_POST['first_name'];
  $middle_name = $_POST['middle_name'];
  $last_name = $_POST['last_name'];
  $schedule = $_POST['schedule'];
  $start_time = $_POST['start_time'];
  $end_time = $_POST['end_time'];
  
  if (isset($_POST['schedule']) && is_array($_POST['schedule'])) {
      $schedule = $_POST['schedule'];
      $days_combined_updated = implode(', ', $schedule); 
  } else {
      $days_combined_updated = $_POST['day'];
  }
  
  $run_update = updateDentist($conn, $first_name, $middle_name, $last_name, $user_id);
  if ($run_dentist) {
    $run_update_schedule = updateDentistSchedule($conn, $days_combined_updated, $start_time, $end_time, $user_id);
    echo "<script> success('User updated successfully.', () => window.location.href = 'view-dentists.php') </script>";
  } else {
    echo "<script> error('Something went wrong!', () => window.location.href = 'view-dentists.php') </script>";
  }

}


?>