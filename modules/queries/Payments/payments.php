<?php
function addBalance($conn, $payment, $id, $appointment, $services, $balance) {
  $sql = "INSERT INTO payments (payment_id,
    user_id,
    appointment_id, 
    services,
    initial_balance,
    remaining_balance,
    date_created) 
    VALUES (?, ?, ?, ?, ?, ?, NOW())";

  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "iiisii", $payment, $id, $appointment, $services, $balance, $balance);

  return mysqli_stmt_execute($stmt);
}

function createPaymentHistory($conn, $payment, $received, $method) {
  $sql = "INSERT INTO payment_history 
    (payment_id, payment_received, payment_method, date_created) 
  VALUES (?, ?, ?, NOW())";

  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "iis", $payment, $received, $method);

  return mysqli_stmt_execute($stmt);
}

function getAllPayment($conn) {
  $sql = "SELECT DISTINCT users.user_id, 
      users.first_name, 
      users.last_name
    FROM users 
    INNER JOIN appointments 
    ON users.user_id = appointments.user_id_patient 
    WHERE appointments.confirmed = '1' AND users.role_id = '1'";

  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_execute($stmt);

  return mysqli_stmt_get_result($stmt);
}

function updateBalance($conn, $balance, $payment) {
  $sql = "UPDATE payments 
    SET initial_balance = ?, 
    remaining_balance = ? 
    WHERE payment_id = ?";

  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "iii", $balance, $balance, $payment);

  return mysqli_stmt_execute($stmt);
}

function updateRemainingBalance($conn, $balance, $payment) {
  $sql = "UPDATE payments 
    SET remaining_balance = ?,
    is_deducted = '1',
    date_updated = NOW()
    WHERE payment_id = ?";

  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "ii", $balance, $payment);

  return mysqli_stmt_execute($stmt);
}

function deleteBalance($conn, $id, $payment) {
  $sql = "DELETE FROM payments WHERE user_id = ? AND payment_id = ?";

  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "ii", $id, $payment);

  return mysqli_stmt_execute($stmt);
}