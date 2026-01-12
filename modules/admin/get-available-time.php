<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/connection/connection.php');
header("Content-Type: application/json");

if (!isset($_GET['date']) || !isset($_GET['dentist_id'])) {
    echo json_encode(["timeslots" => []]);
    exit;
}

$date = $_GET['date'];
$dentist_id = $_GET['dentist_id'];

// Normalize date to Y-m-d format for consistent comparison
$normalized_date = date('Y-m-d', strtotime($date));

$day_of_week = date('l', strtotime($date));
$sql = "SELECT start_time, end_time 
        FROM dentist_schedules 
        WHERE user_id = ? AND day_of_week = ? AND is_active = 1 
        LIMIT 1";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "is", $dentist_id, $day_of_week);
mysqli_stmt_execute($stmt);
$schedResult = mysqli_stmt_get_result($stmt);

if (!$schedResult || mysqli_num_rows($schedResult) == 0) {
    echo json_encode(["timeslots" => []]);
    exit;
}

$sched = mysqli_fetch_assoc($schedResult);
$start = $sched['start_time'];
$end = $sched['end_time'];


date_default_timezone_set('Asia/Manila');

$timeslots = [];
$current = strtotime($start);
$end_ts = strtotime($end);

// Check if today - use normalized date for accurate comparison
$is_today = ($normalized_date == date('Y-m-d'));
$now = time();

while ($current < $end_ts) {
    if ($is_today && $current < $now) {
        // Skip past times
    } else {
        $timeslots[] = date("h:i A", $current);
    }
    $current = strtotime("+1 hour", $current);
}

$booked = [];

$sql2 = "SELECT appointment_time
         FROM appointments
         WHERE user_id = '$dentist_id'
         AND appointment_date = '$date' AND confirmed IN (0, 1)";

$res2 = mysqli_query($conn, $sql2);

while ($row = mysqli_fetch_assoc($res2)) {
    $booked[] = date("h:i A", strtotime($row['appointment_time']));
}

$available = array_values(array_diff($timeslots, $booked));

echo json_encode(["timeslots" => $available]);
// var_dump($timeslots);
exit;
?>