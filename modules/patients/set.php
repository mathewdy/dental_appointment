<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/notification.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/Appointments/appointments.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/Users/dentists.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/Mailer/mail.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/scripts.php'); 

if(isset($_POST['save'])){
  $user_id_dentist = $_POST['dentist'];
  $user_id_patient = $_SESSION['user_id'];
  $appointment_id = "2025".rand('1','10') . substr(str_shuffle(str_repeat("0123456789", 5)), 0, 3) ;
  $concern = $_POST['concern'];
  $appointment_time = $_POST['appointment_time'];

  $appointment_date = $_POST['appointment_date'];
  $email = $_SESSION['email'];
  $subject = "Appointment Schedule";
  $mail = "
    <p>Dear Customer,</p>
    <p>We are happy to confirm that your appointment has been successfully scheduled.</p>
    <p><strong>Appointment Details:</strong></p>

    <strong>Appointment Date:</strong> $appointment_date

    <p>If you need to reschedule or make any changes, please don't hesitate to contact us.</p>
    <p>Thank you for choosing our clinic!</p>
    <p>Best Regards, <br>Fojas Dental Clinic</p>
  "; 

  $get_dentist = getDentistById($conn, '3', $user_id_dentist);
  $run_dentist = mysqli_fetch_assoc($get_dentist);

  $dentist_start = $run_dentist['start_time'];
  $dentist_end = $run_dentist['end_time'];    
  $formatted_dentist_start = date("h:i A", strtotime($dentist_start));
  $formatted_dentist_end = date("h:i A", strtotime($dentist_end));

  $appointment_timestamp = strtotime($appointment_time);
  $start_timestamp = strtotime($dentist_start);
  $end_timestamp = strtotime($dentist_end);

  if ($appointment_timestamp < $start_timestamp || $appointment_timestamp > $end_timestamp) {
    echo "<script> error('Appointment time is outside of dentist working hours $formatted_dentist_start - $formatted_dentist_end', () => window.location.href = 'select-dentist.php?user_id_dentist=$user_id_dentist&user_id_patient=$user_id_patient') </script>";
    exit;
  }

  $checkPending = checkPendingAppointment($conn, $user_id_patient);
  if ($checkPending) {
    echo "<script> error('You still have a pending schedule!', () => window.location.href = 'select-dentist.php?user_id_dentist=$user_id_dentist&user_id_patient=$user_id_patient') </script>";
    exit;
  }
  $run_appointment_time = checkAppointment($conn, $appointment_date, $appointment_time, $user_id_dentist);
  if(mysqli_num_rows($run_appointment_time) > 0){
    echo "<script> error('Appointment time already booked!', () => window.location.href = 'select-dentist.php?user_id_dentist=$user_id_dentist&user_id_patient=$user_id_patient') </script>";
    exit;
  }else{
      $run_check_appointment = checkAppointmentByUser($conn, $appointment_date, $appointment_time, $user_id_patient);
      if(mysqli_num_rows($run_check_appointment) > 0){
        echo "<script> error('Patient already have an Appointment.', () => window.location.href = 'appointments.php') </script>";
      }else{
        $run_appointment = createAppointment($conn, $user_id_dentist, $user_id_patient, $appointment_id, $concern, $appointment_time, $appointment_date);
        if($run_appointment) {
          createNotification($conn, $user_id_dentist, "New Appointment Schedule", "Appointment", $user_id_patient);
          createNotification($conn, $user_id_patient, "New Appointment Schedule", "Appointment", $user_id_patient);
          
          $sendMail = sendEmail($mail, $subject, $email);
          if($sendMail) {
            echo "<script> success('Appointment added successfully.', () => window.location.href = 'appointments.php') </script>";
          }
        }else{
          echo "<script> error('Something went wrong!', () => window.location.href = 'appointments.php') </script>";
        }
      }
  }
}


?>