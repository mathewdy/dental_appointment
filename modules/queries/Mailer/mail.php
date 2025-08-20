<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendEmail($message, $title, $creds) {
  include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/PHPMailer/src/PHPMailer.php');
  include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/PHPMailer/src/SMTP.php');
  include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/PHPMailer/src/Exception.php');

  $mail = new PHPMailer(true);

  try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';       
    $mail->SMTPAuth = true;
    $mail->Username = 'fojasdentalclinic@gmail.com';
    $mail->Password = 'clzodzskinrbfnsh';
    $mail->SMTPSecure = 'tls';            
    $mail->Port = 587;                      

    $mail->setFrom('fojasdentalclinic@gmail.com', 'Dental Clinic');
    $mail->addAddress($creds);    

    $mail->isHTML(true);                               
    $mail->Subject = $title;
    $mail->Body    = $message;

    $mail->send();
    echo ""; 

    return true;
  } catch (Exception $e) {
    echo "not sent";
    return false;
  }
}