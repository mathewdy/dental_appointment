<?php
include('../connection/connection.php');
ob_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function send_password_reset($email,$token){
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
        $mail->Subject = 'Forgot Password';
        $mail->Body    = "<h2>Hello! </h2>
        
        <h3>We received a request to reset the password for your account. If this was you, please follow the instructions to reset it. If not, feel free to ignore this message! </h3>
        <br></br>
        <a href='http://" . $_SERVER['SERVER_NAME'] . "/dental_appointment/auth/password-reset.php?token=$token&$email"."'>Click me</a>";
        

        $mail->send();
        echo ""; //please check your email address;

        return true;
    } catch (Exception $e) {
        echo "not sent";
        return false;
    }
}

if(isset($_POST['send_email']))
{
    $email = $_POST['email'];
    $token = md5(rand());

    $check_email = "SELECT * FROM users WHERE email =  '$email' LIMIT 1";
    $check_email_run = mysqli_query($conn,$check_email);

    if(mysqli_num_rows($check_email_run) > 0){

        $row = mysqli_fetch_array($check_email_run);
        $email = $row['email'];

        $update_token = "UPDATE users SET token = '$token' WHERE email = '$email' LIMIT 1";
        $update_token_run = mysqli_query($conn,$update_token);

        if($update_token_run){
            send_password_reset($email,$token);
            echo "<script> alert('Please Check Your Email Address') </script>";
            echo "<script>window.location.href='login.php'</script>";
        }

    }else{
        echo "User Not Found";
    }
   
    
}
ob_end_flush();

?>