<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Payments/payments.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/scripts.php');

if (isset($_POST['update_balance'])) {
    $payment_id = $_POST['payment_id'];
    $edit_balance = $_POST['edit_balance'];
    $user_id = $_POST['user_id'];
    $concern = $_POST['concern'];

    $run_update_balance = updateConcernAndBalance($conn, $edit_balance, $concern, $payment_id);
    if ($run_update_balance) {
        echo "<script> success('Balance and Concern updated successfully.', () => window.location.href='view-patient-payments.php?user_id=$user_id&concern=$concern') </script>";
    } else {
        echo "<script> error('Something went wrong!', () => window.location.href='view-patient-payments.php?user_id=$user_id&concern=$concern') </script>";

    }
}
?>