<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Users/dentists.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Users/patients.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$first_name = $_SESSION['first_name'];
$user_id_patient = $_SESSION['user_id'];
?>
<style>
    .fc-button-primary {
        background: #50B6BB !important
    }

    .fc-event {
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
                                <a href="#" class="btn btn-sm btn-primary text-truncate m-2 d-none d-md-block"
                                    data-bs-toggle="modal" data-bs-target="#doctorModal">Add Appointment</a>
                                <a href="requests.php" class="btn btn-sm btn-dark op-7 d-none d-md-block">View All
                                    Requests</a>
                            </div>
                        </div>
                    </div>
                    <div class="page-category">
                        <div class="row">
                            <div class="col-lg-12 p-0 p-lg-3">
                                <div class="text-end mx-3 mb-2 gap-2 d-flex flex-column gap-2">
                                    <a href="#" class="btn btn-sm btn-primary text-truncate d-block d-md-none"
                                        data-bs-toggle="modal" data-bs-target="#doctorModal">Add Appointment</a>
                                    <a href="requests.php" class="btn btn-sm btn-dark op-7 d-block d-md-none">View All
                                        Requests</a>
                                </div>
                                <div class="card p-3">
                                    <div id="calendar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="doctorModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Dentists</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!--<form action="" method="POST">-->

                    <table class="display table table-striped table-hover" id="dataTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Schedule</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $run_dentist = getAllDentist($conn, '3');
                            while ($row_dentist = mysqli_fetch_assoc($run_dentist)) {
                                ?>
                                <tr>
                                    <td style="max-width: 150px;">
                                        <div class="text-truncate">
                                            <?php echo $row_dentist['first_name'] . " " . $row_dentist['last_name'] ?>
                                        </div>
                                    </td>
                                    <td class="text-truncate" style="max-width: 150px;">
                                        <?php
                                        echo formatDentistScheduleDisplay($conn, $row_dentist['user_id']);
                                        ?>
                                    </td>
                                    <td>
                                        <a
                                            href="select-dentist.php?user_id_dentist=<?= $row_dentist['user_id']; ?>&user_id_patient=<?= $user_id_patient; ?>">Select</a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>


                    <!--</form>-->
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
    include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/scripts.php');
    ?>
    <script>
        $('#doctorModal').on('shown.bs.modal', function () {
            table.columns.adjust();
        });
    </script>