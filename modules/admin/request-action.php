<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Appointments/appointments.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/scripts.php'); 

if(isset($_GET['id']) && isset($_GET['status'])){
  $id = $_GET['id'];
  $action = $_GET['status'];

  $run_query = updateStatus($conn, $id, $action);
  if($run_query){
		echo "<script> success('Updated successfully.', () => window.location.href = 'requests.php') </script>";
	}else{
		echo "<script> error('Something went wrong!', () => window.location.href = 'requests.php') </script>";
	}
}


?>