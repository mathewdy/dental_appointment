<?php 
function getRecordCount($conn, $category) {
  $today = date('m/d/Y');
  $currentWeek = date('W');
  $currentMonth = date('m');
  $currentYear = date('Y');
  $query = "SELECT 
    a.appointment_date,
    a.appointment_time,
    CONCAT(p.first_name, ' ', p.last_name) AS patient_name,
    CONCAT(d.first_name, ' ', d.last_name) AS doctor_name,
    a.concern,
    CASE 
        WHEN a.confirmed = 1 THEN 'Confirmed'
        WHEN a.confirmed = 2 THEN 'Cancelled'
        ELSE 'Pending'
    END AS status
  FROM appointments a
  LEFT JOIN users p ON a.user_id_patient = p.user_id
  LEFT JOIN users d ON a.user_id = d.user_id ";
  
  $handleWhere = match($category){
    'week' => "WHERE WEEK(STR_TO_DATE(a.appointment_date, '%m/%d/%Y'), 1) = '$currentWeek'
      AND YEAR(STR_TO_DATE(a.appointment_date, '%m/%d/%Y')) = '$currentYear'
    ORDER BY STR_TO_DATE(a.appointment_date, '%m/%d/%Y') ASC, a.appointment_time ASC",
    'month' => "WHERE MONTH(STR_TO_DATE(a.appointment_date, '%m/%d/%Y')) = '$currentMonth'
      AND YEAR(STR_TO_DATE(a.appointment_date, '%m/%d/%Y')) = '$currentYear'
    ORDER BY STR_TO_DATE(a.appointment_date, '%m/%d/%Y') ASC, a.appointment_time ASC",
    default => "WHERE a.appointment_date = '$today'
    ORDER BY a.appointment_time ASC"
  };
  $queryBasedOnCategory = $query . ' ' . $handleWhere;
  $run = mysqli_query($conn, $queryBasedOnCategory);
  $rows = mysqli_fetch_all($run, MYSQLI_ASSOC);
  $rowCount = count($rows);
  echo $rowCount;
}

function displayReport($conn) {
  $query = "SELECT 
    a.appointment_date,
    a.appointment_time,
    CONCAT(p.first_name, ' ', p.last_name) AS patient_name,
    CONCAT(d.first_name, ' ', d.last_name) AS doctor_name,
    a.concern,
    CASE 
        WHEN a.confirmed = 1 THEN 'Confirmed'
        WHEN a.confirmed = 2 THEN 'Cancelled'
        WHEN a.confirmed = 3 THEN 'No Show'
        ELSE 'Pending'
    END AS status,
    CASE 
      WHEN a.appointment_date = '' THEN '00/00/0000'
      ELSE a.appointment_date
    END AS appointment
  FROM appointments a
  LEFT JOIN users p ON a.user_id_patient = p.user_id
  LEFT JOIN users d ON a.user_id = d.user_id ";
 
  $run = mysqli_query($conn, $query);
  $rows = mysqli_fetch_all($run, MYSQLI_ASSOC);
  echo "
    <thead>
      <tr>
          <th>Date</th>
          <th>Time</th>
          <th>Patient Name</th>
          <th>Doctor</th>
          <th>Concern</th>
          <th>Status</th>
      </tr>
    </thead>
    <tbody>";

  foreach ($rows as $row) {
    $time = $row['appointment_time'];
    $start = date("H:i A", strtotime($time));
    $end = date("H:i A", strtotime($time . "+ 1 hour"));
    $handler = match($row['status']){
      'Confirmed' => '<span class="badge text-dark text-body-secondary fw-bold" style="background: #94f7c9; border: #94f7c9;"><i class="fas fa-check-circle"></i> Confirmed</span>',
      'Cancelled' => '<span class="badge text-dark text-body-secondary fw-bold" style="background: #f79494; border: #f79494;"><i class="fas fa-times-circle"></i> Cancelled</span>',
      'No Show' => '<span class="badge text-dark text-body-secondary fw-bold" style="background: #fab273; border: #fab273;"><i class="fas fa-times"></i> No Show</span>',
      default => '<span class="badge text-dark text-body-secondary fw-bold" style="background: #fae373; border: #fae373;"><i class="fas fa-clock"></i> Pending</span>'
    };

            echo "
                <tr>
                    <td>{$row['appointment']}</td>
                    <td>$start - $end</td>
                    <td>{$row['patient_name']}</td>
                    <td>Dr. {$row['doctor_name']}</td>
                    <td>{$row['concern']}</td>
                    <td>{$handler}</td>
                </tr>
            ";
        }
    echo "</tbody>";
}
function displayTodayReportById($conn, $id) {
    $today = date('m/d/Y');

    $query = "
        SELECT 
            a.appointment_date,
            a.appointment_time,
            a.concern,
            p.first_name, 
            p.last_name
        FROM appointments a
        LEFT JOIN users p ON a.user_id_patient = p.user_id
        WHERE a.user_id = ? 
          AND DATE(a.appointment_date) = ?
          AND a.confirmed = 1
        ORDER BY a.appointment_time ASC
    ";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "is", $id, $today);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

    echo "
    <thead>
        <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Patient Name</th>
            <th>Concern</th>
        </tr>
    </thead>
    <tbody>";

    foreach ($rows as $row) {
      $patientName = $row['first_name'] . ' ' . $row['last_name'];
      $time = $row['appointment_time'];
      $formattedTime = date("H:i A", strtotime($time));
      $end = date("H:i A", strtotime($time . "+ 1 hour"));
      echo "
          <tr>
              <td>{$row['appointment_date']}</td>
              <td>$start - $end</td>
              <td>{$patientName}</td>
              <td>{$row['concern']}</td>
          </tr>
      ";
    }

    echo "</tbody>";
}

