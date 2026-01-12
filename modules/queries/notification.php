<?php 
date_default_timezone_set('Asia/Manila');

function createNotification($conn, $user_id, $trans_id, $message, $type, $createdBy) {
  $now = date("Y-m-d H:i:s");
  $sql = "INSERT INTO `notification` (user_id, trans_id, `message`, hasRead, `type`, createdAt, createdBy)
    VALUES (?, ?, ?, 0, ?, ?, ?)";
  
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "isssss", $user_id, $trans_id, $message, $type, $now, $createdBy); 
  
  return mysqli_stmt_execute($stmt);
}

function getAllNotification($conn) {
    $sql = "SELECT 
    n.user_id,
    n.type, 
    n.message, 
    n.createdAt,
    n.createdBy,
    u.user_id AS creator_id,
    u.first_name,
    u.last_name
  FROM `notification` AS n
  LEFT JOIN `users` AS u 
    ON n.createdBy = u.user_id";

  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_execute($stmt);

  return mysqli_stmt_get_result($stmt);
}

function getNotificationById($conn, $id) {
  $sql = "SELECT 
    n.user_id,
    n.type, 
    n.message, 
    n.createdAt,
    n.createdBy,
    u.user_id AS creator_id,
    u.first_name,
    u.last_name
  FROM `notification` AS n
  LEFT JOIN `users` AS u 
    ON n.createdBy = u.user_id
  WHERE n.user_id = ?";

  $stmt = mysqli_prepare($conn, $sql);
  if (!$stmt) {
    die("SQL prepare failed: " . mysqli_error($conn));
  }

  mysqli_stmt_bind_param($stmt, "i", $id); 
  mysqli_stmt_execute($stmt);

  $result = mysqli_stmt_get_result($stmt);
  return $result;
}
