<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/security.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_POST['update_balance'])){
    $payment_id = $_POST['payment_id'];
    $edit_balance = $_POST['edit_balance'];
    $user_id = $_POST['user_id'];
    $services = $_POST['services'];

    $query_update_balance = "UPDATE payments SET initial_balance = '$edit_balance' , remaining_balance = '$edit_balance' WHERE payment_id = '$payment_id'";
    $run_update_balance = mysqli_query($conn,$query_update_balance);

    if($run_update_balance){
        echo "<script>
            window.alert('Updated Balance');
            window.location.href='view-patient-payments.php?user_id=$user_id&concern=$services';
        </script>";
    }else{
        echo "Error" ; 
    }
}


?>