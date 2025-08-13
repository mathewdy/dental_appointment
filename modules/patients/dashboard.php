<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/security.php');

$first_name = $_SESSION['first_name'];
$id = $_SESSION['user_id'];

date_default_timezone_set('Asia/Manila');
$today = date('Y-m-d');
$currentWeek = date('W');
$currentMonth = date('m');
$currentYear = date('Y');
// DAILY REPORT
$query_daily = "
    SELECT p.first_name AS patient_fname, p.last_name AS patient_lname,
            d.first_name AS doctor_fname, d.last_name AS doctor_lname,
            a.concern, a.appointment_date, a.appointment_time
    FROM appointments a
    LEFT JOIN users p ON a.user_id_patient = p.user_id
    LEFT JOIN users d ON a.user_id = d.user_id
    WHERE STR_TO_DATE(a.appointment_date, '%m/%d/%Y') = '$today'
    AND user_id_patient = '$id'
";

// WEEKLY REPORT
$query_weekly = "
    SELECT p.first_name AS patient_fname, p.last_name AS patient_lname,
            d.first_name AS doctor_fname, d.last_name AS doctor_lname,
            a.concern, a.appointment_date, a.appointment_time
    FROM appointments a
    LEFT JOIN users p ON a.user_id_patient = p.user_id
    LEFT JOIN users d ON a.user_id = d.user_id
    WHERE WEEK(STR_TO_DATE(a.appointment_date, '%m/%d/%Y'), 1) = '$currentWeek'
    AND YEAR(STR_TO_DATE(a.appointment_date, '%m/%d/%Y')) = '$currentYear'
    AND user_id_patient = '$id'
";

// MONTHLY REPORT
$query_monthly = "
    SELECT p.first_name AS patient_fname, p.last_name AS patient_lname,
            d.first_name AS doctor_fname, d.last_name AS doctor_lname,
            a.concern, a.appointment_date, a.appointment_time
    FROM appointments a
    LEFT JOIN users p ON a.user_id_patient = p.user_id
    LEFT JOIN users d ON a.user_id = d.user_id
    WHERE MONTH(STR_TO_DATE(a.appointment_date, '%m/%d/%Y')) = '$currentMonth'
    AND YEAR(STR_TO_DATE(a.appointment_date, '%m/%d/%Y')) = '$currentYear'
    AND user_id_patient = '$id'
";

// Display function
function displayReport($result, $title) {
    echo "<h3>$title</h3>";
    if (mysqli_num_rows($result) > 0) {
        echo "<table class='display table' id='dataTable'>";
        echo "
            <thead>
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Patient First Name</th>
                <th>Patient Last Name</th>
                <th>Doctor</th>
                <th>Concern</th>
                </tr>
            </thead>
            <tbody>    
            ";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "
                <tr>
                    <td>{$row['appointment_date']}</td>
                    <td>{$row['appointment_time']}</td>
                    <td>{$row['patient_fname']}</td>
                    <td>{$row['patient_lname']}</td>
                    <td>Dr. {$row['doctor_fname']} {$row['doctor_lname']}</td>
                    <td>{$row['concern']}</td>
                </tr>
                ";
        }
        echo "
            </tbody>  
            </table>
            ";
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
                                <a href="dashboard.php">
                                    <i class="icon-home"></i>
                                </a>
                                </li>
                                <li class="separator">
                                    <i class="icon-arrow-right"></i>
                                </li>
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
                            <?php
                                displayReport($run_daily, "Daily Appointments (" . date('F j, Y') . ")");
                            ?>
                        </div>
                        
                    </div>
                    <div class="col-lg-6">
                        <div class="card p-4">
                            <?php
                                displayReport($run_weekly, "Weekly Appointments (Week $currentWeek)");
                            ?>
                        </div>
                        
                    </div>
                    <div class="col-lg-12">
                        <div class="card p-4">
                            <?php
                                displayReport($run_monthly, "Monthly Appointments (" . date('F Y') . ")");
                            ?>
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