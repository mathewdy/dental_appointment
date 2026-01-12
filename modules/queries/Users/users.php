<?php
date_default_timezone_set('Asia/Manila');

function createUser($conn, $user_id, $role, $first_name, $middle_name, $last_name, $mobile_number, $email, $password, $date_of_birth, $address) {
  $now = date("Y-m-d H:i:s");
  $sql = "INSERT INTO users (user_id,
      role_id,
      first_name,
      middle_name,
      last_name,
      mobile_number,
      email,
      password,
      date_of_birth,
      date_created, 
      address) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "iisssssssss", $user_id, $role, $first_name, $middle_name, $last_name, $mobile_number, $email, $password, $date_of_birth, $now, $address);

  return mysqli_stmt_execute($stmt);
}

function getProfile($conn, $user_id, $role) {
  $sql = "SELECT * FROM users WHERE user_id = ? AND role_id = ?";

  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "ii", $user_id, $role);
  mysqli_stmt_execute($stmt);

  return mysqli_stmt_get_result($stmt);
}

function updateProfile($conn, $first_name, $middle_name, $last_name, $mobile_number, $email, $date_of_birth, $user_id) {
  $now = date("Y-m-d H:i:s");
  $sql = "UPDATE users 
    SET first_name = ?, 
      middle_name = ?,
      last_name = ?,
      mobile_number = ?, 
      email = ?, 
      date_of_birth =  ?, 
      date_updated = ?
    WHERE user_id = ?";

  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "sssssssi", $first_name, $middle_name, $last_name, $mobile_number, $email, $date_of_birth, $now, $user_id);
  
  return mysqli_stmt_execute($stmt);
}

function checkAllUserByEmail($conn, $email){
  $sql = "SELECT * 
    FROM users
    WHERE email = ?
    ";

  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "s", $email);
  mysqli_stmt_execute($stmt);

  return mysqli_stmt_get_result($stmt); 
}

function checkUser($conn, $email, $first_name, $middle_name, $last_name, $date_of_birth) {
  $sql = "SELECT * 
    FROM users 
    WHERE email = ? 
    AND first_name = ? 
    AND middle_name = ? 
    AND last_name = ?";

  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "ssss", $email, $first_name, $middle_name, $last_name);
  mysqli_stmt_execute($stmt);

  return mysqli_stmt_get_result($stmt); 
}

function updateOtp($conn, $otp, $email) {
  $sql = "UPDATE users SET otp = ? WHERE email = ?";

  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "ss", $otp, $email);
  
  return mysqli_stmt_execute($stmt);
}

function deleteUser($conn, $id) {
  $sql = "DELETE FROM users WHERE user_id = ?";

  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "i", $id);

  return mysqli_stmt_execute($stmt);
}

