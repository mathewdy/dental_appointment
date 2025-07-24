<?php
ob_start();
session_start();
include('../../connection/connection.php');
if(isset($_POST['accept'])){
    // echo "hello";
    $accept = "1";
    $remarks = $_POST['remarks'];
    $user_id_patient = $_POST['user_id_patient'];
    $appointment_date = $_POST['appointment_date'];
    $update_appointment = "UPDATE appointments SET confirmed = '$accept', remarks = '$remarks' WHERE user_id_patient = '$user_id_patient' AND appointment_date = '$appointment_date'";
    $run_update_appointment = mysqli_query($conn,$update_appointment);

    if($run_update_appointment){
        header("Location: appointment-requests.php");
    }else{
        echo "error" ; 
    }
}
?>