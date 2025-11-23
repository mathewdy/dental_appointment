<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/notification.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/Appointments/appointments.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/Users/dentists.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/Mailer/mail.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/scripts.php'); 

$id = $_SESSION['user_id'];

if(isset($_POST['save'])){
  $user_id_dentist = intval($_POST['dentist']);
  $user_id_patient = intval($_POST['patient']);
  $appointment_id = "2025".rand('1','10') . substr(str_shuffle(str_repeat("0123456789", 5)), 0, 3);
  $concern = trim($_POST['concern']);
  $appointment_time = $_POST['appointment_time'];
  $appointment_date = $_POST['appointment_date'];
  $current_date = date('Y-m-d');
  $email = trim($_POST['email']);
  $trans_id = uniqid();
  $subject = "Appointment Schedule";

  $mail = "
      <p>Dear Customer,</p>
      <p>We are happy to confirm that your appointment has been successfully scheduled.</p>
      <p><strong>Appointment Details:</strong></p>
      <strong>Appointment Date:</strong> $appointment_date<br>
      <strong>Appointment Time:</strong> $appointment_time<br>
      <p>If you need to reschedule or make any changes, please contact us.</p>
      <p>Thank you for choosing our clinic!</p>
      <p>Best Regards,<br>Fojas Dental Clinic</p>
  ";
  if(strtotime($appointment_date) < strtotime($current_date)){
    echo "<script>error('You are trying to book in the previous dates.', () => window.location.href='set-schedule.php?user_id_dentist=$user_id_dentist&user_id_patient=$user_id_patient');</script>";
    exit;
  }

  $get_dentist = getDentistById($conn, '3', $user_id_dentist);
  if(mysqli_num_rows($get_dentist) === 0){
    echo "<script>error('Selected dentist does not exist!', () => window.location.href='appointments.php');</script>";
    exit;
  }

  $run_dentist = mysqli_fetch_assoc($get_dentist);
  $dentist_start = $run_dentist['start_time'];
  $dentist_end = $run_dentist['end_time'];
  $formatted_dentist_start = date("h:i A", strtotime($run_dentist['start_time']));
  $formatted_dentist_end = date("h:i A", strtotime($run_dentist['end_time']));

  $appointment_start = date("H:i:s", strtotime($appointment_time));
  $appointment_end = date("H:i:s", strtotime("+1 hour", strtotime($appointment_time)));
  $dentist_start_ts = date("H:i:s", strtotime($dentist_start));
  $dentist_end_ts = date("H:i:s", strtotime($dentist_end));

  if($appointment_start < $dentist_start || $appointment_end > $dentist_end){
      echo "<script>error('Appointment time is outside of dentist working hours $formatted_dentist_start - $formatted_dentist_end', () => window.location.href='set-schedule.php?user_id_dentist=$user_id_dentist&user_id_patient=$user_id_patient');</script>";
      exit;
  }

  $overlap = hasOverlappingAppointment($conn, $user_id_dentist, $appointment_date, $appointment_start, $appointment_end);
  if(mysqli_num_rows($overlap) > 0){
      echo "<script>
          error('This time slot is already taken. Please choose another one.', 
          () => window.location.href='set-schedule.php?user_id_dentist=$user_id_dentist&user_id_patient=$user_id_patient');
      </script>";
      exit;
  }

  $checkPending = checkPendingAppointment($conn, $user_id_patient);
  if(mysqli_num_rows($checkPending) > 0){
      echo "<script>
          error('This patient has a pending appointment!', 
          () => window.location.href='set-schedule.php?user_id_dentist=$user_id_dentist&user_id_patient=$user_id_patient');
      </script>";
      exit;
  }

  $checkAppointmentToday = hasAppointmentToday($conn, $user_id_patient, $appointment_date);
  if(mysqli_num_rows($checkAppointmentToday) > 0){
      echo "<script>
          error('This patient has an appointment at that day.', 
          () => window.location.href='set-schedule.php?user_id_dentist=$user_id_dentist&user_id_patient=$user_id_patient');
      </script>";
      exit;
  }

  $checkPatient = checkAppointmentByUser($conn, $appointment_date, $appointment_start, $user_id_patient);
  if(mysqli_num_rows($checkPatient) > 0){
      echo "<script>
          error('Patient already has an appointment at this time.', 
          () => window.location.href='set-schedule.php?user_id_dentist=$user_id_dentist&user_id_patient=$user_id_patient');
      </script>";
      exit;
  }

  mysqli_begin_transaction($conn);

  try {
    $sendMail = sendEmail($mail, $subject, $email);
    if(!$sendMail) {
      echo "<script>error('Failed to send email.', () => window.location.href='set-schedule.php?user_id_dentist=$user_id_dentist&user_id_patient=$user_id_patient');</script>";
    } else {
      $create = createAppointment($conn, $user_id_dentist, $user_id_patient, $appointment_id, $concern, $appointment_start, $appointment_date);
      if(!$create) throw new Exception("Failed to create appointment");
      createNotification($conn, $user_id_dentist, $trans_id, "New Appointment Schedule", "Appointment", $user_id_patient);
      createNotification($conn, $user_id_patient, $trans_id, "New Appointment Schedule", "Appointment", $user_id_patient);
      mysqli_commit($conn);
      echo "<script>success('Appointment scheduled successfully.', () => window.location.href='appointments.php');</script>";
    }
  } catch(Exception $e){
      mysqli_rollback($conn);
      echo "<script>
          error('".$e->getMessage()."', 
          () => window.location.href='set-schedule.php?user_id_dentist=$user_id_dentist&user_id_patient=$user_id_patient');
      </script>";
      
  }
}
?>
