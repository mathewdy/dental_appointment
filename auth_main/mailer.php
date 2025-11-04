<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/Users/users.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/Mailer/mail.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/scripts.php');

if(isset($_POST['send_email']))
{
  $email = $_POST['email'];
  $token = md5(rand());
  $subject = "Password Reset";
  $mail = "
  <h2>Hello! </h2>
  <h3>We received a request to reset the password for your account. If this was you, please follow the instructions to reset it. If not, feel free to ignore this message! </h3>
  <br></br>
  <a href='http://" . $_SERVER['SERVER_NAME'] . "/dental_appointment/auth_main/password-reset.php?token=$token&$email"."'>Click me</a>";

  $check_email_run  = checkAllUserByEmail($conn, $email);
  if(mysqli_num_rows($check_email_run) > 0){

      $row = mysqli_fetch_array($check_email_run);
      $email = $row['email'];

      $update_token = "UPDATE users SET token = '$token' WHERE email = '$email'";
      $update_token_run = mysqli_query($conn,$update_token);

      if($update_token_run){
        sendEmail($mail, $subject, $email);
        echo "<script> success('Please Check Your Email Address for OTP.', () => window.location.href='login.php') </script>";
      }

  }else{
    echo "<script> error('User Not Found.', () => window.location.href='login.php') </script>";

  }
}
ob_end_flush();

?>