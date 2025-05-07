<?php
include('../../connection/connection.php');

session_start();
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>edit dentist</h1>

    <a href="view-dentists.php">Back</a>

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

                    <label for="">First Name</label>
                    <input type="text" name="first_name" value="<?php echo $row_dentist['first_name']?>">
                    <label for="">Middle Name</label>
                    <input type="text" name="middle_name" value="<?php echo $row_dentist['middle_name']?>">
                    <label for="">Last Name</label>
                    <input type="text" name="last_name" value="<?php echo $row_dentist['last_name']?>">
                    <br>
                    <label for="">Current Schedules</label>
                    <p><?php echo $row_dentist['day']; ?></p>

                    <!-- This is used as fallback when no checkboxes are selected -->
                    <input type="hidden" name="day" value="<?php echo $row_dentist['day']; ?>">

                    <label for="">Schedule</label><br>

                    <?php
                    $saved_days = explode(', ', $row_dentist['day']); // e.g., "Monday, Tuesday"

                    $all_days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

                    foreach ($all_days as $day) {
                        $checked = in_array($day, $saved_days) ? 'checked' : '';
                        echo "<input type='checkbox' name='schedule[]' value='$day' $checked> $day <br>";
                    }
                    ?>
                    <label for="start_time">Start Time</label>
                    <input type="time" name="start_time" id="start_time" min="10:00" max="17:00" value="<?php echo $row_dentist['start_time'] ?>">

                    <label for="end_time">End Time</label>
                    <input type="time" name="end_time" id="end_time" min="10:00" max="17:00" value="<?php echo $row_dentist['end_time'] ?>">
                    <br>
                    <input type="submit" name="update_dentist" value="Update">
                    </form>

                <?php
                
            }
        }
    }


    ?>
</body>
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
        echo "updated";
        $query_update_schedule = "UPDATE schedule SET day = '$days_combined_updated', start_time = '$start_time', end_time = '$end_time' WHERE user_id = '$user_id'";
        $run_update_schedule = mysqli_query($conn, $query_update_schedule);
    } else {
        echo "error: " . $conn->error;
    }

}


?>