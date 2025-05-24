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

          $query_date_today = "SELECT COUNT(*) AS total_appointments,
          SUM(CASE WHEN confirmed = 1 THEN 1 ELSE 0 END) AS total_completed,
          SUM(CASE WHEN walk_in = 1 THEN 1 ELSE 0 END) AS total_walkins,
          SUM(CASE WHEN confirmed = 2 THEN 1 ELSE 0 END) AS total_cancellations
          FROM appointments
          WHERE STR_TO_DATE(appointment_date, '%m/%d/%Y') = CURDATE();";
          $run_date_today = mysqli_query($conn,$query_date_today);

          if(mysqli_num_rows($run_date_today) > 0){
            foreach($run_date_today as $row_date_today){
              ?>

              <h1>For today!</h1>

              <h1>Total Appointments Scheduled: <?php echo $row_date_today['total_appointments']?></h1>
              <h1>Total Appointments Completed: <?php echo $row_date_today['total_completed']?></h1>
              <h1>Walk-in Appointments: <?php echo $row_date_today['total_walkins']?></h1>
              <h1>Cancellations: <?php echo $row_date_today['total_cancellations']?></h1>

              <?php
            }
          }


          ?>

          

            <form action="" method="POST">
              <input type="date" name="start_date">
              <input type="date" name="end_date">
              <input type="submit" name="filter" value="Filter">
            </form>
          </div>
        </div>
      </div>
    </div>
    <?php include "../../includes/scripts.php"; ?>
</body>
</html>

<?php
if (isset($_POST['start_date']) && isset($_POST['end_date'])) {
  $start_date = $_POST['start_date'];
  $end_date = $_POST['end_date'];

  $filter_dates = "SELECT COUNT(*) AS total_appointments,
                    SUM(CASE WHEN confirmed = 1 THEN 1 ELSE 0 END) AS total_completed,
                    SUM(CASE WHEN walk_in = 1 THEN 1 ELSE 0 END) AS total_walkins,
                    SUM(CASE WHEN confirmed = 2 THEN 1 ELSE 0 END) AS total_cancellations
                FROM appointments
                WHERE STR_TO_DATE(appointment_date, '%m/%d/%Y') 
                      BETWEEN STR_TO_DATE('$start_date', '%Y-%m-%d') 
                      AND STR_TO_DATE('$end_date', '%Y-%m-%d')";
  $run_filter_dates = mysqli_query($conn, $filter_dates);

  if ($run_filter_dates) {
    $row_dates = mysqli_fetch_assoc($run_filter_dates);
    ?>
      <h2>Total Appointments: <?php echo $row_dates['total_appointments']; ?></h2>
      <h2>Total Completed: <?php echo $row_dates['total_completed']; ?></h2>
      <h2>Total Walk-ins: <?php echo $row_dates['total_walkins']; ?></h2>
      <h2>Total Cancellations: <?php echo $row_dates['total_cancellations']; ?></h2>
    <?php
  } else {
    echo "<h3>Query failed: " . mysqli_error($conn) . "</h3>";
  }
}


?>