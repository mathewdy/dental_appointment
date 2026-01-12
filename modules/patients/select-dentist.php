<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/notification.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Appointments/appointments.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Users/dentists.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Users/patients.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Mailer/mail.php');


$first_name = $_SESSION['first_name'];
?>


<div class="wrapper">
    <?php include '../../includes/sidebar.php'; ?>
    <div class="main-panel">
        <?php include '../../includes/topbar.php'; ?>
        <div class="container">
            <div class="page-inner">
                <div class="page-header">
                    <div class="d-flex align-items-center gap-4 w-100">
                        <h4 class="page-title text-truncate">New Appointment</h4>
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
                                <a href="appointments.php"
                                    class="text-decoration-none text-truncate text-muted">Appointments</a>
                            </div>
                            <div class="separator">
                                <i class="icon-arrow-right fs-bold"></i>
                            </div>
                            <div class="nav-item">
                                <a href="#" class="text-decoration-none text-truncate text-muted">New Appointment</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-category">
                    <?php

                    if (isset($_GET['user_id_patient']) && isset($_GET['user_id_dentist'])) {
                        $user_id_patient = $_GET['user_id_patient'];
                        $user_id_dentist = $_GET['user_id_dentist'];

                        $run_dentist = getDentistById($conn, '3', $user_id_dentist);
                        $row_dentist = mysqli_fetch_assoc($run_dentist);

                        $run_patient = getPatientById($conn, $user_id_patient);
                        $row_patient = mysqli_fetch_assoc($run_patient);

                        // Get available days from new dentist_schedules table
                        $schedules = getDentistSchedules($conn, $user_id_dentist);
                        $available_days = array_keys($schedules);

                        $query_services = "SELECT * FROM services";
                        $run_services = mysqli_query($conn, $query_services);
                        ?>

                        <form action="set.php" method="POST">
                            <div class="row">
                                <div class="col-lg-12 mb-4">
                                    <div class="card p-4 shadow-none form-card rounded-1">
                                        <div class="card-header">
                                            <h3>Appointment Details</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="row gap-4">
                                                <div class="col-lg-12">
                                                    <div class="row d-flex align-items-center">
                                                        <div class="col-lg-2 col-12 mb-2 mb-lg-0">
                                                            <label for="">Doctor</label>
                                                        </div>
                                                        <div class="col-lg-10 col-12">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control"
                                                                    value="<?= 'Dr. ' . $row_dentist['first_name'] . " " . $row_dentist['last_name'] ?>"
                                                                    readonly>
                                                                <input type="hidden" name="dentist"
                                                                    value="<?= $row_dentist['user_id'] ?> " readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="row d-flex align-items-center">
                                                        <div class="col-lg-2 col-12 mb-2 mb-lg-0">
                                                            <label for="">Appointment Date</label>
                                                        </div>
                                                        <div class="col-lg-10 col-12">
                                                            <div class="input-group">
                                                                <input type="text" class="appointment_date form-control"
                                                                    name="appointment_date" required>
                                                                <input type="hidden" name="dentist"
                                                                    value="<?= $user_id_dentist ?>">
                                                                <input type="hidden" name="patient"
                                                                    value="<?= $user_id_patient ?>">
                                                                <?php
                                                                $offset = 5;
                                                                $values_patient = array_values($row_patient);
                                                                $field_value_patient = $values_patient[$offset];
                                                                ?>
                                                                <input type="hidden" name="email"
                                                                    value="<?= $field_value_patient ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="row d-flex align-items-center">
                                                        <div class="col-lg-2 col-12 mb-2 mb-lg-0">
                                                            <label for="">Set Time</label>
                                                        </div>
                                                        <div class="col-lg-10 col-12">
                                                            <select id="timeslot" class="form-control"
                                                                name="appointment_time" disabled>
                                                                <option value="">Select a time</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-lg-12">
                                                    <div class="row d-flex align-items-start">
                                                        <div class="col-lg-2 col-12 mb-2 mb-lg-0">
                                                            <label for="">Concern</label>
                                                        </div>
                                                        <div class="col-lg-10 col-12">
                                                            <p class="text-muted small mb-2">Select all applicable services:
                                                            </p>
                                                            <div class="row">
                                                                <?php
                                                                while ($row_services = mysqli_fetch_assoc($run_services)) {
                                                                    echo '<div class="col-12 col-sm-6 col-md-4 mb-2">';
                                                                    echo '<div class="form-check">';
                                                                    echo '<input class="form-check-input" type="checkbox" name="concerns[]" value="' . htmlspecialchars($row_services['name']) . '" id="service_' . $row_services['id'] . '">';
                                                                    echo '<label class="form-check-label" for="service_' . $row_services['id'] . '">' . htmlspecialchars($row_services['name']) . '</label>';
                                                                    echo '</div>';
                                                                    echo '</div>';
                                                                }
                                                                ?>
                                                            </div>
                                                            <div class="mt-2">
                                                                <input type="text" class="form-control" name="other_concern"
                                                                    placeholder="Other (specify)...">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 text-end">
                                    <a href="appointments.php" class="btn btn-sm btn-danger">Cancel</a>
                                    <input type="submit" class="btn btn-sm btn-primary" value="Save">
                                    <input type="hidden" name="save" value="1">
                                </div>
                            </div>
                        </form>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/scripts.php');

$available_days = json_encode($available_days);
echo "
    <script>
        var availableDays =  $available_days
    </script>
  ";
?>
<script>
    $(function () {
        const allDays = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        const availableIndexes = availableDays.map(day => allDays.indexOf(day));
        $(".appointment_date").datepicker({
            beforeShowDay: function (date) {
                var dayIndex = date.getDay();
                return [availableIndexes.includes(dayIndex)];
            },
            minDate: 0
        });
    });
</script>
<script>
    $(document).ready(function () {
        $(".appointment_date").on("keydown paste", function (e) {
            e.preventDefault();
        });
        $('form').on('submit', function (e) {
            const $btn = $('input[type="submit"]');
            $btn.prop('disabled', true).val('Submitting...');
            e.preventDefault();
            confirmBeforeSubmit($(this), "Do you want to add this appointment?", null, function () {
                $btn.prop('disabled', false).val('Submit');
            });
        });
    });
</script>
<script>
    $(".appointment_date").on("change", function () {
        const selectedDate = $(this).val();
        const dentistId = <?= $_GET['user_id_dentist'] ?>;

        if (!selectedDate) return;

        $("#timeslot").empty().append('<option>Loading...</option>');

        $.ajax({
            url: "get-available-time.php",
            method: "GET",
            data: {
                date: selectedDate,
                dentist_id: dentistId
            },
            success: function (response) {
                $("#timeslot").empty();

                if (response.timeslots.length > 0) {
                    $("#timeslot").prop("disabled", false);

                    response.timeslots.forEach(function (time) {
                        $("#timeslot").append(
                            `<option value="${time}">${time}</option>`
                        );
                    });
                    console.log(response)
                } else {
                    $("#timeslot").prop("disabled", true)
                        .append(`<option>No Available Times</option>`);
                    $('.submitBtn').prop("disabled", true)
                }
            }
        });
    });


</script>

<?php

// if(isset($_POST['save'])){
//     date_default_timezone_set("Asia/Manila");
//     $date = date('y-m-d');
//     $appointment_id = "2025".rand('1','10') . substr(str_shuffle(str_repeat("0123456789", 5)), 0, 3) ;

//     $user_id = $_GET['user_id'];
//     $user_id_patient = $_SESSION['user_id'];
//     $concern = $_POST['concern'];
//     $appointment_time = $_POST['appointment_time'];
//     $dentist = $_POST['dentist'];

//     $appointment_date  = $_POST['appointment_date'];

//     $current_date = date('Y-m-d');
//     if (strtotime($appointment_date) < strtotime($current_date)) {
//         echo "<script>alert('Cannot set appointments in the past.');</script>";
//         echo "<script>window.location.href='appointments.php';</script>";
//         exit();
//     }else{
//         $check_time_appointment = "SELECT appointment_time, appointment_date, user_id FROM appointments WHERE appointment_time = '$appointment_time' AND appointment_date = '$appointment_date' AND user_id = '$dentist'";
//     $run_appointment_time = mysqli_query($conn,$check_time_appointment);

//         if(mysqli_num_rows($run_appointment_time) > 0){
//             echo "<script>window.alert('Appointment time already booked')</script>";
//             echo "<script>window.location.href='appointments.php'</script>";
//         }else{
//             $check_appointment = "SELECT appointment_date , user_id_patient FROM appointments WHERE appointment_date =  '$appointment_date' AND user_id_patient =  '$user_id_patient'";
//             $run_check_appointment = mysqli_query($conn,$check_appointment);
//             if(mysqli_num_rows($run_check_appointment) > 0){
//                 echo "<script>window.alert('You already have an appointment')</script>";
//                 echo "<script>window.location.href='appointments.php'</script>";
//             }else{
//                 $query_appointment = "INSERT INTO appointments (user_id,user_id_patient,appointment_id,concern,confirmed,appointment_time,appointment_date,date_created,date_updated) 
//                                         VALUES ('$user_id','$user_id_patient','$appointment_id','$concern', '0','$appointment_time', '$appointment_date','$date', '$date')";
//                 $run_appointment = mysqli_query($conn,$query_appointment);
//                 $insert_notification ="INSERT INTO `notification` (user_id, `message`, hasRead, `type`, createdAt, createdBy)
//                                         VALUES ('$user_id', 'New Appointment Request', 0, 'Appointment', '$date', '$user_id_patient')";
//                 $run_notif = mysqli_query($conn, $insert_notification);
//                 if($run_appointment) {
//                     header("Location: appointments.php");
//                 }else{
//                     echo "<script>window.alert('Error')</script>";
//                     echo "<script>window.location.href='appointments.php'</script>";
//                 }
//             }
//         }
//     }

// }

?>