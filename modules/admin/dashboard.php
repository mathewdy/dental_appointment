<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/security.php');

$first_name = $_SESSION['first_name'];                
$today = date('m/d/Y'); // Matches your DB format
$currentWeek = date('W');
$currentMonth = date('m');
$currentYear = date('Y');

// DAILY REPORT
$query_daily = "
    SELECT 
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
    WHERE a.appointment_date = '$today'
    ORDER BY a.appointment_time ASC
";


// WEEKLY REPORT
$query_weekly = "
    SELECT 
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
    WHERE WEEK(STR_TO_DATE(a.appointment_date, '%m/%d/%Y'), 1) = '$currentWeek'
      AND YEAR(STR_TO_DATE(a.appointment_date, '%m/%d/%Y')) = '$currentYear'
    ORDER BY STR_TO_DATE(a.appointment_date, '%m/%d/%Y') ASC, a.appointment_time ASC
";

// MONTHLY REPORT
$query_monthly = "
    SELECT 
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
    WHERE MONTH(STR_TO_DATE(a.appointment_date, '%m/%d/%Y')) = '$currentMonth'
      AND YEAR(STR_TO_DATE(a.appointment_date, '%m/%d/%Y')) = '$currentYear'
    ORDER BY STR_TO_DATE(a.appointment_date, '%m/%d/%Y') ASC, a.appointment_time ASC
";

// Display function
function displayReport($result, $title) {
    echo "<h3>$title</h3>";
    if (mysqli_num_rows($result) > 0) {
        echo "<div class='table-responsive'>";
        echo "<table class='display table' id='dataTable'>";
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
            <tbody>    
        ";
        while ($row = mysqli_fetch_assoc($result)) {
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
        echo "</tbody></table></div>";
    } else {
        echo "<p>No data found.</p><br>";
    }
}

$run_daily = mysqli_query($conn, $query_daily);
$run_weekly = mysqli_query($conn, $query_weekly);
$run_monthly = mysqli_query($conn, $query_monthly);
?>

<div class="wrapper">
	<?php include '../../includes/sidebar.php'; ?>

	<div class="main-panel">
		<?php include '../../includes/topbar.php'; ?>
		<div class="container">
			<div class="page-inner">
				<div class="page-header">
                    
					<span class="d-flex justify-content-between align-items-center w-100">
						<span class="d-flex">
							<h4 class="page-title">Home</h4>
							<ul class="breadcrumbs d-flex justify-items-center align-items-center">
								<li class="nav-home">
									<a href="dashboard.php"><i class="icon-home"></i></a>
								</li>
								<li class="separator"><i class="icon-arrow-right"></i></li>
							</ul>
						</span>    
					</span>
				</div>
				<div class="page-category">
					<h1>Welcome <?= $first_name; ?></h1>
				</div>
				<div class="row">
					<div class="col-lg-6">
						<div class="card p-4">
							<?php displayReport($run_daily, "Daily Appointments (" . date('F j, Y') . ")"); ?>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="card p-4">
							<?php displayReport($run_weekly, "Weekly Appointments (Week $currentWeek)"); ?>
						</div>
					</div>
					<div class="col-lg-12">
						<div class="card p-4">
							<?php displayReport($run_monthly, "Monthly Appointments (" . date('F Y') . ")"); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/scripts.php'); 
?>