function displayUpcomingAppointmentsById($conn, $id) {
    $today = date('m/d/Y');

    $query = "
        SELECT 
            a.appointment_date,
            a.appointment_time,
            a.concern,
            p.first_name, 
            p.last_name
        FROM appointments a
        LEFT JOIN users p ON a.user_id_patient = p.user_id
        WHERE a.user_id = ? 
          AND DATE(a.appointment_date) >= ?
          AND a.confirmed = 1
        ORDER BY a.appointment_date ASC, a.appointment_time ASC
    ";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "is", $id, $today);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

    echo "
    <thead>
        <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Patient Name</th>
            <th>Concern</th>
        </tr>
    </thead>
    <tbody>";

    foreach ($rows as $row) {
        $patientName = $row['first_name'] . ' ' . $row['last_name'];
        $time = $row['appointment_time'];
        $start = date("H:i A", strtotime($time));
        $end = date("H:i A", strtotime($time . "+ 1 hour"));
        echo "
            <tr>
                <td>{$row['appointment_date']}</td>
                <td>$start - $end</td>
                <td>{$patientName}</td>
                <td>{$row['concern']}</td>
            </tr>
        ";
    }

    echo "</tbody>";
}

function getMonthlyReport($conn, $id) {
    $start_date = date('m/01/Y');
    $end_date = date('m/t/Y');

    $countQuery = "
        SELECT 
            COALESCE(COUNT(DISTINCT user_id_patient), 0) AS total_patients,
            COALESCE(
                (
                    SELECT concern
                    FROM appointments
                    WHERE user_id = ?
                      AND STR_TO_DATE(appointment_date, '%m/%d/%Y') 
                          BETWEEN STR_TO_DATE(?, '%m/%d/%Y') 
                              AND STR_TO_DATE(?, '%m/%d/%Y')
                    GROUP BY concern
                    ORDER BY COUNT(*) DESC
                    LIMIT 1
                ), 'None'
            ) AS common_concern
        FROM appointments
        WHERE user_id = ?
          AND STR_TO_DATE(appointment_date, '%m/%d/%Y') 
              BETWEEN STR_TO_DATE(?, '%m/%d/%Y') 
                  AND STR_TO_DATE(?, '%m/%d/%Y')
    ";

    $stmt = mysqli_prepare($conn, $countQuery);
    mysqli_stmt_bind_param($stmt, "ississ", $id, $start_date, $end_date, $id, $start_date, $end_date);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);
    echo "
    <thead>
        <tr>
            <th>Total Patients</th>
            <th>Common Concern</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{$data['total_patients']}</td>
            <td>{$data['common_concern']}</td>
        </tr>
    </tbody>";
}

?>
