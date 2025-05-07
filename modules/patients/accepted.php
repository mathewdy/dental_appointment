<?php
ob_start();
session_start();
include('../../connection/connection.php');
if(isset($_POST['accept'])){
    $accept = "1";
    $user_id_patient = $_SESSION['user_id'];
    $appointment_date = $_POST['appointment_date'];
    $update_appointment = "UPDATE appointments SET confirmed = '$accept' WHERE user_id_patient = '$user_id_patient' AND appointment_date = '$appointment_date'";
    $run_update_appointment = mysqli_query($conn,$update_appointment);

    if($run_update_appointment){
        echo "updated accpeted";
        echo "<script>window.alert('Accepted')</script>";
        echo "<script>window.location.href='appointments.php'</script>";
    }else{
        echo "error" ; 
    }
}
?>