<?php
session_start();
ob_start();
include('../../connection/connection.php');

$first_name = $_SESSION['first_name'];
include('../../includes/security.php');

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include '../../includes/styles.php' ?>
    <title>Document</title>
</head>
<body>

    <div class="wrapper">
        <?php include '../../includes/sidebar.php'; ?>

      <div class="main-panel">
        <?php include '../../includes/topbar.php'; ?>
        <div class="container">
          <div class="page-inner">
            <div class="page-header">
              <h4 class="page-title">Home</h4>
            </div>
            <div class="page-category">
                <h1>Welcome <?= $first_name; ?></h1>
            </div>

          <?php
              date_default_timezone_set('Asia/Manila');

              // Get today's date, current week, and current month
              $today = date('Y-m-d');
              $currentWeek = date('W');
              $currentMonth = date('m');
              $currentYear = date('Y');

              // DAILY REPORT
              $query_daily = "
                  SELECT u.first_name, u.last_name, a.concern, a.appointment_date, a.appointment_time
                  FROM appointments a
                  LEFT JOIN users u ON a.user_id_patient = u.user_id
                  WHERE STR_TO_DATE(a.appointment_date, '%m/%d/%Y') = '$today'
              ";

              // WEEKLY REPORT
              $query_weekly = "
                    SELECT u.first_name, u.last_name, a.concern, a.appointment_date, a.appointment_time
                    FROM appointments a
                    LEFT JOIN users u ON a.user_id_patient = u.user_id
                    WHERE WEEK(STR_TO_DATE(a.appointment_date, '%m/%d/%Y'), 1) = '$currentWeek'
                    AND YEAR(STR_TO_DATE(a.appointment_date, '%m/%d/%Y')) = '$currentYear'
                ";


              // MONTHLY REPORT
             $query_monthly = "
                  SELECT u.first_name, u.last_name, a.concern, a.appointment_date, a.appointment_time
                  FROM appointments a
                  LEFT JOIN users u ON a.user_id_patient = u.user_id
                  WHERE MONTH(STR_TO_DATE(a.appointment_date, '%m/%d/%Y')) = '$currentMonth'
                  AND YEAR(STR_TO_DATE(a.appointment_date, '%m/%d/%Y')) = '$currentYear'
              ";

              // Function to display result
              function displayReport($result, $title) {
                  echo "<h3>$title</h3>";
                  if (mysqli_num_rows($result) > 0) {
                      echo "<table border='1' cellpadding='5' cellspacing='0'>";
                      echo "<tr>
                              <th>Date</th>
                              <th>Time</th>
                              <th>First Name</th>
                              <th>Last Name</th>
                              <th>Concern</th>
                            </tr>";
                      while ($row = mysqli_fetch_assoc($result)) {
                          echo "<tr>
                                  <td>{$row['appointment_date']}</td>
                                  <td>{$row['appointment_time']}</td>
                                  <td>{$row['first_name']}</td>
                                  <td>{$row['last_name']}</td>
                                  <td>{$row['concern']}</td>
                                </tr>";
                      }
                      echo "</table><br>";
                  } else {
                      echo "<p>No data found for $title.</p><br>";
                  }
              }

              // Run and display reports
              $run_daily = mysqli_query($conn, $query_daily);
              $run_weekly = mysqli_query($conn, $query_weekly);
              $run_monthly = mysqli_query($conn, $query_monthly);

              displayReport($run_daily, "Daily Appointments (" . date('F j, Y') . ")");
              displayReport($run_weekly, "Weekly Appointments (Week $currentWeek)");
              displayReport($run_monthly, "Monthly Appointments (" . date('F Y') . ")");
              ?>

           
          </div>
        </div>
      </div>
    </div>
    <?php include "../../includes/scripts.php"; ?>
</body>
</html>