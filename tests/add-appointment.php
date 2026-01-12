<?php
include('../../connection/connection.php');
ob_start();
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$first_name = $_SESSION['first_name'];
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
                                <h4 class="page-title">Set Appointment</h4>
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
                                        <a href="patients.php">Patients</a>
                                    </li>
                                    <li class="separator">
                                        <i class="icon-arrow-right"></i>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#">Set Appointment</a>
                                    </li>
                                </ul>
                            </span>
                        </span>
                    </div>
                    <div class="page-category">
                        <div class="card p-5">
                            <?php

                            if (isset($_GET['user_id'])) {
                                $user_id = $_GET['user_id'];
                                include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Users/dentists.php');

                                $query_dentist = "SELECT users.user_id AS user_id, users.first_name AS first_name, users.middle_name AS middle_name, users.last_name AS last_name
                        FROM users 
                        WHERE users.role_id = '3' AND users.user_id = '$user_id'";
                                $run_dentist = mysqli_query($conn, $query_dentist);
                                $row_dentist = mysqli_fetch_assoc($run_dentist);

                                // Get available days from new dentist_schedules table
                                $schedules = getDentistSchedules($conn, $user_id);
                                $available_days = array_keys($schedules);
                                ?>

                                <form action="" method="POST">
                                    <label>Select Appointment Date:</label>
                                    <input type="text" class="appointment_date form-control mb-4" name="appointment_date">
                                    <label for="">Doctor:</label>
                                    <input type="text" class="form-control mb-4"
                                        value="<?= 'Dr. ' . $row_dentist['first_name'] . " " . $row_dentist['last_name'] ?>"
                                        readonly>
                                    <label for="">Concern:</label>
                                    <input type="text" class="form-control" name="concern" required>
                                    <br>
                                    <br>
                                    <div class="text-end w-100">
                                        <a href="appointments.php" class="btn btn-danger">Cancel</a>
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
                beforeShowDay: function (date) {
                    var dayIndex = date.getDay();
                    return [availableIndexes.includes(dayIndex)];
                }
            });
        });
    </script>
</body>

</html>


<?php

if (isset($_POST['save'])) {
    date_default_timezone_set("Asia/Manila");
    $date = date('y-m-d');
    $appointment_id = "2025" . rand('1', '10') . substr(str_shuffle(str_repeat("0123456789", 5)), 0, 3);

    $user_id = $_GET['user_id'];
    $user_id_patient = $_SESSION['user_id'];
    $concern = $_POST['concern'];

    $appointment_date = $_POST['appointment_date'];

    $check_appointment = "SELECT appointment_date, user_id_patient FROM appointments WHERE appointment_date =  '$appointment_date' AND user_id_patient = '$user_id_patient'";
    $run_check_appointment = mysqli_query($conn, $check_appointment);
    if (mysqli_num_rows($run_check_appointment) > 0) {
        echo "already added in this particular date";
    } else {
        $query_appointment = "INSERT INTO appointments (user_id,user_id_patient,appointment_id,concern,confirmed,appointment_date,date_created,date_updated) VALUES ('$user_id','$user_id_patient','$appointment_id','$concern', '0', '$appointment_date','$date', '$date')";
        $run_appointment = mysqli_query($conn, $query_appointment);
        if ($run_appointment) {
            header("Location: appointments.php");
        } else {
            echo "not added";
        }
    }
}

?>