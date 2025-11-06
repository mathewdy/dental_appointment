<?php
function createAppointment($conn, $dentist, $patient, $appointment, $concern, $time, $date) {
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
    ) VALUES (?, ?, ?, ?, 0, ?, ?, NOW(), 1)";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "iissss", $dentist, $patient, $appointment, $concern, $time, $date);
  return mysqli_stmt_execute($stmt);
}

function checkAppointment($conn, $date, $time, $id) {
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

function checkPendingAppointment($conn, $id) {
  $sql = "SELECT appointment_date, appointment_time, user_id_patient, confirmed
    FROM appointments 
    WHERE user_id_patient = ?
    AND confirmed = 0";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "i", $id);
  mysqli_stmt_execute($stmt);
  return mysqli_stmt_get_result($stmt);
}

function hasOverlappingAppointment($conn, $dentist_id, $appointment_date, $appointment_start, $appointment_end) {
  $sql = "SELECT *
    FROM appointments
    WHERE user_id = ?
      AND appointment_date = ?
      AND confirmed IN (0,1)
      AND (
        (appointment_time < ? AND ADDTIME(appointment_time, '01:00:00') > ?)
      )
    LIMIT 1";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "isss", $dentist_id, $appointment_date, $appointment_end, $appointment_start);
  mysqli_stmt_execute($stmt);
  return mysqli_stmt_get_result($stmt);
}

function checkAppointmentByUser($conn, $date, $start, $id) {
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

function getAllRequests($conn) {
  $sql = "SELECT 
    appointments.appointment_id,
    appointments.user_id AS doctor_id,
    appointments.user_id_patient AS patient_id,
    appointments.concern,
    appointments.appointment_date,
    appointments.appointment_time,
    appointments.confirmed,
    patient.first_name AS patient_first_name,
    patient.middle_name AS patient_middle_name,
    patient.last_name AS patient_last_name,
    doctor.first_name AS doctor_first_name,
    doctor.middle_name AS doctor_middle_name,
    doctor.last_name AS doctor_last_name,
    schedule.start_time,
    schedule.end_time
  FROM appointments
  LEFT JOIN users AS patient ON appointments.user_id_patient = patient.user_id
  LEFT JOIN users AS doctor ON appointments.user_id = doctor.user_id
  LEFT JOIN schedule ON appointments.user_id = schedule.user_id";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_execute($stmt);
  return mysqli_stmt_get_result($stmt);
}

function getAllRequestsById($conn, $id) {
  $sql = "SELECT 
    appointments.appointment_id,
    appointments.user_id AS doctor_id,
    appointments.user_id_patient AS patient_id,
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
    doctor.last_name AS doctor_last_name,
    schedule.start_time,
    schedule.end_time
  FROM appointments
  LEFT JOIN users AS patient ON appointments.user_id_patient = patient.user_id
  LEFT JOIN users AS doctor ON appointments.user_id = doctor.user_id
  LEFT JOIN schedule ON appointments.user_id = schedule.user_id
  WHERE appointments.user_id_patient = ?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "i", $id);
  mysqli_stmt_execute($stmt);
  return mysqli_stmt_get_result($stmt);
}

function getAppointments($conn, $id, $confirmed) {
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

function updateStatus($conn, $id, $status) {
  $sql = "UPDATE appointments 
  SET confirmed = ?, date_updated = NOW()
  WHERE appointment_id = ?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "si", $status, $id);
  return mysqli_stmt_execute($stmt);
}
