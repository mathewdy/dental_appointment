<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/Reports/reports.php');

$first_name = $_SESSION['first_name'];
$id = $_SESSION['user_id'];

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
          <div class="row mb-4">
            <div class="col-lg-12">
              <p class="h2 m-0 p-0">Hello <?= $first_name ?></p>
            </div>
          </div>
          <div class="row g-4">
            <div class="col-lg-6">
              <div class="card p-3" style="height: 100%;">
                <div class="card-header">
                  <h2 class="h4 fw-bold m-0 p-0">Today's Appointments</h2>
                </div>
                <div class="card-body p-0 m-0">
                  <div class="table-responsive">
                    <table id="table1" class="table table-bordered">
                      <?php displayTodayReportById($conn, $id); ?>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="card p-3" style="height: 100%;">
                <div class="card-header">
                  <h2 class="h4 fw-bold m-0 p-0">Upcoming Appointments</h2>
                </div>
                <div class="card-body p-0 m-0">
                  <div class="table-responsive h-100">
                    <table id="table2" class="table table-bordered">
                      <?php displayUpcomingAppointmentsById($conn, $id); ?>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6" >
              <div class="card p-3" style="height: 100%;">
                <div class="card-header">
                  <h2 class="h4 fw-bold m-0 p-0">Monthly Summary Status</h2>
                </div>
                <div class="card-body p-0 m-0">
                  <div class="table-responsive">
                    <table id="table2" class="table table-bordered">
                      <?php getMonthlyReport($conn, $id); ?>
                    </table>
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
<script>
$(document).ready(function () {
  $('#table1').DataTable();
  $('#table2').DataTable();
  $('#table3').DataTable();
});
</script>
