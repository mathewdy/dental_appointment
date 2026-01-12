<?php
date_default_timezone_set('Asia/Manila');
function createDentistSchedule($conn, $user_id, $days, $start, $end)
{
    $now = date("Y-m-d H:i:s");
    $sql = "INSERT INTO schedule (user_id,
    day,
    start_time,
    end_time,
    date_created)
    VALUES (?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "issss", $user_id, $days, $start, $end, $now);

    return mysqli_stmt_execute($stmt);
}

function getAllDentist($conn, $role)
{
    $sql = "SELECT 
      users.user_id AS user_id, 
      users.first_name AS first_name, 
      users.middle_name AS middle_name, 
      users.last_name AS last_name, 
      users.mobile_number AS mobile_number, 
      users.email AS email
    FROM users 
    WHERE users.role_id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $role);
    mysqli_stmt_execute($stmt);

    return mysqli_stmt_get_result($stmt);
}

// Helper function to format dentist schedule for display
function formatDentistScheduleDisplay($conn, $user_id)
{
    $schedules = getDentistSchedules($conn, $user_id);
    if (empty($schedules)) {
        return "No schedule set";
    }

    $parts = [];
    $dayAbbr = [
        'Monday' => 'Mon',
        'Tuesday' => 'Tue',
        'Wednesday' => 'Wed',
        'Thursday' => 'Thu',
        'Friday' => 'Fri',
        'Saturday' => 'Sat',
        'Sunday' => 'Sun'
    ];

    foreach ($schedules as $day => $data) {
        $abbr = $dayAbbr[$day] ?? $day;
        $start = date("g:iA", strtotime($data['start_time']));
        $end = date("g:iA", strtotime($data['end_time']));
        $parts[] = "$abbr $start-$end";
    }

    return implode(", ", $parts);
}

function getDentistById($conn, $role, $id)
{
    $sql = "SELECT users.user_id AS user_id, 
    users.first_name AS first_name, 
    users.middle_name AS middle_name, 
    users.last_name AS last_name, 
    users.mobile_number AS mobile_number, 
    users.email AS email
  FROM users 
  WHERE users.role_id = ? AND users.user_id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $role, $id);
    mysqli_stmt_execute($stmt);

    return mysqli_stmt_get_result($stmt);
}

function updateDentist($conn, $first_name, $middle_name, $last_name, $email, $user_id)
{
    $sql = "UPDATE users 
  SET first_name = ?, 
    middle_name = ?, 
    last_name = ?, 
    email = ?,
    date_updated = NOW() 
  WHERE user_id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssi", $first_name, $middle_name, $last_name, $email, $user_id);

    return mysqli_stmt_execute($stmt);
}

function updateDentistSchedule($conn, $days, $start, $end, $user_id)
{
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

function createDentistScheduleV2($conn, $user_id, $schedule_data)
{
    $success = true;
    $sql = "INSERT INTO dentist_schedules (user_id, day_of_week, start_time, end_time, is_active) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    foreach ($schedule_data as $day => $data) {
        if (isset($data['active']) && $data['active'] == 1) {
            $is_active = 1;
            $start = $data['start'];
            $end = $data['end'];

            mysqli_stmt_bind_param($stmt, "isssi", $user_id, $day, $start, $end, $is_active);
            if (!mysqli_stmt_execute($stmt)) {
                $success = false;
            }
        }
    }
    return $success;
}

function getDentistSchedules($conn, $user_id)
{
    $sql = "SELECT day_of_week, start_time, end_time FROM dentist_schedules WHERE user_id = ? AND is_active = 1";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $schedules = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $schedules[$row['day_of_week']] = $row;
    }
    return $schedules;
}

function updateDentistScheduleV2($conn, $user_id, $schedule_data)
{
    // Delete existing
    $sql_del = "DELETE FROM dentist_schedules WHERE user_id = ?";
    $stmt_del = mysqli_prepare($conn, $sql_del);
    mysqli_stmt_bind_param($stmt_del, "i", $user_id);
    mysqli_stmt_execute($stmt_del);

    // Insert new
    return createDentistScheduleV2($conn, $user_id, $schedule_data);
}
