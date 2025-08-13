<?php

function createNewUser() {
}

function getProfile($conn, $user_id, $role) {
  $sql = "SELECT * FROM users WHERE user_id = ? AND role_id = ?";

  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "ii", $user_id, $role);
  mysqli_stmt_execute($stmt);

  return mysqli_stmt_get_result($stmt);
}

function updateProfile($conn,$first_name, $middle_name, $last_name, $mobile_number, $email, $date_of_birth, $date, $user_id) {
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
  mysqli_stmt_bind_param($stmt, "sssssssi", $first_name, $middle_name, $last_name, $mobile_number, $email, $date_of_birth, $date, $user_id);
  
  return mysqli_stmt_execute($stmt);
}

function checkUser($conn, $email, $first_name, $middle_name, $last_name, $date_of_birth){
  $sql = "SELECT * 
    FROM users 
    WHERE email = ? 
    AND first_name = ? 
    AND middle_name = ? 
    AND last_name = ? 
    AND date_of_birth = ?";

  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "sssss", $email, $first_name, $middle_name, $last_name, $date_of_birth);
  mysqli_stmt_execute($stmt);

  return mysqli_stmt_get_result($stmt); 
}


