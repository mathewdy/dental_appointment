<?php
include('../../connection/connection.php');

session_start();
ob_start();
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
                <div class="card p-5">
                    <?php
                            if(isset($_GET['user_id'])){
                                $user_id = $_GET['user_id'];

                                $query_dentist = "SELECT users.user_id AS user_id, users.first_name AS first_name, users.middle_name AS middle_name, users.last_name AS last_name, users.mobile_number AS mobile_number, users.email AS email, schedule.user_id AS schedule_user_id, schedule.day AS day , schedule.start_time AS start_time, schedule.end_time AS end_time
                                FROM
                                users 
                                LEFT JOIN schedule 
                                ON users.user_id = schedule.user_id 
                                WHERE users.role_id = '3' AND users.user_id = '$user_id'";
                                $run_dentist = mysqli_query($conn,$query_dentist);

                                if(mysqli_num_rows($run_dentist) > 0){
                                    foreach($run_dentist as $row_dentist){
                                        ?>

                            <form action="" method="POST">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h3>Basic Information</h3>
                                    </div>
                                    <div class="col-lg-4 mb-4">
                                        <label for="">First Name</label>
                                        <input type="text" class="form-control" name="first_name" value="<?= $row_dentist['first_name']?>">
                                    </div>
                                    <div class="col-lg-4 mb-4">
                                        <label for="">Middle Name</label>
                                        <input type="text" class="form-control" name="middle_name" value="<?= $row_dentist['middle_name']?>">
                                    </div>
                                    <div class="col-lg-4 mb-4">
                                        <label for="">Last Name</label>
                                        <input type="text" class="form-control" name="last_name" value="<?= $row_dentist['last_name']?>">
                                    </div>
                                    <div class="col-lg-12">
                                        <h3>Schedule Information</h3>
                                    </div>
                                    <div class="col-lg-12 mb-4">
                                        <label for="">Schedule</label><br>
                                        <?php
                                        $saved_days = explode(', ', $row_dentist['day']); // e.g., "Monday, Tuesday"

                                        $all_days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

                                        foreach ($all_days as $day) {
                                            $checked = in_array($day, $saved_days) ? 'checked' : '';
                                            echo "<input type='checkbox' name='schedule[]' value='$day' $checked> $day <br>";
                                        }
                                    ?>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="">Start Time</label>
                                        <input type="time" class="form-control" name="start_time" id="start_time" min="10:00" max="17:00" value="<?= $row_dentist['start_time']?>">
                                        
                                    </div>
                                    <div class="col-lg-6 mb-5">
                                        <label for="">End Time</label>
                                        <input type="time" class="form-control" name="end_time" id="end_time" min="10:00" max="17:00" value="<?= $row_dentist['end_time']?>">
                                    </div>
                                    <div class="col-lg-12 text-end">
                                        <a href="view-dentists.php" class="btn btn-sm btn-danger">Cancel</a>
                                        <input type="submit" class="btn btn-sm btn-primary" name="update_dentist" value="Save">

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
    </div>
<?php include "../../includes/scripts.php"; ?>
<script>
document.querySelector('form').addEventListener('submit', function(e) {
    const start = document.getElementById('start_time').value;
    const end = document.getElementById('end_time').value;

    if (!start || !end) {
        alert("Please select both start and end time.");
        e.preventDefault();
        return;
    }

    const startTime = new Date("1970-01-01T" + start + ":00");
    const endTime = new Date("1970-01-01T" + end + ":00");
    const minTime = new Date("1970-01-01T10:00:00");
    const maxTime = new Date("1970-01-01T17:00:00");

    if (startTime < minTime || startTime > maxTime) {
        alert("Start time must be between 10:00 AM and 5:00 PM.");
        e.preventDefault();
        return;
    }

    if (endTime <= startTime) {
        alert("End time must be after start time.");
        e.preventDefault();
        return;
    }

    if (endTime > maxTime) {
        alert("End time must not be later than 5:00 PM.");
        e.preventDefault();
        return;
    }
});

</script>
</body>
</html>

<?php

if(isset($_POST['update_dentist'])){
    date_default_timezone_set("Asia/Manila");
    $date = date('y-m-d');
    $user_id = $_GET['user_id'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];

    $schedule = $_POST['schedule'];

    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    
    // Check if any checkboxes were selected
    if (isset($_POST['schedule']) && is_array($_POST['schedule'])) {
        // New selections were made
        $schedule = $_POST['schedule'];
        $days_combined_updated = implode(', ', $schedule); // Use commas for DB
    } else {
        // No checkboxes selected – fallback to the original
        $days_combined_updated = $_POST['day'];
    }
    
    $query_update = "UPDATE users SET first_name = '$first_name', middle_name = '$middle_name', last_name='$last_name', date_updated = '$date' WHERE user_id = '$user_id'";
    $run_update = mysqli_query($conn, $query_update);
    
    if ($run_dentist) {
        $query_update_schedule = "UPDATE schedule SET day = '$days_combined_updated', start_time = '$start_time', end_time = '$end_time' WHERE user_id = '$user_id'";
        $run_update_schedule = mysqli_query($conn, $query_update_schedule);

        header("Location: view-dentists.php");
    } else {
        echo "error: " . $conn->error;
    }

}


?>