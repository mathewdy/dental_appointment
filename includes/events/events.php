<?php
session_start();
require_once('../../connection/connection.php');
require_once('event-clause.php');
require_once('event-builder.php');
header('Content-Type: application/json');

$id = $_SESSION['user_id'];
$role = $_SESSION['role_id'];

$query_appointments = queryEventBuilder($role, $id);
$run_appointments = mysqli_query($conn,$query_appointments);
if(mysqli_num_rows($run_appointments) > 0){
    foreach($run_appointments as $row_appointment){
      
      $status = match($row_appointment['confirmed']){
        '0' => "Pending",
        '1' => "Completed",
        '2' => "Canceled"
      };
      $color = match($status){
        'Completed' => '#28a745',
        'Pending'   => '#ffc107',
        'Canceled' => '#dc3545'
      };
      $formattedDate = date("Y-m-d", strtotime($row_appointment['appointment_date']));
      $date = str_replace("/", "-",$formattedDate);
      $events[]= [
          'title' => $status,
          'start' => $date,
          'color' => $color
      ];
    }
  }
  else{
    $events[] = [];
  }


echo json_encode($events);
?>