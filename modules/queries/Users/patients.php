<?php

function getAllPatients($conn, $role) {
  $sql = "SELECT users.user_id, users.first_name,users.middle_name,users.last_name,users.mobile_number,users.email,users.password,users.date_of_birth,users.address, appointments.appointment_id,appointments.concern,appointments.confirmed,appointments.appointment_date,appointments.remarks
    FROM users
    LEFT JOIN appointments
    ON users.user_id = appointments.user_id WHERE users.role_id = ?";

  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "i", $role);
  mysqli_stmt_execute($stmt);
  
  return mysqli_stmt_get_result($stmt);
}


function createDentist($conn, $user_id, $role, $first_name, $middle_name, $last_name, $mobile_number, $email, $password, $date_of_birth, $date) {
  $sql = "INSERT INTO users (user_id,
    role_id,
    first_name,
    middle_name,
    last_name,
    mobile_number,
    email,
    password,
    date_of_birth,
    date_created) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "iissssssss", $user_id, $role, $first_name, $middle_name, $last_name, $mobile_number, $email, $password, $date_of_birth, $date);

  return mysqli_stmt_execute($stmt);
}