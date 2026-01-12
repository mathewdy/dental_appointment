<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Users/patients.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Appointments/appointments.php');

$first_name = $_SESSION['first_name'];
$id = $_SESSION['user_id'];

date_default_timezone_set('Asia/Manila');

// 1. Fetch Stats
// $sql_total = "SELECT COUNT(*) AS total_appointments FROM appointments WHERE user_id_patient = '$id'";
// $row_total = mysqli_fetch_assoc(mysqli_query($conn, $sql_total));

// Completed (confirmed = 1)
$sql_completed = "SELECT COUNT(*) AS total_completed FROM appointments WHERE user_id_patient = '$id' AND confirmed = 1";
$row_completed = mysqli_fetch_assoc(mysqli_query($conn, $sql_completed));

// Status codes: 0=Confirmed, 1=Completed, 2=Cancelled, 3=No Show
$sql_confirmed = "SELECT COUNT(*) AS total_confirmed FROM appointments WHERE user_id_patient = '$id' AND confirmed = 0";
$row_confirmed = mysqli_fetch_assoc(mysqli_query($conn, $sql_confirmed));

$sql_cancelled = "SELECT COUNT(*) AS total_cancelled FROM appointments WHERE user_id_patient = '$id' AND confirmed = 2";
$row_cancelled = mysqli_fetch_assoc(mysqli_query($conn, $sql_cancelled));

$sql_walkin = "SELECT COUNT(*) AS total_walkin FROM appointments WHERE user_id_patient = '$id' AND walk_in = 1";
$row_walkin = mysqli_fetch_assoc(mysqli_query($conn, $sql_walkin));

// 2. Fetch Patient Details
$res_patient = getPatientDetails($conn, $id);
$patient_info = mysqli_fetch_assoc($res_patient);

// 3. Fetch Next Appointment
$res_next = getUpcomingConfirmedAppointments($conn, $id);
// Note: Do not close $conn here - it's needed by includes (sidebar, topbar, scripts)
?>

