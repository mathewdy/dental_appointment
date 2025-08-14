<?php

function createUser($conn, $user_id, $role, $first_name, $middle_name, $last_name, $mobile_number, $email, $password, $date_of_birth) {
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
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "iisssssss", $user_id, $role, $first_name, $middle_name, $last_name, $mobile_number, $email, $password, $date_of_birth);

  return mysqli_stmt_execute($stmt);
}

//
// work in progress 
//
// function updateUser($conn, $role, $first_name, $middle_name, $last_name, $mobile_number, $email, $date_of_birth, $user_id) {
//   $sql = "UPDATE users 
//   SET first_name = ?, 
//     middle_name = ?, 
//     last_name = ?, 
//     mobile_number = ?, 
//     email = ?,
//     date_updated = NOW() 
//   WHERE user_id = ?";

//   $stmt = mysqli_prepare($conn, $sql);
//   mysqli_stmt_bind_param($stmt, "iisssssss", $user_id, $role, $first_name, $middle_name, $last_name, $mobile_number, $email, $date_of_birth, $user_id);

//   return mysqli_stmt_execute($stmt);
// }

function getProfile($conn, $user_id, $role) {
  $sql = "SELECT * FROM users WHERE user_id = ? AND role_id = ?";

  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "ii", $user_id, $role);
  mysqli_stmt_execute($stmt);

  return mysqli_stmt_get_result($stmt);
}

function updateProfile($conn,$first_name, $middle_name, $last_name, $mobile_number, $email, $date_of_birth, $user_id) {
  $sql = "UPDATE users 
    SET first_name = ?, 
      middle_name = ?,
      last_name = ?,
      mobile_number = ?, 
      email = ?, 
      date_of_birth =  ?, 
      date_updated = NOW()
    WHERE user_id = ?";

  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "sssssssi", $first_name, $middle_name, $last_name, $mobile_number, $email, $date_of_birth, $user_id);
  
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

function deleteUser($conn, $id) {
  $sql = "DELETE FROM users WHERE user_id = ?";

  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "i", $id);

  return mysqli_stmt_execute($stmt);
}

