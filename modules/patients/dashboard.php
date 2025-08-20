<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/security.php');

$first_name = $_SESSION['first_name'];
$id = $_SESSION['user_id'];

date_default_timezone_set('Asia/Manila');

$sql_total = "SELECT COUNT(*) AS total_appointments 
              FROM appointments 
              WHERE user_id_patient = '$id'";
$result_total = mysqli_query($conn, $sql_total);
$row_total = mysqli_fetch_assoc($result_total);

$sql_confirmed = "SELECT COUNT(*) AS total_confirmed 
                  FROM appointments 
                  WHERE user_id_patient = '$id' 
                  AND confirmed = 1";
$result_confirmed = mysqli_query($conn, $sql_confirmed);
$row_confirmed = mysqli_fetch_assoc($result_confirmed);

$sql_cancelled = "SELECT COUNT(*) AS total_cancelled 
                  FROM appointments 
                  WHERE user_id_patient = '$id' 
                  AND confirmed = 2";
$result_cancelled = mysqli_query($conn, $sql_cancelled);
$row_cancelled = mysqli_fetch_assoc($result_cancelled);

$sql_walkin = "SELECT COUNT(*) AS total_walkin 
               FROM appointments 
               WHERE user_id_patient = '$id' 
               AND walk_in = 1";
$result_walkin = mysqli_query($conn, $sql_walkin);
$row_walkin = mysqli_fetch_assoc($result_walkin);



mysqli_close($conn);

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
                                echo "Total Appointments Submitted: " . $row_total['total_appointments'] . "<br>";
                            ?>
                        </div>
                        
                    </div>
                    <div class="col-lg-6">
                        <div class="card p-4">
                            <?php
                                echo "Total Confirmed Appointments: " . $row_confirmed['total_confirmed'] . "<br>";
                            ?>
                        </div>
                        
                    </div>
                    <div class="col-lg-12">
                        <div class="card p-4">
                            <?php
                                echo "Total Cancelled Appointments: " . $row_cancelled['total_cancelled'] . "<br>";
                            ?>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card p-4">
                            <?php
                               echo "Total Walk-in Appointments: " . $row_walkin['total_walkin'] . "<br>";
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