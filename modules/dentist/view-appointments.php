<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/security.php');

$user_id = $_SESSION['user_id'];
$first_name = $_SESSION['first_name'];
?>
<style>
    .fc-button-primary{
        background: #50B6BB !important
    }
    .fc-event{
        background: #45969B;
    }
</style>
<body>
    <div class="wrapper">
        <?php include '../../includes/sidebar.php'; ?>
      <div class="main-panel">
        <?php include '../../includes/topbar.php'; ?>
        <div class="container">
          <div class="page-inner">
            <div class="page-header">
              <div class="d-flex align-items-center gap-4 w-100">
                <h4 class="page-title text-truncate">Appointments</h4>
                <div class="d-flex align-items-center gap-2 me-auto">
                  <div class="nav-home">
                    <a href="dashboard.php" class="text-decoration-none text-muted">
                      <i class="icon-home"></i>
                    </a>
                  </div>
                  <div class="separator">
                    <i class="icon-arrow-right fs-bold"></i>
                  </div>
                  <div class="nav-item">
                    <a href="#" class="text-decoration-none text-truncate text-muted">Appointments</a>
                  </div>
                </div>
                <div class="d-flex align-items-center">
                  <a href="requests.php" class="btn btn-sm btn-dark op-7 d-none d-md-block">View All Requests</a>
                </div>
              </div>
            </div>
            <div class="page-category">
                <div class="row">
                    <div class="col-lg-12">
                      <div class="text-end mb-2 d-flex flex-column">
                        <a href="requests.php" class="btn btn-sm btn-dark op-7 d-block d-md-none">View All Requests</a>
                      </div>
                        <div class="card p-5">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="appointmentInfo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Appointment Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="appointment_info" id="appointment_info"></div>
                </div>
            </div>
        </div>
    </div>
<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/scripts.php'); 
?>