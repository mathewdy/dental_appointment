<?php

include('../connection/connection.php');
session_start();
ob_start();
$email = $_SESSION['email'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include '../includes/styles.php' ?>
    <title>Document</title>
</head>
<body>
<div class="container" style="height: 55em;">
        <div class="row d-flex justify-content-center align-items-center p-5" style="height: 100%;">
            <div class="col-6">
                <div class="card w-100 border-none rounded-0">
                    <div class="row" style="height: 100%;">
                        <div class="col-lg-12 p-5 d-flex flex-column justify-content-center text-center">
                            <span class="text-center">
                                <img src="../assets/img/logo.png" height="100" alt="">
                            </span>
                            <span class="mb-4 text-center">
                                <h1>OTP Verification</h1>
                                <p>A verification code has been sent to your email.</p>
                            </span>
                            <form action="" method="POST">
                                <input type="number" class="form-control mb-5"name="otp_number">
                                <input type="submit" class="btn btn-black op-8 w-100 mb-2" name="verify" value="Verify">
                                <a href="login.php" class="text-black op-9">Go Back</a>
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <?php include "../includes/scripts.php"; ?>
</html>

<?php
if(isset($_POST['verify'])){
    $otp_number = $_POST['otp_number'];
    
    $query_otp = "SELECT otp FROM users WHERE email =  '$email'";
    $run_otp = mysqli_query($conn,$query_otp);
    $row_otp = mysqli_fetch_assoc($run_otp);

    if($row_otp['otp'] == $otp_number){
        echo "accepted";
        header("Location: ../modules/patients/dashboard.php");
    }else{
        echo "wrong number";
    }

}


?>