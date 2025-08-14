<?php 
function createDentistSchedule($conn, $user_id, $days, $start, $end) {
  $sql = "INSERT INTO schedule (user_id,
    day,
    start_time,
    end_time,
    date_created)
    VALUES (?, ?, ?, ?, NOW())";

  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "isss", $user_id, $days, $start, $end);

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

function getDentistById($conn, $role, $id) {
  $sql = "SELECT users.user_id AS user_id, 
    users.first_name AS first_name, 
    users.middle_name AS middle_name, 
    users.last_name AS last_name, 
    users.mobile_number AS mobile_number, 
    users.email AS email, 
    schedule.user_id AS schedule_user_id, 
    schedule.day AS day, 
    schedule.start_time AS start_time, 
    schedule.end_time AS end_time
  FROM
  users 
  LEFT JOIN schedule 
  ON users.user_id = schedule.user_id 
  WHERE users.role_id = ? AND users.user_id = ?";

  $stmt = mysqli_prepare($conn, $sql); 
  mysqli_stmt_bind_param($stmt, "ii", $role, $id);
  mysqli_stmt_execute($stmt);

  return mysqli_stmt_get_result($stmt);
}

function updateDentist($conn, $first_name, $middle_name, $last_name, $user_id) {
  $sql = "UPDATE users 
  SET first_name = ?, 
    middle_name = ?, 
    last_name = ?, 
    date_updated = NOW() 
  WHERE user_id = ?";

  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "sssi", $first_name, $middle_name, $last_name, $user_id);

  return mysqli_stmt_execute($stmt);
}

function updateDentistSchedule($conn, $days, $start, $end, $user_id) {
  $sql = "UPDATE schedule 
    SET day = ?, 
    start_time = ?, 
    end_time =  ?,
    date_updated = NOW()
    WHERE user_id = ?";

  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "sssi", $days, $start, $end, $user_id);

  return mysqli_stmt_execute($stmt);
}
