<?php

include('../../connection/connection.php');
ob_start();
session_start();
$first_name = $_SESSION['first_name'];
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$user_id_patients = $_SESSION['user_id'];

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

<a href="dashboard.php">Back</a>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="text-center">
                <table>
                    <tr>
                        <th>Appointment Date & Time</th>
                        <th>Dentist</th>
                        <th>Concern</th>
                        <th>Doctor's Remarks</th>
                    </tr>
                
                    <?php

                        $query_appointments = "SELECT appointments.user_id, appointments.user_id_patient, appointments.concern, appointments.appointment_date, users.first_name, users.middle_name, users.last_name, schedule.start_time, schedule.end_time, appointments.confirmed, appointments.remarks
                        FROM appointments
                        LEFT JOIN users
                        ON
                        appointments.user_id = users.user_id
                        LEFT JOIN schedule
                        ON appointments.user_id = schedule.user_id WHERE appointments.user_id_patient =  '$user_id_patients'";
                        $run_appointments = mysqli_query($conn,$query_appointments);
                        if(mysqli_num_rows($run_appointments) > 0){
                            foreach($run_appointments as $row_appointment){
                                ?>
                                <tr>
                                    <td><?php echo $row_appointment['appointment_date']. " " . date("g:i A",strtotime($row_appointment['start_time'])). "-". date("g:i A",strtotime($row_appointment['end_time']))?></td>
                                    <td>Dr. <?php echo $row_appointment['first_name'] . " " . $row_appointment['last_name']?></td>
                                <td><?php echo $row_appointment['concern']?></td>
                                <td><?php echo $row_appointment['remarks']?></td>
                                </tr>
                                <?php
                            }
                        }else{
                            echo "No Data";
                        }
                    ?>
                </table>
                </div>
            </div>
        </div>
    </div>

</body>
</html>