<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/security.php');

$first_name = $_SESSION['first_name'];
$user_id = $_SESSION['user_id'];

?>
<div class="wrapper">
    <?php
    include '../../includes/sidebar.php';
    ?>
    <div class="main-panel">
        <?php
        include '../../includes/topbar.php';
        ?>
        <div class="container">
            <div class="page-inner">
                <div class="page-header">
                    <span class="d-flex justify-content-between align-items-center w-100">
                        <span class="d-flex">
                            <h4 class="page-title">Appointment Requests</h4>
                            <ul class="breadcrumbs d-flex justify-items-center align-items-center">
                                <li class="nav-home">
                                    <a href="dashboard.php">
                                        <i class="icon-home"></i>
                                    </a>
                                </li>
                                <li class="separator">
                                    <i class="icon-arrow-right"></i>
                                </li>
                                <li class="nav-item">
                                    <a href="view-appointments.php">Appointments</a>
                                </li>
                                <li class="separator">
                                    <i class="icon-arrow-right"></i>
                                </li>
                                <li class="nav-item">
                                    <a href="#">Appointment Requests</a>
                                </li>
                            </ul>
                        </span>
                    </span>
                </div>
                <div class="page-category">
                    <div class="card p-5">
                        <div class="table-responsive">
                            <table class="display table table-border table-hover" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>Name of Patient</th>
                                        <th>Date & Time</th>
                                        <th>Concern</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query_appointments = "SELECT appointments.user_id, appointments.user_id_patient, appointments.concern, appointments.appointment_date, appointments.appointment_time, appointments.parent_appointment_id, users.first_name, users.middle_name, users.last_name, appointments.confirmed, appointments.remarks
                                FROM appointments
                                LEFT JOIN users
                                ON appointments.user_id_patient = users.user_id
                                WHERE appointments.user_id = '$user_id'";
                                    $run_appointments = mysqli_query($conn, $query_appointments);
                                    if (mysqli_num_rows($run_appointments) > 0) {
                                        foreach ($run_appointments as $row_appointment) {
                                            ?>
                                            <tr>
                                                <td><?php echo $row_appointment['first_name'] . " " . $row_appointment['last_name'] ?>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <span><?php echo $row_appointment['appointment_date'] . " " . date("g:i A", strtotime($row_appointment['appointment_time'])) ?></span>
                                                        <?php if (!empty($row_appointment['parent_appointment_id'])): ?>
                                                            <div class="d-flex align-items-center mt-1 text-primary" style="font-size: 0.75rem; font-weight: 600;">
                                                                <i class="fas fa-level-up-alt fa-rotate-90 me-2" style="transform: scaleX(-1);"></i> Follow-up
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                                <td><?php echo $row_appointment['concern'] ?></td>
                                                <td>
                                                    <?php
                                                    // Status: 0=Confirmed, 1=Completed, 2=Cancelled, 3=No Show
                                                    $handler = match ($row_appointment['confirmed']) {
                                                        '0' => '<span class="badge text-dark text-body-secondary fw-bold" style="background: #94f7c9; border: #94f7c9;"><i class="fas fa-check-circle"></i> Confirmed</span>',
                                                        '1' => '<span class="badge text-white fw-bold" style="background: #1570e7; border: #1570e7;"><i class="fas fa-check"></i> Completed</span>',
                                                        '2' => '<span class="badge text-dark text-body-secondary fw-bold" style="background: #f79494; border: #f79494;"><i class="fas fa-times-circle"></i> Cancelled</span>',
                                                        '3' => '<span class="badge text-dark text-body-secondary fw-bold" style="background: #fab273; border: #fab273;"><i class="fas fa-times"></i> No Show</span>',
                                                        default => '<span class="badge text-dark text-body-secondary fw-bold" style="background: #fae373; border: #fae373;"><i class="fas fa-clock"></i> Pending</span>'
                                                    };
                                                    echo $handler;

                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="doctorRemarks" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Doctor Remarks</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="confirm.php" method="POST">
                        <div class="row">
                            <div class="col-lg-12 mb-5 mt-3">
                                <label for="">Remarks <small>(optional)</small></label>
                                <textarea class="form-control" name="remarks" id="comment" rows="5"></textarea>
                                <input type="hidden" id="appointment" name="appointment_date">
                                <input type="hidden" id="patient_id" name="user_id_patient">
                            </div>
                            <div class="col-lg-12 text-end">
                                <button type="button" class="btn btn-danger btn-md"
                                    data-bs-dismiss="modal">Close</button>
                                <input type="submit" class="btn btn-primary btn-md" name="accept" value="Confirm">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/scripts.php');
    ?>