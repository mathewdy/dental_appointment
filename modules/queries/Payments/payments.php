<?php
date_default_timezone_set('Asia/Manila');

function addBalance($conn, $payment, $id, $appointment, $services, $balance)
{
    $now = date("Y-m-d H:i:s");
    $sql = "INSERT INTO payments (payment_id,
    user_id,
    appointment_id, 
    services,
    initial_balance,
    remaining_balance,
    date_created) 
    VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iiisiis", $payment, $id, $appointment, $services, $balance, $balance, $now);

    return mysqli_stmt_execute($stmt);
}

function createPaymentHistory($conn, $payment, $received, $remaining, $method, $session_label = null)
{
    $now = date("Y-m-d H:i:s");
    $sql = "INSERT INTO payment_history 
    (payment_id, payment_received, payment_method, session_label, remaining_balance, date_created) 
  VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iissis", $payment, $received, $method, $session_label, $remaining, $now);

    return mysqli_stmt_execute($stmt);
}

function getAllPayment($conn)
{
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

function updateBalance($conn, $balance, $payment)
{
    $sql = "UPDATE payments 
    SET initial_balance = ?, 
    remaining_balance = ? 
    WHERE payment_id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iii", $balance, $balance, $payment);

    return mysqli_stmt_execute($stmt);
}

function updateRemainingBalance($conn, $balance, $payment)
{
    $sql = "UPDATE payments 
    SET remaining_balance = ?,
    is_deducted = '1',
    date_updated = ?
    WHERE payment_id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "isi", $balance, $now, $payment);

    return mysqli_stmt_execute($stmt);
}

function deleteBalance($conn, $id, $payment)
{
    $sql = "DELETE FROM payments WHERE user_id = ? AND payment_id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $id, $payment);

    return mysqli_stmt_execute($stmt);
}

function updateConcernAndBalance($conn, $balance, $concern, $payment_id)
{
    // 1. Calculate Total Paid So Far
    $sql_paid = "SELECT SUM(payment_received) as total_paid FROM payment_history WHERE payment_id = ?";
    $stmt_paid = mysqli_prepare($conn, $sql_paid);
    mysqli_stmt_bind_param($stmt_paid, "i", $payment_id);
    mysqli_stmt_execute($stmt_paid);
    $res_paid = mysqli_stmt_get_result($stmt_paid);
    $row_paid = mysqli_fetch_assoc($res_paid);
    $total_paid = $row_paid['total_paid'] ?? 0;

    // 2. Calculate New Remaining Balance
    // New Remaining = New Total Cost - Total Paid
    $new_remaining = $balance - $total_paid;

    // 3. Update Payment Record
    $sql1 = "UPDATE payments SET initial_balance = ?, remaining_balance = ? WHERE payment_id = ?";
    $stmt1 = mysqli_prepare($conn, $sql1);
    mysqli_stmt_bind_param($stmt1, "idi", $balance, $new_remaining, $payment_id);
    $res1 = mysqli_stmt_execute($stmt1);

    // 4. Update Appointment Concern
    $sql2 = "UPDATE appointments INNER JOIN payments ON appointments.appointment_id = payments.appointment_id 
             SET appointments.concern = ? 
             WHERE payments.payment_id = ?";
    $stmt2 = mysqli_prepare($conn, $sql2);
    mysqli_stmt_bind_param($stmt2, "si", $concern, $payment_id);
    $res2 = mysqli_stmt_execute($stmt2);

    return $res1 && $res2;
}

/**
 * Get payment record by appointment ID
 */
function getPaymentByAppointmentId($conn, $appointment_id)
{
    $sql = "SELECT * FROM payments WHERE appointment_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $appointment_id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}