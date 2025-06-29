<?php
include('../../connection/connection.php');
ob_start();
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$first_name = $_SESSION['first_name'];
include('../../includes/security.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include '../../includes/styles.php'; ?>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
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
                <div class="card p-5">                   
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


                            ?>

                            <form action="" method="POST">
                                <label>Select Appointment Date:</label>
                                <input type="text" class="appointment_date form-control mb-4" name="appointment_date">
                                <label for="">Set Time:</label>
                                <select name="appointment_time" class="form-control mb-4" required>
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
                                <label for="">Doctor:</label>
                                <input type="text" class="form-control mb-4" value="<?= 'Dr. ' . $row_dentist['first_name']. " " . $row_dentist['last_name']?>" readonly>
                                <label for="">Concern</label>
                                <select name="concern" id="" class="form-control">
                                    <option value="">-Select-</option>
                                    <option value="Oral Prophylaxis">Oral Prophylaxis</option>
                                    <option value="Composite Restoration">Composite Restoration</option>
                                    <option value="Cosmetic Dentistry (Direct Composite Veneers)">Cosmetic Dentistry (Direct Composite Veneers)</option>
                                    <option value="Dental Extraction / Surgery">Dental Extraction / Surgery</option>
                                    <option value="Wisdom tooth">Wisdom tooth</option>
                                    <option value="Prosthodontics">Prosthodontics</option>
                                    <option value="Fixed (crown & bridge)">Fixed (crown & bridge)</option>
                                    <option value="Removable dentures">Removable dentures</option>
                                    <option value="US Plastic">US Plastic</option>
                                    <option value="Porcelain">Porcelain</option>
                                    <option value="Flexible">Flexible</option>
                                    <option value="Orthodontics (Braces)">Orthodontics (Braces)</option>

                                </select>
                                <!-- <label for="">Concern:</label>
                                <input type="text" class="form-control" name="concern" required> -->
                                <br>
                                <br>
                                <div class="text-end w-100">
                                    <a href="set-doctor.php?user_id_patient=<?= $_GET['user_id_patient'] ?>" class="btn btn-danger">Cancel</a>
                                    <input type="submit" class="btn btn-primary" name="save" value="Save">
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
    </div>
    <?php include "../../includes/scripts.php"; ?>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
</script>
<script>
    var availableDays = <?php echo json_encode($available_days); ?>;
</script>
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
</body>
</html>

<?php

if(isset($_POST['save'])){

    date_default_timezone_set("Asia/Manila");
    $date = date('y-m-d');

    $user_id_dentist = $_GET['user_id_dentist'];
    $user_id_patient = $_GET['user_id_patient'];
    $appointment_id = "2025".rand('1','10') . substr(str_shuffle(str_repeat("0123456789", 5)), 0, 3) ;
    $concern = $_POST['concern'];
    $appointment_time = $_POST['appointment_time'];
    $appointment_date = $_POST['appointment_date'];

    $check_time_appointment = "SELECT appointment_time FROM appointments WHERE appointment_time = '$appointment_time' ";
    $run_appointment_time = mysqli_query($conn,$check_time_appointment);

    if(mysqli_num_rows($run_appointment_time) > 0){
        echo "<script>window.alert('Appointment time already booked')</script>";
        echo "<script>window.location.href='appointments.php'</script>";
    }else{
        $check_appointment = "SELECT appointment_date, user_id_patient FROM appointments WHERE appointment_date =  '$appointment_date' AND user_id_patient = '$user_id_patient'";
        $run_check_appointment = mysqli_query($conn,$check_appointment);
        if(mysqli_num_rows($run_check_appointment) > 0){
            echo "<script>window.alert('Already have an Appointment')</script>";
            echo "<script>window.location.href='appointments.php'</script>";
        }else{
            $query_appointment = "INSERT INTO appointments (user_id,user_id_patient,appointment_id,concern,confirmed,appointment_time,appointment_date,date_created,date_updated,remarks,walk_in) VALUES ('$user_id_dentist','$user_id_patient','$appointment_id','$concern', '0', '$appointment_time','$appointment_date','$date', '$date', NULL, '1')";
            $run_appointment = mysqli_query($conn,$query_appointment);
            if($run_appointment) {
                header("Location: appointments.php");
                
            }else{
                echo "not added";
            }
        }
    }

    
}


?>