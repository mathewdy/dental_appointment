<?php

function queryEventBuilder($role, $id)
{
    $eventClause = getClause($role, $id);
    $sql = "SELECT appointments.user_id, appointments.user_id_patient, appointments.concern, appointments.appointment_date, appointments.appointment_time,
  users.first_name, users.middle_name, users.last_name, appointments.confirmed
  FROM appointments
  LEFT JOIN users
  ON appointments.user_id = users.user_id " . $eventClause;

    return $sql;
}

function queryEventInfoBuilder($role, $id, $formattedClickedDate)
{
    $formattedClickedDate = "'" . $formattedClickedDate . "'";
    $eventInfoClause = getInfoClause($role, $id);
    $sql = "SELECT appointments.user_id AS dentist_id, 
    appointments.user_id_patient AS patient_id,
    appointments.concern, 
    appointments.appointment_date, 
    appointments.appointment_time,
    dentist.first_name AS dentist_first_name,
    dentist.last_name AS dentist_last_name,
    patient.first_name AS patient_first_name,
    patient.middle_name AS patient_middle_name,
    patient.last_name AS patient_last_name,
    appointments.confirmed
  FROM appointments
  LEFT JOIN users AS dentist
  ON appointments.user_id = dentist.user_id
  LEFT JOIN users AS patient
  ON appointments.user_id_patient = patient.user_id
  WHERE appointments.appointment_date = $formattedClickedDate " . $eventInfoClause

    ;

    return $sql;
}
?>