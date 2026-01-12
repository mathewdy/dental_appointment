<?php
session_start();
require_once('../../connection/connection.php');
require_once('event-clause.php');
require_once('event-builder.php');

$id = $_SESSION['user_id'];
$role = $_SESSION['role_id'];

$clickedDate = $_POST['date'] ?? null;
$formattedClickedDate = date("m/d/Y", strtotime($clickedDate));

$query = queryEventInfoBuilder($role, $id, $formattedClickedDate);

$run_appointments = mysqli_query($conn, $query);
if (mysqli_num_rows($run_appointments) > 0) {
    foreach ($run_appointments as $row_appointment) {
        $formattedDate = date("M d, Y", strtotime($row_appointment['appointment_date']));
        $formattedStartTime = date("h:i a", strtotime($row_appointment['appointment_time']));
        $formattedEndTime = date("h:i a", strtotime($row_appointment['appointment_time'] . "+ 1 hour"));
        $status = match ($row_appointment['confirmed']) {
            '0' => '<span class="badge bg-success">Confirmed</span>',
            '1' => '<span class="badge" style="background-color: #1570e7 !important;">Completed</span>',
            '2' => '<span class="badge bg-danger">Cancelled</span>',
            '3' => '<span class="badge bg-warning">No Show</span>',
            default => '<span class="badge bg-secondary">Pending</span>'
        };
        echo '
         <div class="row">
            <div class="col-lg-12">
                <p>Status: ' . $status;
        if (!empty($row_appointment['parent_appointment_id'])) {
            echo ' <span class="ms-2 text-primary" style="font-size: 0.9em; font-weight: 600;"><i class="fas fa-level-up-alt fa-rotate-90 me-1" style="transform: scaleX(-1);"></i> Follow-up</span>';
        }
        echo '</p>
            </div>
            <div class="col-lg-6">
                <p>Date: ' . $formattedDate . ' </p>
            </div>
            <div class="col-lg-6">
                <p>Time: ' . $formattedStartTime . ' - ' . $formattedEndTime . ' </p>
            </div>
            <div class="col-lg-6">
                <p>Patient: ' . $row_appointment['patient_first_name'] . ' ' . $row_appointment['patient_last_name'] . '</p>
            </div>
            <div class="col-lg-6">
                <p>Dentist: Dr. ' . $row_appointment['dentist_first_name'] . ' ' . $row_appointment['dentist_last_name'] . '</p>
            </div>
            <div class="col-lg-12">
                <p>Concern: ' . $row_appointment['concern'] . '</p>
            </div>
        </div>
        <hr class="featurette-divider">
        ';
    }
} else {
    ?>
    <div class="d-flex justify-content-center align-items-center gap-4 py-5">
        <div class="row text-center">
            <div class="col-lg-12">
                <h1 class="display-1">
                    <i class="fas fa-box-open text-info"></i>
                </h1>
            </div>
            <div class="col-lg-12">
                <div class="w-100">
                    <p class="h4 p-0 m-0 text-dark">
                        No Appointment Record
                    </p>
                    <p class="p-0 m-0">There is currently no appointment schedule on this date.</p>
                </div>
            </div>
        </div>
    </div>
    <?php
}


?>