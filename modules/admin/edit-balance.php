<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/Payments/payments.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/scripts.php'); 

if(isset($_POST['update_balance'])){
	$payment_id = $_POST['payment_id'];
	$edit_balance = $_POST['edit_balance'];
	$user_id = $_POST['user_id'];
	$services = $_POST['services'];

	$run_update_balance = updateBalance($conn, $edit_balance, $payment_id);
	if($run_update_balance){
		echo "<script> success('Balance updated successfully.', () => window.location.href='view-patient-payments.php?user_id=$user_id&concern=$services') </script>";
	}else{
		echo "<script> error('Something went wrong!', () => window.location.href='view-patient-payments.php?user_id=$user_id&concern=$services') </script>";

	}
}


?>