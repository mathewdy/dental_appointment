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
                    <p class="h4 text-muted">Keep your smile healthy and bright! Here's your dental care overview.</p>
                    <a href="appointments.php" class="btn btn-md btn-primary me-2"><i class="fas fa-plus me-3"></i> Book an appointment</a>
                    <a href="history.php" class="btn btn-md btn-outline-dark"><i class="fas fa-clipboard me-3"></i> View Records</a>
                </div>
                <div class="row justify-content-center">
                  <div class="col-lg-5">
                    <div class="card card-stats card-round" style="border-left: 3px solid blue;">
                      <div class="card-body">
                        <div class="row align-items-center px-3">
                          <div class="col-lg-12">
                            <div class="row align-items-center">
                              <div class="col-6">
                                <p class="h6 fw-bold text-muted">Submitted Appointments</p>
                              </div>
                              <div class="col-6 d-flex align-items-center justify-content-end">
                                <div class="d-flex align-items-center justify-content-center rounded" style="background: blue; height: 40px; width: 40px;">
                                  <i class="fas fa-clock text-white"></i>
                                </div>
                              </div>
                            </div>            
                          </div>
                          <div class="col-lg-12">
                            <div class="numbers">
                              <h4 class="fs-1"><?= $row_total['total_appointments'] ?></h4>
                            </div>
                          </div>
                          <div class="col-lg-12">
                            <p class="text-muted">Waiting for clinic confirmation</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-5">
                    <div class="card card-stats card-round" style="border-left: 3px solid green;">
                      <div class="card-body">
                        <div class="row align-items-center px-3">
                          <div class="col-lg-12">
                            <div class="row align-items-center">
                              <div class="col-6">
                                <p class="h6 fw-bold text-muted">Confirmed Appointments</p>
                              </div>
                              <div class="col-6 d-flex align-items-center justify-content-end">
                                <div class="d-flex align-items-center justify-content-center rounded bg-success" style=" height: 40px; width: 40px;">
                                  <i class="fas fa-check-circle text-white"></i>
                                </div>
                              </div>
                            </div>            
                          </div>
                          <div class="col-lg-12">
                            <div class="numbers">
                              <h4 class="fs-1"><?= $row_confirmed['total_confirmed'] ?></h4>
                            </div>
                          </div>
                          <div class="col-lg-12">
                            <p class="text-muted">Ready for dental visit</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-5">
                    <div class="card card-stats card-round" style="border-left: 3px solid orange;">
                      <div class="card-body">
                        <div class="row align-items-center px-3">
                          <div class="col-lg-12">
                            <div class="row align-items-center">
                              <div class="col-6">
                                <p class="h6 fw-bold text-muted">Walk-ins</p>
                              </div>
                              <div class="col-6 d-flex align-items-center justify-content-end">
                                <div class="d-flex align-items-center justify-content-center rounded bg-warning" style="height: 40px; width: 40px;">
                                  <i class="fas fa-clock text-white"></i>
                                </div>
                              </div>
                            </div>            
                          </div>
                          <div class="col-lg-12">
                            <div class="numbers">
                              <h4 class="fs-1"><?= $row_walkin['total_walkin'] ?></h4>
                            </div>
                          </div>
                          <div class="col-lg-12">
                            <p class="text-muted">Waiting for clinic confirmation</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-5">
                    <div class="card card-stats card-round" style="border-left: 3px solid red;">
                      <div class="card-body">
                        <div class="row align-items-center px-3">
                          <div class="col-lg-12">
                            <div class="row align-items-center">
                              <div class="col-6">
                                <p class="h6 fw-bold text-muted">Cancelled Appointments</p>
                              </div>
                              <div class="col-6 d-flex align-items-center justify-content-end">
                                <div class="d-flex align-items-center justify-content-center rounded bg-danger" style="height: 40px; width: 40px;">
                                  <i class="fas fa-clock text-white"></i>
                                </div>
                              </div>
                            </div>            
                          </div>
                          <div class="col-lg-12">
                            <div class="numbers">
                              <h4 class="fs-1"><?= $row_cancelled['total_cancelled'] ?></h4>
                            </div>
                          </div>
                          <div class="col-lg-12">
                            <p class="text-muted">Cancelled their appointments</p>
                          </div>
                        </div>
                      </div>
                    </div>
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