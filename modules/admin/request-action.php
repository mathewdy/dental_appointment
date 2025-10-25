<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/Appointments/appointments.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/scripts.php'); 

if(isset($_GET['id'] && isset($_GET['action']))){
	$id = $_GET['id'];
  $action = $_GET['action'];

  $run_query = updateStatus($conn, $appointment_id);
  if($run_query){
		echo "<script> success('Updated successfully.', () => window.location.href = 'requests.php') </script>";
	}else{
		echo "<script> error('Something went wrong!', () => window.location.href = 'requests.php') </script>";
	}
}


?>