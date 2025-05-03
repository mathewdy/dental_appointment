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
    //errors
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $query_dentists = "SELECT users.user_id AS user_id, users.first_name AS first_name, users.middle_name AS middle_name, users.last_name AS last_name, users.mobile_number AS mobile_number, users.email AS email, schedule.user_id AS schedule_user_id, schedule.day AS day , schedule.start_time AS start_time, schedule.end_time AS end_time
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
                <td><?php echo $row_dentist['user_id']?></td>
                <td><?php echo $row_dentist['first_name']. " " . $row_dentist['middle_name'] . " " . $row_dentist['last_name']?></td>
                <td><?php echo $row_dentist['day'] . date("g:i A",strtotime($row_dentist['start_time'])). "& " . date("g:i A", strtotime($row_dentist['end_time'])) ?></td>
                <td><?php echo $row_dentist['email']?></td>
                <td><?php echo $row_dentist['mobile_number']?></td>
                <td>
                    <a href="edit-dentist.php?user_id=<?php echo$row_dentist['user_id']?>">Edit</a>
                    <a href="delete-dentist.php?user_id<?php echo $row_dentist['user_id']?>">Delete</a>
                </td>
            </tr>


            <?php
        }
    }

    ?>

 
</table>


    
</body>
</html>