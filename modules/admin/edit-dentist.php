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
                    <label for="">Current Schedule</label>
                    <p><?php echo $row_dentist['day']?></p>
                    <label for="">Schedule</label><br>
                    <input type="checkbox" name="schedule[]" value="Monday">  Monday <br>
                    <input type="checkbox" name="schedule[]" value="Tuesday"> Tuesday <br>
                    <input type="checkbox" name="schedule[]" value="Wednesday"> Wednesday <br>
                    <input type="checkbox" name="schedule[]" value="Thursday"> Thursday <br>
                    <input type="checkbox" name="schedule[]" value="Friday"> Friday <br>
                    <input type="checkbox" name="schedule[]" value="Saturday"> Saturday <br>
                    <label for="">Start Time</label>
                    <input type="time" name="start_time" value="<?php echo $row_dentist['start_time']?>">
                    <label for="">End Time</label>
                    <input type="time" name="end_time" value="<?php echo $row_dentist['end_time']?>">
                    <input type="submit" name="update_dentist" value="Update">
                    </form>

                <?php
                
            }
        }
    }


    ?>
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

    $days_combined = implode(' ', $schedule);


    $query_update = "UPDATE users SET first_name = '$first_name', middle_name = '$middle_name', last_name='$last_name', date_updated = '$date' WHERE user_id = '$user_id'" ;
    $run_update = mysqli_query($conn,$query_update);

    if($run_dentist){
        echo "updated";
        $query_update_schedule = "UPDATE schedule SET day = '$days_combined', start_time = '$start_time', end_time = '$end_time' WHERE user_id = '$user_id'" ;
        $run_update_schedule = mysqli_query($conn,$query_update_schedule);
    }else{
        echo "error". $conn->error;
    }

}


?>