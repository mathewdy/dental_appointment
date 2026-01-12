<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Users/users.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/scripts.php'); 

if(isset($_GET['user_id'])){
	$user_id = $_GET['user_id'];

	$run = deleteUser($conn, $user_id);
  if($run){
		echo "<script> success('Deleted successfully.', () => window.location.href = 'patients.php') </script>";
	}else{
		echo "<script> error('Something went wrong!', () => window.location.href = 'patients.php') </script>";
	}

}


?>