<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Appointments/appointments.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Payments/payments.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$first_name = $_SESSION['first_name'];
$user_id_patients = $_SESSION['user_id'];
?>

<div class="wrapper">
    <?php include '../../includes/sidebar.php'; ?>
    <div class="main-panel">
        <?php include '../../includes/topbar.php'; ?>
        <div class="container">
            <div class="page-inner">
                <div class="page-header">
                    <div class="d-flex align-items-center gap-4">
                        <h4 class="page-title text-truncate">History</h4>
                        <div class="d-flex align-items-center gap-2">
                            <div class="nav-home">
                                <a href="dashboard.php" class="text-decoration-none text-muted">
                                    <i class="icon-home"></i>
                                </a>
                            </div>
                            <div class="separator">
                                <i class="icon-arrow-right fs-bold"></i>
                            </div>
                            <div class="nav-item">
                                <a href="#" class="text-decoration-none text-truncate text-muted">History</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-category">
                    <div class="card p-5">
                        <div class="table-responsive">
                            <table class="display table table-striped table-hover" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>Appointment Date & Time</th>
                                        <th>Dentist</th>
                                        <th>Concern</th>
                                        <th>Status</th>
                                        <th>Payment History</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $run_appointments = getAllRequestHistoryById($conn, $user_id_patients);
                                    if (mysqli_num_rows($run_appointments) > 0) {
                                        foreach ($run_appointments as $row_appointment) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <span><?= date("M d, Y h:i A", strtotime($row_appointment['appointment_date'] . " " . $row_appointment['appointment_time'])) ?></span>
                                                        <?php if (!empty($row_appointment['parent_appointment_id'])): ?>
                                                            <div class="d-flex align-items-center mt-1 text-primary" style="font-size: 0.75rem; font-weight: 600;">
                                                                <i class="fas fa-level-up-alt fa-rotate-90 me-2" style="transform: scaleX(-1);"></i> Follow-up
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                                <td>Dr.
                                                    <?php echo $row_appointment['doctor_first_name'] . " " . $row_appointment['doctor_last_name'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $row_appointment['concern'] ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    // Status: 0=Confirmed, 1=Completed, 2=Cancelled, 3=No Show
                                                    $handler = match ($row_appointment['confirmed']) {
                                                        0 => '<span class="badge text-dark text-body-secondary fw-bold" style="background: #94f7c9; border: #94f7c9;"><i class="fas fa-check-circle"></i> Confirmed</span>',
                                                        1 => '<span class="badge text-white fw-bold" style="background: #1570e7; border: #1570e7;"><i class="fas fa-check"></i> Completed</span>',
                                                        2 => '<span class="badge text-dark text-body-secondary fw-bold" style="background: #f79494; border: #f79494;"><i class="fas fa-times-circle"></i> Cancelled</span>',
                                                        3 => '<span class="badge text-dark text-body-secondary fw-bold" style="background: #fab273; border: #fab273;"><i class="fas fa-times"></i> No Show</span>',
                                                        default => '<span class="badge text-dark text-body-secondary fw-bold" style="background: #fae373; border: #fae373;"><i class="fas fa-clock"></i> Pending</span>'
                                                    };
                                                    echo $handler;
                                                    ?>
                                                </td>
                                                <td class="text-center">
                                                    <a class="payment-history" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#paymentHistoryDialog"
                                                        data-appointment="<?= $row_appointment['appointment_id'] ?>">
                                                        View
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <?php
                                                    // Show Book Follow-Up for Completed appointments (status=1)
                                                    if ($row_appointment['confirmed'] == 1) {
                                                        // Check payment status for display
                                                        $payment_check = getPaymentByAppointmentId($conn, $row_appointment['appointment_id']);
                                                        $remaining = 0;
                                                        if ($payment_check && mysqli_num_rows($payment_check) > 0) {
                                                            $payment_row = mysqli_fetch_assoc($payment_check);
                                                            $remaining = floatval($payment_row['remaining_balance']);
                                                        }
                                                        $has_active_followup = checkExistingFollowUp($conn, $row_appointment['appointment_id']);
                                                        
                                                        if ($has_active_followup) {
                                                            ?>
                                                            <button class="btn btn-sm btn-secondary text-nowrap" disabled title="You already have a pending follow-up">
                                                                <i class="fas fa-clock me-1"></i> Follow-Up Pending
                                                            </button>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <a href="#" class="btn btn-sm btn-primary text-nowrap book-followup"
                                                                data-bs-toggle="modal" data-bs-target="#followUpModal"
                                                                data-appointment-id="<?= $row_appointment['appointment_id'] ?>"
                                                                data-concern="<?= htmlspecialchars($row_appointment['concern']) ?>"
                                                                data-dentist-id="<?= $row_appointment['doctor_id'] ?>"
                                                                data-dentist-name="Dr. <?= htmlspecialchars($row_appointment['doctor_first_name'] . ' ' . $row_appointment['doctor_last_name']) ?>">
                                                                <i class="fas fa-calendar-plus me-1"></i> Follow-Up
                                                            </a>
                                                            <?php
                                                        }
                                                    } else {
                                                        echo '-';
                                                    }
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
</div>

<div class="modal fade" id="paymentHistoryDialog" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Payment History</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="payment-list table-responsive"></div>
            </div>
        </div>
    </div>
</div>

<!-- Follow-Up Appointment Modal -->
<div class="modal fade" id="followUpModal" tabindex="-1" aria-labelledby="followUpModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="followUpModalLabel">
                    <i class="fas fa-calendar-plus me-2"></i>Book Follow-Up Appointment
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="book-followup.php" method="POST">
                <div class="modal-body">
                    <div class="alert alert-info small">
                        <i class="fas fa-info-circle me-1"></i>
                        This follow-up will be linked to your existing treatment. No new invoice will be created.
                    </div>
                    
                    <input type="hidden" name="parent_appointment_id" id="followup_parent_id">
                    <input type="hidden" name="concern" id="followup_concern">
                    <input type="hidden" name="dentist_id" id="followup_dentist_id">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Treatment</label>
                        <p class="form-control-plaintext" id="display_concern"></p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Dentist</label>
                        <p class="form-control-plaintext" id="display_dentist"></p>
                    </div>
                    
                    <div class="mb-3">
                        <label for="followup_date" class="form-label fw-bold">Appointment Date</label>
                        <input type="date" class="form-control" name="appointment_date" id="followup_date" required
                            min="<?= date('Y-m-d', strtotime('+1 day')) ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label for="followup_time" class="form-label fw-bold">Preferred Time</label>
                        <select class="form-select" name="appointment_time" id="followup_time" required>
                            <option value="">Select a date first...</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" name="book_followup">
                        <i class="fas fa-check me-1"></i>Confirm Follow-Up
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/scripts.php');
?>
<script>
    $(document).ready(function () {
        // Payment History Modal
        $('.payment-history').on('click', function () {
            var appointment_id = $(this).data('appointment');
            $('#paymentHistoryDialog .payment-list').html('<div class="text-center py-3"><i class="fas fa-spinner fa-spin"></i> Loading...</div>');

            $.ajax({
                url: 'get_payment_history.php',
                method: 'POST',
                data: { appointment_id: appointment_id },
                success: function (response) {
                    $('#paymentHistoryDialog .payment-list').html(response);
                },
                error: function () {
                    $('#paymentHistoryDialog .payment-list').html('<div class="alert alert-danger">Failed to load history.</div>');
                }
            });
        });

        // Follow-Up Modal - populate data
        $('.book-followup').on('click', function () {
            var appointmentId = $(this).data('appointment-id');
            var concern = $(this).data('concern');
            var dentistId = $(this).data('dentist-id');
            var dentistName = $(this).data('dentist-name');

            $('#followup_parent_id').val(appointmentId);
            $('#followup_concern').val(concern);
            $('#followup_dentist_id').val(dentistId);
            $('#display_concern').text(concern);
            $('#display_dentist').text(dentistName);
            
            // Reset time dropdown
            $('#followup_time').html('<option value="">Select a date first...</option>');
        });

        // Load available times when date changes
        $('#followup_date').on('change', function() {
            var date = $(this).val();
            var dentistId = $('#followup_dentist_id').val();
            
            if (date && dentistId) {
                $('#followup_time').html('<option value="">Loading...</option>');
                
                $.ajax({
                    url: 'get-available-time.php',
                    method: 'GET',
                    data: { date: date, dentist_id: dentistId },
                    success: function(response) {
                        // Response is JSON: { timeslots: ["10:00 AM", ...], Booked: [...] }
                        // Or matches other PHP file structure
                        
                        var options = '<option value="">Select Time</option>';
                        
                        if (response.timeslots && response.timeslots.length > 0) {
                            response.timeslots.forEach(function(time) {
                                options += '<option value="' + time + '">' + time + '</option>';
                            });
                        } else {
                            options = '<option value="">No available slots</option>';
                        }
                        
                        $('#followup_time').html(options);
                    },
                    error: function() {
                        $('#followup_time').html('<option value="">Error loading times</option>');
                    }
                });
            }
        });
    });
</script>