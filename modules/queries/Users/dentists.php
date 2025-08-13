<?php 

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

function createDentistSchedule($conn, $user_id, $days, $start, $end, $date) {
  $sql = "INSERT INTO schedule (user_id,
    day,
    start_time,
    end_time,
    date_created)
    VALUES (?, ?, ?, ?, ?)";

  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "issss", $user_id, $days, $start, $end, $date);

  return mysqli_stmt_execute($stmt);

}

function getAllDentist($conn, $role) {
  $sql = "SELECT 
      users.user_id AS user_id, 
      users.first_name AS first_name, 
      users.middle_name AS middle_name, 
      users.last_name AS last_name, 
      users.mobile_number AS mobile_number, 
      users.email AS email, 
      schedule.user_id AS schedule_user_id,
      schedule.day AS day, 
      schedule.start_time AS start_time, 
      schedule.end_time AS end_time
    FROM users 
    LEFT JOIN schedule 
    ON users.user_id = schedule.user_id 
    WHERE users.role_id = ?";

  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "i", $role);
  mysqli_stmt_execute($stmt);

  return mysqli_stmt_get_result($stmt);
}
