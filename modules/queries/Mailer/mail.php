<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendEmail($message, $title, $creds) {
  include_once($_SERVER['DOCUMENT_ROOT'] . '/PHPMailer/src/PHPMailer.php');
  include_once($_SERVER['DOCUMENT_ROOT'] . '/PHPMailer/src/SMTP.php');
  include_once($_SERVER['DOCUMENT_ROOT'] . '/PHPMailer/src/Exception.php');

  $mail = new PHPMailer(true);

//   try {
//     $mail->isSMTP();
//     $mail->Host = 'smtp.hostinger.com';       
//     $mail->SMTPAuth = true;
//     $mail->Username = 'rome@fojas-dental-clinic.com';
//     $mail->Password = '|AU&?k:/By5';
//     $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
//     $mail->Port       = 465;                

//     $mail->setFrom('rome@fojas-dental-clinic.com', 'Dental Clinic');
//     $mail->addAddress($creds);    

//     $mail->isHTML(true);                         
//     $mail->Subject = $title;
//     $mail->Body    = $message;

//     $mail->send();
//     echo ""; 

//     return true;
//   } catch (Exception $e) {
//     return false;
//   }
  
  try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.hostinger.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'rome@fojas-dental-clinic.com';
        $mail->Password   = 'mathewPOGI!@#123';
        $mail->Port       = 587;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->SMTPAutoTLS = true;

        // Email content
        $mail->setFrom('rome@fojas-dental-clinic.com', 'Dental Clinic');
        $mail->addAddress($creds); // FIXED

        $mail->isHTML(true);
        $mail->Subject = $title;
        $mail->Body    = $message;

        $mail->send();
        return true;

    } catch (Exception $e) {
        error_log('Mailer Error: ' . $mail->ErrorInfo);
        return false;
    }

}