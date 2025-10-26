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
        ELSE 'Pending'
    END AS status
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
            echo "
                <tr>
                    <td>{$row['appointment_date']}</td>
                    <td>{$row['appointment_time']}</td>
                    <td>{$row['patient_name']}</td>
                    <td>Dr. {$row['doctor_name']}</td>
                    <td>{$row['concern']}</td>
                    <td>{$row['status']}</td>
                </tr>
            ";
        }
    echo "</tbody>";
}
function displayReportById($conn, $id) {
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
  LEFT JOIN users d ON a.user_id = d.user_id 
  WHERE a.user_id = ' . $id . '";
 
  $run = mysqli_query($conn, $query);
  $rows = mysqli_fetch_all($run, MYSQLI_ASSOC);
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
            echo "
                <tr>
                    <td>{$row['appointment_date']}</td>
                    <td>{$row['appointment_time']}</td>
                    <td>{$row['patient_name']}</td>
                    <td>{$row['concern']}</td>
                </tr>
            ";
        }
    echo "</tbody>";
}

function getMonthlyReport($conn, $id) {
  $currentMonth = date('m');
  $currentYear = date('Y');

  $countQuery = "
  SELECT COUNT(*) AS total_count
  FROM appointments
  WHERE user_id = $id
    AND MONTH(appointment_date) = $currentMonth
    AND YEAR(appointment_date) = $currentYear
  ";
  $countResult = mysqli_query($conn, $countQuery);
  $totalCount = mysqli_fetch_assoc($countResult)['total_count'] ?? 0;

  $concernQuery = "
  SELECT concern, COUNT(concern) AS concern_count
  FROM appointments
  WHERE user_id = $id
    AND MONTH(appointment_date) = $currentMonth
    AND YEAR(appointment_date) = $currentYear
  GROUP BY concern
  ORDER BY concern_count DESC
  LIMIT 1
  ";
  $concernResult = mysqli_query($conn, $concernQuery);
  $topConcern = mysqli_fetch_assoc($concernResult)['concern'] ?? 'None';

  echo "
    <thead>
      <tr>
          <th>Total Patients</th>
          <th>Common Concern</th>
      </tr>
    </thead>
    <tbody>
      <tr>
          <td>$totalCount</td>
          <td>$topConcern</td>
      </tr>
    </tbody>";
}
?>
