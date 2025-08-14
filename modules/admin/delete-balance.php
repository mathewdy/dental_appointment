<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/Payments/payments.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/scripts.php'); 

if (isset($_GET['user_id']) && isset($_GET['payment_id']) && isset($_GET['concern'])) {
    $user_id = $_GET['user_id'];
    $payment_id = $_GET['payment_id'];
    $concern = $_GET['concern'];

    $run = deleteBalance($conn, $user_id, $payment_id);
    if ($run) {
			echo "<script> success('Deleted successfully.', () => window.location.href = 'view-patient-payments.php?user_id=$user_id&concern=$concern') </script>";
    } else {
			echo "<script> error('Something went wrong!', () => window.location.href = 'view-patient-payments.php?user_id=$user_id&concern=$concern') </script>";
    }
}
?>
