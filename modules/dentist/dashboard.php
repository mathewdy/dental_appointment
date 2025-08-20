<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/security.php');
$first_name = $_SESSION['first_name'];
$id = $_SESSION['user_id'];

$today = date("Y-m-d");

$sql_total = "SELECT COUNT(*) AS total_today 
              FROM appointments 
              WHERE user_id = '$id' 
              AND appointment_date = '$today'";
$result_total = mysqli_query($conn, $sql_total);
$row_total = mysqli_fetch_assoc($result_total);

$sql_confirmed = "SELECT COUNT(*) AS total_confirmed 
                  FROM appointments 
                  WHERE user_id = '$id' 
                  AND appointment_date = '$today' 
                  AND confirmed = 1";
$result_confirmed = mysqli_query($conn, $sql_confirmed);
$row_confirmed = mysqli_fetch_assoc($result_confirmed);

$sql_pending = "SELECT COUNT(*) AS total_pending 
                FROM appointments 
                WHERE user_id = '$id' 
                AND appointment_date = '$today' 
                AND confirmed = 0";
$result_pending = mysqli_query($conn, $sql_pending);
$row_pending = mysqli_fetch_assoc($result_pending);

$sql_cancelled = "SELECT COUNT(*) AS total_cancelled 
                  FROM appointments 
                  WHERE user_id = '$id' 
                  AND appointment_date = '$today' 
                  AND confirmed = 2";
$result_cancelled = mysqli_query($conn, $sql_cancelled);
$row_cancelled = mysqli_fetch_assoc($result_cancelled);



mysqli_close($conn);

?>
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
 <div class="row">
                  <div class="col-lg-6">
                    <div class="card card-stats card-round">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-icon">
                            <div class="icon-big text-center icon-primary bubble-shadow-small">
                              <i class="fas fa-calendar"></i>
                            </div>
                          </div>
                          <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                              <p class="card-category">Submitted Appointments</p>
                              <h4 class="card-title"><?= $row_total['total_appointments'] ?></h4>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="card card-stats card-round">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-icon">
                            <div class="icon-big text-center icon-success bubble-shadow-small">
                              <i class="fas fa-calendar"></i>
                            </div>
                          </div>
                          <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                              <p class="card-category">Confirmed Appointments</p>
                              <h4 class="card-title"><?= $row_confirmed['total_confirmed'] ?></h4>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="card card-stats card-round">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-icon">
                            <div class="icon-big text-center icon-info bubble-shadow-small">
                              <i class="fas fa-calendar"></i>
                            </div>
                          </div>
                          <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                              <p class="card-category">Walk-ins</p>
                              <h4 class="card-title"><?= $row_walkin['total_walkin'] ?></h4>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="card card-stats card-round">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-icon">
                            <div class="icon-big text-center icon-danger bubble-shadow-small">
                              <i class="fas fa-calendar"></i>
                            </div>
                          </div>
                          <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                              <p class="card-category">Cancelled Appointments</p>
                              <h4 class="card-title"><?= $row_cancelled['total_cancelled'] ?></h4>
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