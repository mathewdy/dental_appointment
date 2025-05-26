<?php
ob_start();
session_start();
date_default_timezone_set('Asia/Manila');
include('../connection/connection.php');

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
                <div class="card w-100 border-none rounded-0" style="height: 45em;">
                    <div class="row" style="height: 100%;">
                        <div class="col-lg-12 p-5 d-flex flex-column justify-content-center ">
                            <span class="text-center">
                                <img src="../assets/img/logo.png" height="100" alt="">
                            </span>
                            <span class="mb-4 text-center">
                                <h1>Sign In</h1>
                            </span>
                            <form action="" method="POST">
                                <div class="row px-4">
                                    <div class="col-lg-12 mb-5">
                                        <label for="">Email</label>
                                        <input type="email" class="form-control" name="email" placeholder="Email">
                                    </div>
                                    <div class="col-lg-12 mb-5">
                                        <label for="">Password </label>
                                        <div class="input-group mb-3">
                                            <input type="password" class="form-control pw" name="password" aria-describedby="basic-addon2" id="pw">
                                            <span class="input-group-text pw-toggle" id="basic-addon2" style="cursor:pointer;" data-target="#pw"><i class="fas fa-eye"></i></span>
                                        </div>
                                        <span class="d-flex justify-content-end">
                                            <a href="forgot-password.php" class="text-dark">Forgot Password?</a>
                                        </span>
                                    </div>
                                    <div class="col-lg-12 text-center">
                                        <input type="submit" class="btn btn-black op-8 w-100 mb-2" name="login" value="Login">
                                        <a href="registration.php" class="text-black">Create new account</a>
                                    </div>
                                </div>                                                      
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <?php include "../includes/scripts.php"; ?>
</html>

<?php

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $otp = substr(str_shuffle("0123456789"), 0, 5);

    $query_login = "SELECT * FROM users WHERE email = '$email'";
    $run_login = mysqli_query($conn, $query_login);

    if (mysqli_num_rows($run_login) > 0) {
        foreach ($run_login as $row) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['email'] = $email;
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['first_name'] = $row['first_name'];
                $_SESSION['last_name'] = $row['last_name'];
                $_SESSION['image'] = $row['image'];

                $_SESSION['role_id'] = $row['role_id'];

                if($row['role_id'] == '2' || $row['role_id'] == '3' ){
                    $update_otp = "UPDATE users SET otp = '$otp' WHERE email = '$email'";
                    $update_otp_run = mysqli_query($conn,$update_otp);
        
                    if($update_otp_run){
                        send_otp($email,$otp);
                        //echo "otp sent";
                        $_SESSION['email'] = $email ;
                        $_SESSION['role_id'] = $row['role_id'];
                        echo "<script> alert('Please Check Your Email Address for OTP') </script>";
                        echo "<script>window.location.href='otp.php'</script>";
                    }

                }else{
                    echo "<script>window.alert('Authentication Failed')</script>";
                }
            }
        }
    } else {
        echo "<script>window.alert('Invalid Credentials')</script>";
        echo "<script>window.location.origin</script>";
    }
}
ob_end_flush();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function send_otp($email,$otp){
    require("../PHPMailer/src/PHPMailer.php");
    require("../PHPMailer/src/SMTP.php");
    require("../PHPMailer/src/Exception.php");

    $mail = new PHPMailer(true);

    try {
        //Server settings

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';        // e.g., smtp.gmail.com
        $mail->SMTPAuth = true;
        $mail->Username = 'fojasdentalclinic@gmail.com';
        $mail->Password = 'clzodzskinrbfnsh';
        $mail->SMTPSecure = 'tls';               // or 'ssl'
        $mail->Port = 587;                       // use 465 for SSL
        //Recipients
        $mail->setFrom('fojasdentalclinic@gmail.com', 'Dental Clinic');
        $mail->addAddress($email);     //Add a recipient
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'One Time Password';
        $mail->Body    = "<h2>Here's your OTP</h2> <h3> $otp </h3>";
        $mail->send();
        echo ""; //please check your email address;
        return true;
    } catch (Exception $e) {
        echo "not sent";
        return false;
    }
}


?>