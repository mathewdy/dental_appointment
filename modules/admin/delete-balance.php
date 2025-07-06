<?php
ob_start();
session_start();
date_default_timezone_set('Asia/Manila');
include('../../connection/connection.php');

if (isset($_GET['user_id']) && isset($_GET['payment_id']) && isset($_GET['concern'])) {
    $user_id = $_GET['user_id'];
    $payment_id = $_GET['payment_id'];
    $concern = $_GET['concern'];

    $query_delete = "DELETE FROM payments WHERE user_id = '$user_id' AND payment_id = '$payment_id'";
    $run = mysqli_query($conn, $query_delete);

    if ($run) {
        header("Location: view-patient-payments.php?user_id=$user_id&concern=$concern");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
