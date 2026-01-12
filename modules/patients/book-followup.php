<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Appointments/appointments.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/notification.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/scripts.php');

date_default_timezone_set('Asia/Manila');

if (isset($_POST['book_followup'])) {
    $parent_appointment_id = $_POST['parent_appointment_id'];
    $concern = $_POST['concern'];
    $dentist_id = $_POST['dentist_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $patient_id = $_SESSION['user_id'];
    
    // Generate new appointment ID
    $new_appointment_id = rand(20250000, 20259999);
    $date_created = date('Y-m-d');
    
    // Format date for storage (system uses MM/DD/YYYY format)
    $formatted_date = date('m/d/Y', strtotime($appointment_date));
    
    // Insert new follow-up appointment with parent_appointment_id
    $sql = "INSERT INTO appointments (
        user_id, 
        user_id_patient, 
        appointment_id, 
        concern, 
        confirmed, 
        appointment_time, 
        appointment_end, 
        appointment_date, 
        date_created, 
        date_updated, 
        walk_in,
        parent_appointment_id
    ) VALUES (?, ?, ?, ?, 0, ?, '', ?, ?, ?, 0, ?)";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iiississi", 
        $dentist_id, 
        $patient_id, 
        $new_appointment_id, 
        $concern, 
        $appointment_time, 
        $formatted_date, 
        $date_created, 
        $date_created,
        $parent_appointment_id
    );
    
    if (mysqli_stmt_execute($stmt)) {
        // Create notification for dentist
        $trans_id = uniqid();
        $message = "Follow-up Appointment Scheduled";
        $type = "Appointment";
        $dateTime = date('Y-m-d H:i:s');
        createNotification($conn, $dentist_id, $trans_id, $message, $type, $patient_id);
        
        echo "<script>
            success('Follow-up appointment booked successfully!', () => {
                window.location.href = 'history.php';
            });
        </script>";
    } else {
        echo "<script>
            error('Failed to book follow-up appointment. Please try again.', () => {
                window.history.back();
            });
        </script>";
    }
} else {
    header('Location: history.php');
    exit;
}
?>