<div class="wrapper">
    <?php include '../../includes/sidebar.php'; ?>
    <div class="main-panel">
        <?php include '../../includes/topbar.php'; ?>
        <div class="container">
            <div class="page-inner">

                <div class="row g-4 justify-content-center">
                    <!-- Left Column: Patient Profile (4 cols) -->
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                            <div class="card-body p-0">
                                <div class="bg-primary p-4 text-center text-white bg-gradient">
                                    <div class="avatar avatar-xxl mb-3">
                                        <span
                                            class="avatar-title rounded-circle bg-white text-primary fw-bold fs-1 shadow-sm">
                                            <?= strtoupper(substr($patient_info['first_name'], 0, 1) . substr($patient_info['last_name'], 0, 1)) ?>
                                        </span>
                                    </div>
                                    <h4 class="fw-bold mb-1">
                                        <?= htmlspecialchars($patient_info['first_name'] . ' ' . $patient_info['last_name']) ?>
                                    </h4>
                                    <p class="mb-0 text-white-50 small"><?= htmlspecialchars($patient_info['email']) ?>
                                    </p>
                                </div>

                                <div class="p-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="me-3 text-center" style="width: 24px;">
                                            <i class="fas fa-id-card text-muted"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block text-uppercase"
                                                style="font-size: 0.7rem;">Patient ID</small>
                                            <span
                                                class="text-dark fw-medium">#<?= str_pad($id, 4, '0', STR_PAD_LEFT) ?></span>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center mb-3">
                                        <div class="me-3 text-center" style="width: 24px;">
                                            <i class="fas fa-phone text-muted"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block text-uppercase"
                                                style="font-size: 0.7rem;">Phone</small>
                                            <span
                                                class="text-dark fw-medium"><?= htmlspecialchars($patient_info['mobile_number'] ?? '-') ?></span>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-start mb-4">
                                        <div class="me-3 text-center mt-1" style="width: 24px;">
                                            <i class="fas fa-map-marker-alt text-muted"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block text-uppercase"
                                                style="font-size: 0.7rem;">Address</small>
                                            <span
                                                class="text-dark fw-medium"><?= htmlspecialchars($patient_info['address'] ?? '-') ?></span>
                                        </div>
                                    </div>

                                    <div class="d-grid gap-2">
                                        <a href="history.php" class="btn btn-primary rounded-pill py-2 shadow-sm">
                                            View History
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Stats & Next Appointment (8 cols) -->
                    <div class="col-lg-8">

                        <!-- Next Appointment -->
                        <!-- Calendar View -->
                        <?php 
                        $events = [];
                        if (mysqli_num_rows($res_next) > 0) {
                            foreach ($res_next as $appt) {
                                $events[] = [
                                    'title' => $appt['concern'] . ' w/ Dr. ' . $appt['doctor_last'],
                                    'start' => $appt['appointment_date'] . 'T' . $appt['appointment_time'],
                                    'color' => '#1570e7', // Blue for confirmed
                                    'allDay' => false
                                ];
                            }
                        }
                        ?>
                        <div class="card border-0 shadow rounded-4 mb-4 overflow-hidden">
                            <div class="card-body p-4">
                                <h3 class="fw-bold text-dark mb-3">Appointments Calendar</h3>
                                <div id="calendar" style="max-height: 500px;"></div>
                            </div>
                        </div>

                        <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var calendarEl = document.getElementById('calendar');
                            var calendar = new FullCalendar.Calendar(calendarEl, {
                                initialView: 'listMonth', // Compact list view as default? Or dayGridMonth. User said "calendar view".
                                headerToolbar: {
                                    left: 'prev,next',
                                    center: 'title',
                                    right: 'dayGridMonth,listMonth' // removed dayGridWeek/dayGridDay for compactness
                                },
                                height: 450, // Compact height
                                events: <?= json_encode($events) ?>,
                                eventTimeFormat: { 
                                    hour: 'numeric',
                                    minute: '2-digit',
                                    meridiem: 'short'
                                },
                                views: {
                                    dayGridMonth: {
                                        titleFormat: { year: 'numeric', month: 'short' } // Compact title 'Jan 2026'
                                    }
                                }
                            });
                            calendar.render();
                        });
                        </script>

                        <!-- Stats Overview -->
                        <h5 class="fw-bold text-dark mb-3">Overview</h5>
                        <div class="row g-3">
                            <!-- Completed -->
                            <div class="col-6 col-md-3">
                                <div class="card border-0 shadow-sm rounded-4 text-center h-100 py-3">
                                    <div class="card-body p-2">
                                        <div class="fs-3 mb-2" style="color: #1570e7;">
                                            <i class="fas fa-check"></i>
                                        </div>
                                        <h4 class="fw-bold mb-0 text-dark"><?= $row_completed['total_completed'] ?></h4>
                                        <small class="text-muted">Completed</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Confirmed -->
                            <div class="col-6 col-md-3">
                                <div class="card border-0 shadow-sm rounded-4 text-center h-100 py-3">
                                    <div class="card-body p-2">
                                        <div class="text-success fs-3 mb-2">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <h4 class="fw-bold mb-0 text-dark"><?= $row_confirmed['total_confirmed'] ?></h4>
                                        <small class="text-muted">Confirmed</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Walk-ins -->
                            <div class="col-6 col-md-3">
                                <div class="card border-0 shadow-sm rounded-4 text-center h-100 py-3">
                                    <div class="card-body p-2">
                                        <div class="text-warning fs-3 mb-2">
                                            <i class="fas fa-walking"></i>
                                        </div>
                                        <h4 class="fw-bold mb-0 text-dark"><?= $row_walkin['total_walkin'] ?></h4>
                                        <small class="text-muted">Walk-ins</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Cancelled -->
                            <div class="col-6 col-md-3">
                                <div class="card border-0 shadow-sm rounded-4 text-center h-100 py-3">
                                    <div class="card-body p-2">
                                        <div class="text-danger fs-3 mb-2">
                                            <i class="fas fa-ban"></i>
                                        </div>
                                        <h4 class="fw-bold mb-0 text-dark"><?= $row_cancelled['total_cancelled'] ?></h4>
                                        <small class="text-muted">Cancelled</small>
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
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/scripts.php');
?>