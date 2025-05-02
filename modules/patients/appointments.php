<?php
include('../../connection/connection.php');
ob_start();
session_start();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Select Dentist</h1>

    <form action="" method="POST">
        <select name="dentist">
            <option value="">--Select--</option>
            <?php 

            $query_dentist = "SELECT users.user_id AS user_id, users.first_name AS first_name, users.middle_name AS middle_name, users.last_name AS last_name, users.mobile_number AS mobile_number, users.email AS email, schedule.user_id AS schedule_user_id, schedule.day AS day , schedule.time AS time
            FROM
            users 
            LEFT JOIN schedule 
            ON users.user_id = schedule.user_id 
            WHERE users.role_id = '3'";
            $run_dentist = mysqli_query($conn,$query_dentist);
            while($row_dentist = mysqli_fetch_assoc($run_dentist)){
                ?>

                <option value=""><?php echo $row_dentist['first_name']. " " . $row_dentist['last_name']; ?></option>

                <?php
            }

            ?>
        </select>
        <input type="submit" name="set_appointment" value="">
    </form>
</body>
</html>