<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/notification.php');

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

                  $query_dentist = "SELECT users.user_id AS user_id, users.first_name AS first_name, users.middle_name AS middle_name, users.last_name AS last_name, users.mobile_number AS mobile_number, users.email AS email, schedule.user_id AS schedule_user_id, schedule.day AS day , schedule.start_time AS start_time , schedule.end_time AS end_time
                  FROM
                  users 
                  LEFT JOIN schedule 
                  ON users.user_id = schedule.user_id 
                  WHERE users.role_id = '3' AND users.user_id =  '$user_id_dentist'";
                  $run_dentist = mysqli_query($conn,$query_dentist);
                  $row_dentist = mysqli_fetch_assoc($run_dentist);
                  json_encode($available_days = explode(", ", $row_dentist['day']));

                  $query_services = "SELECT * FROM services";
                  $run_services = mysqli_query($conn,$query_services);
                  $row_services = mysqli_fetch_assoc($run_services);

              ?>

              <form action="" method="POST">
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
                                <select name="appointment_time" class="form-control" required>
                                  <option value="">-- Select Time Slot --</option>
                                  <?php
                                      $start_time = $row_dentist['start_time']; 
                                      $end_time = $row_dentist['end_time'];     

                                      $start = strtotime($start_time);
                                      $end = strtotime($end_time);

                                      while ($start < $end) {
                                          $slot_start = date("h:i A", $start);
                                          $slot_end_time = strtotime("+1 hour", $start);

                                          if ($slot_end_time > $end) {
                                              break;
                                          }
                                          $slot_end = date("h:i A", $slot_end_time);
                                          $display = "$slot_start to $slot_end";
                                          echo "<option value='$display'>$display</option>";
                                          $start = $slot_end_time; 
                                      }
                                  ?>
                                </select>
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
                    <input type="submit" class="btn btn-sm btn-primary" name="save" value="Save">
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
<?php

if(isset($_POST['save'])){

    $date = date('y-m-d');

    $user_id_dentist = $_GET['user_id_dentist'];
    $user_id_patient = $_GET['user_id_patient'];
    $appointment_id = "2025".rand('1','10') . substr(str_shuffle(str_repeat("0123456789", 5)), 0, 3) ;
    $concern = $_POST['concern'];
    $appointment_time = $_POST['appointment_time'];
    $appointment_date = $_POST['appointment_date'];

    $check_time_appointment = "SELECT appointment_time, appointment_date, user_id FROM appointments WHERE appointment_time = '$appointment_time' AND appointment_date = '$appointment_date' AND user_id = '$user_id_dentist'";
    $run_appointment_time = mysqli_query($conn,$check_time_appointment);

    if(mysqli_num_rows($run_appointment_time) > 0){
        echo "<script>window.alert('Appointment time already booked')</script>";
        echo "<script>window.location.href='appointments.php'</script>";
    }else{
        $check_appointment = "SELECT appointment_date, user_id_patient FROM appointments WHERE appointment_date =  '$appointment_date' AND user_id_patient = '$user_id_patient'";
        $run_check_appointment = mysqli_query($conn,$check_appointment);
        if(mysqli_num_rows($run_check_appointment) > 0){
            echo "<script>window.alert('Patient already have an Appointment')</script>";
            echo "<script>window.location.href='appointments.php'</script>";
        }else{
            $query_appointment = "INSERT INTO appointments (user_id,user_id_patient,appointment_id,concern,confirmed,appointment_time,appointment_date,date_created,date_updated,remarks,walk_in) VALUES ('$user_id_dentist','$user_id_patient','$appointment_id','$concern', '0', '$appointment_time','$appointment_date','$date', '$date', NULL, '1')";
            $run_appointment = mysqli_query($conn,$query_appointment);

            
            if($run_appointment) {
              createNotification($conn, $user_id_dentist, "New Appointment Schedule", "Appointment", $date, $id);
              createNotification($conn, $user_id_patient, "New Appointment Schedule", "Appointment", $date, $id);

              header("Location: appointments.php");
            }else{
                echo "not added";
            }
        }
    }

    
}


?>