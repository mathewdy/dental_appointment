<?php
ob_start();
session_start();
date_default_timezone_set('Asia/Manila');
include('../../connection/connection.php');
if(isset($_GET['user_id'])){
    $user_id = $_GET['user_id'];
    $query_delete = "DELETE FROM users WHERE user_id = '$user_id'";
    $run = mysqli_query($conn,$query_delete);

    if($run){
        header('location: patients.php');
    }else{
        echo "error" . $conn->error;
    }

}


?>