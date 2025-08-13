<?php 

function createNotification($conn, $user_id, $message, $type, $createdAt, $createdBy) {
  $sql = "INSERT INTO `notification` (user_id, `message`, hasRead, `type`, createdAt, createdBy)
    VALUES (?, ?, 0, ?, ?, ?)";
  
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "issss", $user_id, $message, $type, $createdAt, $createdBy); 
  
  return mysqli_stmt_execute($stmt);
}