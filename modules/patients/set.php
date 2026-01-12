<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/notification.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Appointments/appointments.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Users/dentists.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Mailer/mail.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/scripts.php');

$user_id_patient = $_SESSION['user_id'];
$role = $_SESSION['role_id'];
$email = $_SESSION['email'];
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (isset($_POST['save'])) {
    $user_id_dentist = intval($_POST['dentist']);
    $appointment_id = "2025" . rand('1', '10') . substr(str_shuffle(str_repeat("0123456789", 5)), 0, 3);
    $concerns = isset($_POST['concerns']) ? $_POST['concerns'] : [];
    $other_concern = isset($_POST['other_concern']) ? trim($_POST['other_concern']) : '';
    if (!empty($other_concern)) {
        $concerns[] = $other_concern;
    }
    $concern = implode(", ", $concerns);

    $appointment_time = $_POST['appointment_time'];
    $appointment_date = $_POST['appointment_date'];

    $current_date = date('Y-m-d');
    $trans_id = uniqid();
    $currentTime = strtotime("now");
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

    $appointment_datetime = strtotime($appointment_date . ' ' . $appointment_time);

    if ($appointment_datetime < $currentTime) {
        echo "<script>error('You are trying to book in the past. Please choose a different time.', () => window.location.href='select-dentist.php?user_id_dentist=$user_id_dentist&user_id_patient=$user_id_patient');</script>";
        exit;
    }

    if (strtotime($appointment_date) < strtotime($current_date)) {
        echo "<script>error('You are trying to book in the past dates. Please choose a different date.', () => window.location.href='select-dentist.php?user_id_dentist=$user_id_dentist&user_id_patient=$user_id_patient');</script>";
        exit;
    }

    // Fetch Schedule from dentist_schedules table
    $dayOfWeek = date('l', strtotime($appointment_date));
    $sql_sched = "SELECT start_time, end_time FROM dentist_schedules WHERE user_id = ? AND day_of_week = ? AND is_active = 1 LIMIT 1";
    $stmt_sched = mysqli_prepare($conn, $sql_sched);
    mysqli_stmt_bind_param($stmt_sched, "is", $user_id_dentist, $dayOfWeek);
    mysqli_stmt_execute($stmt_sched);
    $res_sched = mysqli_stmt_get_result($stmt_sched);
    $sched_data = mysqli_fetch_assoc($res_sched);

    if (!$sched_data) {
        // If no schedule found for that day effectively, block it
        echo "<script>error('Dentist is not available on $dayOfWeek.', () => window.location.href='select-dentist.php?user_id_dentist=$user_id_dentist&user_id_patient=$user_id_patient');</script>";
        exit;
    }

    $dentist_start_time = $sched_data['start_time'];
    $dentist_end_time = $sched_data['end_time'];

    $formatted_dentist_start = date("h:i A", strtotime($dentist_start_time));
    $formatted_dentist_end = date("h:i A", strtotime($dentist_end_time));

    $appointment_start = date("H:i", strtotime($appointment_time));
    $appointment_end = date("H:i", strtotime("+1 hour", strtotime($appointment_time)));

    $dentist_start_ts = strtotime($appointment_date . ' ' . $dentist_start_time);
    $dentist_end_ts = strtotime($appointment_date . ' ' . $dentist_end_time);

    $appointment_start_ts = strtotime($appointment_date . ' ' . $appointment_time);
    $appointment_end_ts = strtotime("+1 hour", $appointment_start_ts);

    // Check overlap with working hours
    // Strictly: Start >= DentistStart AND End <= DentistEnd
    if ($appointment_start_ts < $dentist_start_ts || $appointment_end_ts > $dentist_end_ts) {
        echo "<script>
            error(
                'Appointment time is outside of dentist working hours ($formatted_dentist_start - $formatted_dentist_end)',
                () => window.location.href='select-dentist.php?user_id_dentist=$user_id_dentist&user_id_patient=$user_id_patient'
            );
        </script>";
        exit;
    }

    $checkPending = checkPendingAppointment($conn, $user_id_patient);
    if (mysqli_num_rows($checkPending) > 0) {
        echo "<script>error('You still have a pending appointment!', () => window.location.href='select-dentist.php?user_id_dentist=$user_id_dentist&user_id_patient=$user_id_patient');</script>";
        exit;
    }

    $hasAppointment = hasAppointmentToday($conn, $user_id_patient, $appointment_date);

    if ($row = mysqli_fetch_assoc($hasAppointment)) {

        $status = (int) $row['confirmed'];
        switch ($status) {
            case 0:
                $statusText = 'pending';
                break;
            case 1:
                $statusText = 'completed';
                break;
            case 2:
                $statusText = 'cancelled';
                break;
        }

        echo "<script>
            error('You already {$statusText} appointment on this day. Please choose another date.',
            () => window.location.href='select-dentist.php?user_id_dentist=$user_id_dentist&user_id_patient=$user_id_patient');
        </script>";
        exit;
    }

    $overlap = hasOverlappingAppointment($conn, $user_id_dentist, $appointment_date, $appointment_start, $appointment_end);
    if (mysqli_num_rows($overlap) > 0) {
        echo "<script>error('This time slot is already taken. Please choose another one.', () => window.location.href='select-dentist.php?user_id_dentist=$user_id_dentist&user_id_patient=$user_id_patient');</script>";
        exit;
    }

    $checkPatient = checkAppointmentByUser($conn, $appointment_date, $appointment_start, $user_id_patient);
    if (mysqli_num_rows($checkPatient) > 0) {
        echo "<script>error('You already have an appointment at this time. Please choose a different time.', () => window.location.href='select-dentist.php?user_id_dentist=$user_id_dentist&user_id_patient=$user_id_patient');</script>";
        exit;
    }

    try {
        $sendMail = sendEmail($mail, $subject, $email);
        if (!$sendMail) {
            echo "<script>error('You already have an appointment at this time.', () => window.location.href='select-dentist.php?user_id_dentist=$user_id_dentist&user_id_patient=$user_id_patient');</script>";
        } else {
            $create = createAppointment($conn, $user_id_dentist, $user_id_patient, $appointment_id, $concern, $appointment_start, $appointment_date, 0);
            if (!$create)
                throw new Exception("Failed to create appointment");
            createNotification($conn, $user_id_dentist, $trans_id, "New Appointment Schedule", "Appointment", $user_id_patient);
            createNotification($conn, $user_id_patient, $trans_id, "New Appointment Schedule", "Appointment", $user_id_patient);
            mysqli_commit($conn);
            echo "<script>success('Appointment scheduled successfully.', () => window.location.href='appointments.php');</script>";
        }
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "<script>error('Something went wrong!', () => window.location.href='select-dentist.php?user_id_dentist=$user_id_dentist&user_id_patient=$user_id_patient');</script>";
    }
}
?>