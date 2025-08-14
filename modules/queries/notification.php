<?php 

function createNotification($conn, $user_id, $message, $type, $createdBy) {
  $sql = "INSERT INTO `notification` (user_id, `message`, hasRead, `type`, createdAt, createdBy)
    VALUES (?, ?, 0, ?, NOW(), ?)";
  
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "isss", $user_id, $message, $type, $createdBy); 
  
  return mysqli_stmt_execute($stmt);
}