<?php

include('../../connection/connection.php');
session_start();
ob_start();
//errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<a href="dashboard.php">Back</a>
<a href="add-patient.php">Add Patient</a>
    <h1>Patients</h1>


    <table>
        <tr>
            <th>Name</th>
            <th>Mobile Number</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>

        
        <?php
        //retrieve user info , update user info, schedules per patient, 

        $query_patients = "SELECT users.user_id, users.first_name,users.middle_name,users.last_name,users.mobile_number,users.email,users.password,users.date_of_birth,users.address, appointments.appointment_id,appointments.concern,appointments.confirmed,appointments.appointment_date,appointments.remarks
        FROM users
        LEFT JOIN appointments
        ON users.user_id = appointments.user_id WHERE users.role_id = '1'";

        $run_patients = mysqli_query($conn,$query_patients);

        if(mysqli_num_rows($run_patients) > 0){
            foreach($run_patients as $row_patients){
                ?>

                <tr>
                    <td><?php echo $row_patients['first_name'] . " " . $row_patients['last_name']?></td>
                    <td><?php echo $row_patients['mobile_number']?></td>
                    <td><?php echo $row_patients['email']?></td>
                    <td>
                        <a href="edit-patient.php?user_id=<?php echo $row_patients['user_id']?>">Edit</a>
                        <a href="delete-patient.php?user_id=<?php echo $row_patients['user_id']?>">Delete</a>
                        
                    </td>
                </tr>

                <?php
            }
        }

        ?>
    </table>
</body>
</html>