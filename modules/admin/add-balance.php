<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/notification.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$id = $_SESSION['user_id'];

if(isset($_POST['add_balance'])){

    date_default_timezone_set("Asia/Manila");
    $date = date('y-m-d');
    $dateTime = date('Y-m-d H:i:s');
    $payment_id = "2025".rand('1','100') . substr(str_shuffle(str_repeat("0123456789", 5)), 0, 3);
    $user_id = $_POST['user_id'];
    $services = $_POST['concern']; //concern & services ay iisa
    $remaining_balance = $_POST['remaining_balance'];
    $appointment_id = $_POST['appointment_id'];
    $query_insert_payment = "INSERT INTO payments (payment_id,user_id,appointment_id, services,initial_balance,remaining_balance,date_created,date_updated) 
		VALUES ('$payment_id','$user_id','$appointment_id' ,'$services','$remaining_balance','$remaining_balance','$date', '$date')";
    $run_insert_payment = mysqli_query($conn,$query_insert_payment);

    if($run_insert_payment){
      createNotification($conn, $user_id, "Initial Balance Added", "Payment", $dateTime, $id);
      createNotification($conn, $id, "Initial Balance Added", "Payment", $dateTime, $id);

			echo "<script>
				window.alert('Added Balance');
				window.location.href='view-patient-payments.php?user_id=$user_id&concern=$services';
				</script>";
    }else{
        echo "error";
    }



}


?>