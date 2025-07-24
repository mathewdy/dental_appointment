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
if(mysqli_num_rows($run_appointments) > 0){
    foreach($run_appointments as $row_appointment){
        $formattedDate = date("M d, Y", strtotime($row_appointment['appointment_date']));
        $formattedStartTime = date("H:i a", strtotime($row_appointment['start_time']));
        $formattedEndTime = date("H:i a", strtotime($row_appointment['end_time']));
        $status = match($row_appointment['confirmed']){
            '0' => '<span class="badge bg-warning">Pending</span>',
            '1' => '<span class="badge bg-success">Completed</span>',
            '2' => '<span class="badge bg-danger">Canceled</span>'
        };
        echo '
         <div class="row">
            <div class="col-lg-12">
                <p>Status: '. $status .'</p>
            </div>
            <div class="col-lg-6">
                <p>Date: '. $formattedDate . ' </p>
            </div>
            <div class="col-lg-6">
                <p>Time: '. $formattedStartTime .' - ' . $formattedEndTime . ' </p>
            </div>
            <div class="col-lg-6">
                <p>Patient: '. $row_appointment['patient_first_name'] . ' ' . $row_appointment['patient_last_name'] . '</p>
            </div>
            <div class="col-lg-6">
                <p>Dentist: Dr. '. $row_appointment['dentist_first_name'] . ' ' . $row_appointment['dentist_last_name'] . '</p>
            </div>
            <div class="col-lg-12">
                <p>Concern: '. $row_appointment['concern'] .'</p>
            </div>
        </div>
        <hr class="featurette-divider">
        ';
    }
}else{
    echo "Error: " . mysqli_error($conn);
}


?>