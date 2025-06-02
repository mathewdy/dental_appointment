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

    <!-- Note: to be determined if we're going to add this -->
    <!-- <nav class="navbar navbar-expand-lg bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="../assets/img/banner-2.png" alt="Logo" width="100%" height="50" class="d-inline-block align-text-top">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
            <ul class="navbar-nav ms-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle disabled" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Clinic
                </a>
                <ul class="dropdown-menu" style="z-index: 2 !important; opacity: 100%;">
                    <li><a class="dropdown-item" href="#">No content yet</a></li>
                </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact Us</a>
                </li>
            </ul>
            </div>
        </div>
    </nav> -->
    <div class="container" style="height: 55em;">
        <div class="row d-flex justify-content-center align-items-center p-5" style="height: 100%;">
            <div class="col-12">
                <div class="card w-100 border-none rounded-0" style="height: 45em;">
                    <div class="row" style="height: 100%;">
                        <div class="col-lg-6 p-5 d-flex flex-column justify-content-center ">
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
                                        <input type="email" class="form-control" name="email" placeholder="Enter your email">
                                    </div>
                                    <div class="col-lg-12 mb-5">
                                        <div class="input-group mb-3">
                                            <input type="password" class="form-control pw" name="password" aria-describedby="basic-addon2" id="pw" placeholder="•••••••">
                                            <span class="input-group-text pw-toggle" id="basic-addon2" style="cursor:pointer;" data-target="#pw"><i class="fas fa-eye"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 text-center">
                                        <input type="submit" class="btn btn-black op-8 w-100 mb-2" name="login" value="Login">
                                        <a href="forgot-password.php" class="text-dark">Forgot Password?</a>
                                    </div>
                                </div>                                                      
                            </form>
                        </div>
                        <div class="col-lg-6 bg-dark">
                            <div class=" text-light d-flex align-items-center justify-content-center" style="height:100%;">
                                <div class="row">
                                    <div class="col-lg-12 align-items-center text-center">
                                        <h1 class="display-5 fw-bold">Welcome to login</h1>
                                        <p>Don't have an account?</p>
                                        <a href="registration.php" class="btn text-white border-light btn-round">Sign Up</a>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include "../includes/scripts.php"; ?>
</body>
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
                // $_SESSION['image'] = $row['image'];
                $_SESSION['role_id'] = $row['role_id'];
                
                if($row['role_id'] == '1' ){
                    $update_otp = "UPDATE users SET otp = '$otp' WHERE email = '$email'";
                    $update_otp_run = mysqli_query($conn,$update_otp);
            
                    if($update_otp_run){
                        send_otp($email,$otp);
                        //echo "otp sent";
                        $_SESSION['email'] = $email ;
                        echo "<script> alert('Please Check Your Email Address for OTP') </script>";
                        echo "<script>window.location.href='otp.php'</script>";
                    }
                }else{
                    echo "<script>window.alert('Authentication Failed')</script>";
                    echo "<script>window.location.origin</script>";
                }
  
            }
        }
    } else {
        echo "<script>window.alert('Invalid Credentials')</script>";
        echo "<script>window.location.origin</script>";
    }
}

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

ob_end_flush();

?>