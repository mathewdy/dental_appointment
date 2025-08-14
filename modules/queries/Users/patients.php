<?php
function getAllPatients($conn, $role) {
  $sql = "SELECT users.user_id, 
      users.first_name,
      users.middle_name,
      users.last_name,
      users.mobile_number,
      users.email,
      users.password,
      users.date_of_birth,
      users.address, 
      appointments.appointment_id,
      appointments.concern,
      appointments.confirmed,
      appointments.appointment_date,
      appointments.remarks
    FROM users
    LEFT JOIN appointments
    ON users.user_id = appointments.user_id 
    WHERE users.role_id = ?";

  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "i", $role);
  mysqli_stmt_execute($stmt);
  
  return mysqli_stmt_get_result($stmt);
}

function getPatientById($conn, $id) {
  $sql = "SELECT users.user_id, 
      users.first_name,
      users.middle_name,
      users.last_name,
      users.mobile_number,
      users.email,
      users.password,
      users.date_of_birth,
      users.address, 
      appointments.appointment_id,
      appointments.concern,
      appointments.confirmed,
      appointments.appointment_date,
      appointments.remarks
    FROM users
    LEFT JOIN appointments
    ON users.user_id = appointments.user_id 
    WHERE users.user_id = ?";

  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "i", $id);
  mysqli_stmt_execute($stmt);
  
  return mysqli_stmt_get_result($stmt); 
}

function updatePatient($conn, $first_name, $middle_name, $last_name, $mobile_number, $email, $date_of_birth, $address, $user_id) {
  $sql = "UPDATE users 
    SET first_name = ?, 
      middle_name = ?, 
      last_name = ?, 
      mobile_number = ?, 
      email = ?,
      `address` = ?, 
      date_of_birth = ?,
      date_updated = NOW() 
    WHERE user_id = ?";

  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "sssssssi", $first_name, $middle_name, $last_name, $mobile_number, $email, $date_of_birth, $address, $user_id);

  return mysqli_stmt_execute($stmt);
}
