<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/Users/users.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/Mailer/mail.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/scripts.php');

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $otp = substr(str_shuffle("0123456789"), 0, 5);
    $subject = "One Time Password";
    $mail =  "<h2>Here's your OTP</h2> <h3> $otp </h3>";

    $run_login = checkAllUserByEmail($conn, $email);

    if (mysqli_num_rows($run_login) > 0) {
        foreach ($run_login as $row) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['email'] = $email;
                
                if($row['role_id'] == '1' ){
                    $update_otp_run = updateOtp($conn, $otp, $email);            
                    if($update_otp_run){
                      sendEmail($mail, $subject, $email);
                      $_SESSION['email'] = $email;
                      $_SESSION['role_id'] = $row['role_id'];
                      echo "<script> success('Please Check Your Email Address for OTP.', () => window.location.href='otp.php') </script>";
                    }else{
                      echo "<script> error('Otp sending failed.', () => window.location.href='login.php') </script>";
                      return;
                    }
                }else{
                  echo "<script> error('Invalid Credentials', () => window.location.href='login.php') </script>";
                  return;
                }
            }else{
              echo "<script> error('Invalid Credentials', () => window.location.href='login.php') </script>";
              return;
            }
        }
    } else {
      echo "<script> error('Something went wrong!', () => window.location.href='login.php') </script>";
      return;
    }
}

?>