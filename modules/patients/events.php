<?php
session_start();
require_once('../../connection/connection.php');
header('Content-Type: application/json');

$userId = $_SESSION['user_id'];
$query_appointments = "SELECT appointments.user_id, appointments.user_id_patient, appointments.concern, appointments.appointment_date, users.first_name, users.middle_name, users.last_name, schedule.start_time, schedule.end_time, appointments.confirmed
FROM appointments
LEFT JOIN users
ON appointments.user_id = users.user_id
LEFT JOIN schedule 
ON appointments.user_id = schedule.user_id 
WHERE appointments.user_id_patient =  '$userId'";
$run_appointments = mysqli_query($conn,$query_appointments);
if(mysqli_num_rows($run_appointments) > 0){
    foreach($run_appointments as $row_appointment){
      
      $status = match($row_appointment['confirmed']){
        '0' => "Pending",
        '1' => "Completed",
        '2' => "Canceled"
      };
      $formattedDate = date("Y-m-d", strtotime($row_appointment['appointment_date']));
      $date = str_replace("/", "-",$formattedDate);
      $events[]= [
          'title' => $status,
          'start' => $date
      ];
    }
  }
  else{
    $events[] = [];
  }


echo json_encode($events);
?>