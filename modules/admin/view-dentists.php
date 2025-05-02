<?php
include('../connection/connection.php');
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

<h1>View Dentists</h1>
<a href="dashboard.php">Back</a>

<table>
  <tr>
    <th>Id</th>
    <th>Name</th>
    <th>Schedule</th>
    <th>Email</th>
    <th>Contact Number</th>
  </tr>

    <?php

    $query_dentists = "SELECT users.user_id AS user_id, users.first_name AS first_name, users.middle_name AS middle_name, users.last_name AS last_name, users.mobile_number AS mobile_number, users.email AS email, schedule.user_id AS schedule_user_id, schedule.day AS day , schedule.time AS time
    FROM
    users 
    LEFT JOIN schedule 
    ON users.user_id = schedule.user_id 
    WHERE users.role_id = '3'";
    $run_dentists = mysqli_query($conn,$query_dentists);

    if(mysqli_num_rows($run_dentists) > 0){
        foreach($run_dentists as $row_dentist){
            ?>

            <tr>
                <td><?php echo $row_dentist['first_name'] . $row_dentist['middle_name'] . $row_dentist['last_name']?></td>
                <td><?php echo $row_dentist['day'] . $row_dentist['time']?></td>
            </tr>


            <?php
        }
    }

    ?>

 
</table>


    
</body>
</html>