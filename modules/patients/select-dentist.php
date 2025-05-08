<?php
include('../../connection/connection.php');
ob_start();
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    include('../../includes/styles.php');
    ?>
    <!-- jQuery UI -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <title>Document</title>
</head>
<body>

<a href="appointments.php">Back</a>

    <?php

    if(isset($_GET['user_id'])){
        $user_id = $_GET['user_id'];

        $query_dentist = "SELECT users.user_id AS user_id, users.first_name AS first_name, users.middle_name AS middle_name, users.last_name AS last_name, users.mobile_number AS mobile_number, users.email AS email, schedule.user_id AS schedule_user_id, schedule.day AS day , schedule.start_time AS start_time , schedule.end_time AS end_time
        FROM
        users 
        LEFT JOIN schedule 
        ON users.user_id = schedule.user_id 
        WHERE users.role_id = '3' AND users.user_id =  '$user_id'";
        $run_dentist = mysqli_query($conn,$query_dentist);
        $row_dentist = mysqli_fetch_assoc($run_dentist);
        json_encode($available_days = explode(", ", $row_dentist['day']));
            
        ?>

            <form action="" method="POST">
            <label>Select Appointment Date:</label>
            <input type="text" class="appointment_date" name="appointment_date">
                ....
                <label for="">Doctor:</label>
                <p>Dr.<?php echo $row_dentist['first_name']. " " . $row_dentist['last_name']?></p>
                <label for="">Concern:</label>
                <input type="text" name="concern" required>
                <br>
                <input type="submit" name="save" value="Save">
            </form>


        <?php
        
    }

    ?>
    
<?php include('../../includes/scripts.php')?>
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
        }
    });
});
</script>
</body>
</html>

<?php

if(isset($_POST['save'])){
    date_default_timezone_set("Asia/Manila");
    $date = date('y-m-d');
    $appointment_id = "2025".rand('1','10') . substr(str_shuffle(str_repeat("0123456789", 5)), 0, 3) ;

    $user_id = $_GET['user_id'];
    $user_id_patient = $_SESSION['user_id'];
    $concern = $_POST['concern'];

    $appointment_date  = $_POST['appointment_date'];

    $check_appointment = "SELECT appointment_date FROM appointments WHERE appointment_date =  '$appointment_date'";
    $run_check_appointment = mysqli_query($conn,$check_appointment);
    if(mysqli_num_rows($run_check_appointment) > 0){
        echo "already added in this particular date";
    }else{
        $query_appointment = "INSERT INTO appointments (user_id,user_id_patient,appointment_id,concern,confirmed,appointment_date,date_created,date_updated) VALUES ('$user_id','$user_id_patient','$appointment_id','$concern', '0', '$appointment_date','$date', '$date')";
        $run_appointment = mysqli_query($conn,$query_appointment);
        if($run_appointment) {
            echo "added appointment";
        }else{
            echo "not added";
        }
    }
}

?>