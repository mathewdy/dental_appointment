<?php
date_default_timezone_set('Asia/Manila');

function createAppointment($conn, $dentist, $patient, $appointment, $concern, $time, $date, $val)
{
    $now = date("Y-m-d H:i:s");

    $sql = "INSERT INTO appointments (
      user_id,
      user_id_patient,
      appointment_id,
      concern,
      confirmed,
      appointment_time,
      appointment_date,
      date_created,
      walk_in
    ) VALUES (?, ?, ?, ?, 0, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iisssssi", $dentist, $patient, $appointment, $concern, $time, $date, $now, $val);
    return mysqli_stmt_execute($stmt);
}

function checkAppointment($conn, $date, $time, $id)
{
    $sql = "SELECT appointment_time, appointment_date, user_id 
    FROM appointments 
    WHERE appointment_date = ?
    AND appointment_time = ? 
    AND user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssi", $date, $time, $id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}

function checkPendingAppointment($conn, $id)
{
    $sql = "SELECT appointment_date, appointment_time, user_id_patient, confirmed
    FROM appointments 
    WHERE user_id_patient = ?
    AND confirmed = 0";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}
function hasAppointmentToday($conn, $id, $appointment_date)
{
    $sql = "SELECT confirmed 
            FROM appointments 
            WHERE user_id_patient = ?
              AND appointment_date = ?
              AND confirmed IN (0, 1, 2)
            LIMIT 1";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "is", $id, $appointment_date);
    mysqli_stmt_execute($stmt);

    return mysqli_stmt_get_result($stmt);
}

function hasOverlappingAppointment($conn, $dentist_id, $appointment_date, $appointment_start, $appointment_end)
{
    $sql = "SELECT *
    FROM appointments
    WHERE user_id = ?
      AND appointment_date COLLATE utf8mb4_general_ci = ?
      AND confirmed IN (0,1)
      AND (
        (appointment_time COLLATE utf8mb4_general_ci < ? 
         AND ADDTIME(appointment_time, '00:59:00') COLLATE utf8mb4_general_ci > ?)
      )
    LIMIT 1";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "isss", $dentist_id, $appointment_date, $appointment_end, $appointment_start);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}


function checkAppointmentByUser($conn, $date, $start, $id)
{
    $sql = "SELECT appointment_date, appointment_time, user_id_patient, confirmed
    FROM appointments 
    WHERE appointment_date = ?
    AND appointment_time = ?
    AND user_id_patient = ?
    AND confirmed = 0";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssi", $date, $start, $id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}

function getAllRequests($conn)
{
    $sql = "SELECT 
    appointments.appointment_id,
    appointments.user_id AS doctor_id,
    appointments.user_id_patient AS patient_id,
    appointments.parent_appointment_id,
    appointments.concern,
    appointments.appointment_date,
    appointments.appointment_time,
    appointments.confirmed,
    patient.first_name AS patient_first_name,
    patient.middle_name AS patient_middle_name,
    patient.last_name AS patient_last_name,
    doctor.first_name AS doctor_first_name,
    doctor.middle_name AS doctor_middle_name,
    doctor.last_name AS doctor_last_name
FROM appointments
LEFT JOIN users AS patient ON appointments.user_id_patient = patient.user_id
LEFT JOIN users AS doctor ON appointments.user_id = doctor.user_id
ORDER BY appointments.confirmed ASC, appointments.appointment_id DESC;
";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}


function getAllRequestsById($conn, $id)
{
    $sql = "SELECT 
    appointments.appointment_id,
    appointments.user_id AS doctor_id,
    appointments.user_id_patient AS patient_id,
    appointments.parent_appointment_id,
    appointments.concern,
    appointments.appointment_date,
    appointments.appointment_time,
    appointments.confirmed,
    appointments.remarks,
    patient.first_name AS patient_first_name,
    patient.middle_name AS patient_middle_name,
    patient.last_name AS patient_last_name,
    doctor.first_name AS doctor_first_name,
    doctor.middle_name AS doctor_middle_name,
    doctor.last_name AS doctor_last_name
  FROM appointments
  LEFT JOIN users AS patient ON appointments.user_id_patient = patient.user_id
  LEFT JOIN users AS doctor ON appointments.user_id = doctor.user_id
  WHERE appointments.user_id_patient = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}

function getAllRequestHistoryById($conn, $id)
{
    $sql = "SELECT 
    appointments.appointment_id,
    appointments.user_id AS doctor_id,
    appointments.user_id_patient AS patient_id,
    appointments.parent_appointment_id,
    appointments.concern,
    appointments.appointment_date,
    appointments.appointment_time,
    appointments.confirmed,
    appointments.remarks,
    patient.first_name AS patient_first_name,
    patient.middle_name AS patient_middle_name,
    patient.last_name AS patient_last_name,
    doctor.first_name AS doctor_first_name,
    doctor.middle_name AS doctor_middle_name,
    doctor.last_name AS doctor_last_name
  FROM appointments
  LEFT JOIN users AS patient ON appointments.user_id_patient = patient.user_id
  LEFT JOIN users AS doctor ON appointments.user_id = doctor.user_id
  WHERE appointments.user_id_patient = ? AND confirmed IN (1,2)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}

function getAppointments($conn, $id, $confirmed)
{
    $sql = "SELECT
      appointments.user_id_patient,
      appointments.appointment_id AS id,
      appointments.concern,
      appointments.date_created,
      appointments.confirmed,
      payments.payment_id,
      payments.appointment_id,
      payments.initial_balance, 
      payments.remaining_balance, 
      payments.is_deducted
    FROM appointments 
    LEFT JOIN payments ON appointments.appointment_id = payments.appointment_id
    WHERE user_id_patient = ? AND confirmed = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $id, $confirmed);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}

function updateStatus($conn, $id, $status)
{
    $now = date("Y-m-d H:i:s");
    $sql = "UPDATE appointments 
  SET confirmed = ?, date_updated = ?
  WHERE appointment_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssi", $status, $now, $id);
    return mysqli_stmt_execute($stmt);
}

function getUpcomingConfirmedAppointments($conn, $patient_id)
{
    $today = date('m/d/Y');
    // Select all future appointments
    // Show Pending (NULL/default) and Confirmed (0). Exclude Completed(1), Cancelled(2), No-Show(3)
    // Uses STR_TO_DATE to correctly compare MM/DD/YYYY strings
    $sql = "SELECT 
              app.appointment_id,
              app.parent_appointment_id,
              app.appointment_date, 
              app.appointment_time, 
              app.concern,
              u.first_name as doctor_first,
              u.last_name as doctor_last
            FROM appointments app
            JOIN users u ON app.user_id = u.user_id
            WHERE app.user_id_patient = ? 
            AND (app.confirmed IS NULL OR app.confirmed = 0)
            AND STR_TO_DATE(app.appointment_date, '%m/%d/%Y') >= STR_TO_DATE(?, '%m/%d/%Y')
            ORDER BY STR_TO_DATE(app.appointment_date, '%m/%d/%Y') ASC, app.appointment_time ASC";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "is", $patient_id, $today);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}

function getAllPatientAppointments($conn, $id)
{
    $sql = "SELECT appointment_id, parent_appointment_id, appointment_date, appointment_time, confirmed, concern 
            FROM appointments 
            WHERE user_id_patient = ? 
            ORDER BY appointment_date DESC, appointment_time DESC";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}

function checkExistingFollowUp($conn, $parent_id)
{
    // Check for any ACTIVE (Confirmed = 0) follow-up linked to this parent.
    // We allows booking new follow-ups if previous ones are Completed (1), Cancelled (2), or No Show (3).
    
    $sql = "SELECT appointment_id FROM appointments 
            WHERE parent_appointment_id = ? 
            AND confirmed = 0";
            
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $parent_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_num_rows($result) > 0;
}
