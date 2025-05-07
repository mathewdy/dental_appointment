<?php
ob_start();
session_start();
include('../../connection/connection.php');
if(isset($_POST['decline'])){
    $decline = "2";
    $user_id_patient = $_SESSION['user_id'];
    $appointment_date = $_POST['appointment_date'];
    $update_appointment = "UPDATE appointments SET confirmed = '$decline' WHERE user_id_patient = '$user_id_patient' AND appointment_date = '$appointment_date'";
    $run_update_appointment = mysqli_query($conn,$update_appointment);

    if($run_update_appointment){
        echo "updated declined";
        echo "<script>window.alert('Declined')</script>";
        echo "<script>window.location.href='appointments.php'</script>";
    }else{
        echo "error" ; 
    }
}

?>