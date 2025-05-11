<?php 
session_start();
require_once('../../connection/connection.php');

$userId = $_SESSION['user_id'];

$clickedDate = $_POST['date'] ?? null;
$formattedClickedDate = date("m/d/Y", strtotime($clickedDate));

$html = '';

$query_appointments = "SELECT appointments.user_id, appointments.user_id_patient, appointments.concern, appointments.appointment_date, users.first_name, users.middle_name, users.last_name, schedule.start_time, schedule.end_time, appointments.confirmed
FROM appointments
LEFT JOIN users
ON appointments.user_id = users.user_id
LEFT JOIN schedule 
ON appointments.user_id = schedule.user_id 
WHERE appointments.appointment_date = '$formattedClickedDate'";
$run_appointments = mysqli_query($conn,$query_appointments);
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

        $html .= '
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
            <div class="col-lg-12">
                <p>Dentist: Dr. '. $row_appointment['first_name'] . ' ' . $row_appointment['last_name'] . '</p>
            </div>
            <div class="col-lg-12">
                <p>Concern: '. $row_appointment['concern'] .'</p>
            </div>
        </div>
        ';
        echo $html;
    }
}else{
    echo "Error";
}


?>