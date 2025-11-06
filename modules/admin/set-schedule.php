<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/Users/dentists.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/Users/patients.php');


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$first_name = $_SESSION['first_name'];
$id = $_SESSION['user_id'];
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
                  <h4 class="page-title">Set Schedule</h4>
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
                      <a href="appointments.php">Patient</a>
                    </li>
                    <li class="separator">
                      <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                      <a href="set-doctor.php?user_id_patient=<?= $_GET['user_id_patient'] ?>">Set Doctor</a>
                    </li>
                    <li class="separator">
                      <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                      <a href="#">Set Schedule</a>
                    </li>
                  </ul>
              </span>    
            </span>
          </div>
            <div class="page-category">
              <?php
              if(isset($_GET['user_id_patient']) && isset($_GET['user_id_dentist'])){
                  $user_id_patient = $_GET['user_id_patient'];
                  $user_id_dentist = $_GET['user_id_dentist'];

                  $run_dentist = getDentistById($conn, '3', $user_id_dentist);
                  $row_dentist = mysqli_fetch_assoc($run_dentist);

                  $run_patient = getPatientById($conn, $user_id_patient);
                  $row_patient = mysqli_fetch_assoc($run_patient);

                  $start = date("h:i A", strtotime($row_dentist['start_time']));
                  $end = date("h:i A", strtotime($row_dentist['end_time']));

                  json_encode($available_days = explode(", ", $row_dentist['day']));

                  $query_services = "SELECT * FROM services";
                  $run_services = mysqli_query($conn,$query_services);
                  $row_services = mysqli_fetch_assoc($run_services);

              ?>

              <form action="set.php" method="POST">
                <div class="row">
                  <div class="col-lg-12 mb-4">
                    <div class="card p-4 shadow-none form-card rounded-1">
                      <div class="card-header">
                          <h3>Appointment Details</h3>
                      </div>
                      <div class="card-body">
                        <div class="row gap-4">
                          <div class="col-lg-12">
                            <div class="row d-flex align-items-center w-100">
                              <div class="col-lg-2">
                                <label for="">Appointment Date</label>
                              </div>
                              <div class="col-lg-10">
                                <div class="input-group">
                                  <input type="text" class="appointment_date form-control" name="appointment_date" required>
                                  <input type="hidden" name="dentist" value="<?= $_GET['user_id_dentist']?>">
                                  <input type="hidden" name="patient" value="<?= $_GET['user_id_patient']?>">
                                  <?php
                                      $offset = 5;  
                                      $values_patient = array_values($row_patient);  
                                      $field_value_patient = $values_patient[$offset]; 
                                  ?>
                                  <input type="hidden" name="email" value="<?= $field_value_patient?>">
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-12">
                            <div class="row d-flex align-items-center w-100">
                              <div class="col-lg-2">
                                <label for="">Set Time</label>
                              </div>
                              <div class="col-lg-10">
                                <input type="time" class="form-control" name="appointment_time" id="start_time">
                                <span>
                                  <small class="text-muted">
                                    <i class="fas fa-info-circle text-info"></i>
                                    Office hours are <?= $start . ' to ' . $end ?>
                                  </small>
                                </span>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-12">
                            <div class="row d-flex align-items-center w-100">
                              <div class="col-lg-2">
                                <label for="">Doctor</label>
                              </div>
                              <div class="col-lg-10">
                                <div class="input-group">
                                  <input type="text" class="form-control" value="<?= 'Dr. ' . $row_dentist['first_name']. " " . $row_dentist['last_name']?>" readonly>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-12">
                            <div class="row d-flex align-items-center w-100">
                              <div class="col-lg-2">
                                <label for="">Concern</label>
                              </div>
                              <div class="col-lg-10">
                                <div class="input-group mb-3">
                                  <select name="concern" id="" class="form-control" required>
                                    <option value="">-Select-</option>
                                    <?php
                                      while ($row_services = mysqli_fetch_assoc($run_services)) {
                                          echo '<option value="' . $row_services['name'] . '">' . $row_services['name'] . '</option>';
                                      }
                                    ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-12 text-end">
                    <a href="set-doctor.php?user_id_patient=<?= $_GET['user_id_patient'] ?>" class="btn btn-sm btn-danger">Cancel</a>
                    <input type="submit" class="btn btn-sm btn-primary" value="Save">
                    <input type="hidden" name="save" value="1">
                  </div>
                </div>                        
              </form>
              <?php
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php
  include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/scripts.php');
  
  $available_days = json_encode($available_days);
  echo "
    <script>
        var availableDays =  $available_days
    </script>
  ";
?>
    
<script>
  $(function () {
      const allDays = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
      const availableIndexes = availableDays.map(day => allDays.indexOf(day));
      $(".appointment_date").datepicker({
          beforeShowDay: function(date) {
              var dayIndex = date.getDay(); 
              return [availableIndexes.includes(dayIndex)];
          },
          minDate: 0
      });
  });
</script>
<script>
  $(document).ready(function() {
      $('form').on('submit', function(e) {
          e.preventDefault();
          confirmBeforeSubmit($(this), "Do you want to add this appointment?")
      });
  });
</script>
