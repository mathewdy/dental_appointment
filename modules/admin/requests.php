<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Appointments/appointments.php');

$first_name = $_SESSION['first_name'];
$user_id_patient = $_SESSION['user_id'];
?>
<style>
    .dataTable_wrapper input {
        padding: 20px 12px !important;
    }
</style>
<div class="wrapper">
    <?php include '../../includes/sidebar.php'; ?>
    <div class="main-panel">
        <?php include '../../includes/topbar.php'; ?>
        <div class="container">
            <div class="page-inner">
                <div class="page-header">
                    <div class="d-flex align-items-center gap-4 w-100">
                        <h4 class="page-title text-truncate">Appointments Requests</h4>
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
                                <a href="#" class="text-decoration-none text-truncate text-muted">Requests</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-category">
                    <div class="card p-5">
                        <div class="table-responsive">
                            <table class="display table table-border table-hover" id="dataTable">
                                <thead>
                                    <tr>
                                        <th class="text-truncate">Name of Patient</th>
                                        <th>Date & Time</th>
                                        <th>Doctor</th>
                                        <th>Concern</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $run_appointments = getAllRequests($conn);
                                    if (mysqli_num_rows($run_appointments) > 0) {
                                        foreach ($run_appointments as $row_appointment) {
                                            $time = $row_appointment['appointment_time'];
                                            $start = date("h:i A", strtotime($time));
                                            $end = date("h:i A", strtotime($time . "+ 1 hour"));
                                            ?>
                                            <tr>
                                                <td class="text-truncate">
                                                    <?php echo $row_appointment['patient_first_name'] . " " . $row_appointment['patient_last_name'] ?>
                                                </td>
                                                <td class="text-truncate">
                                                    <div class="d-flex flex-column">
                                                        <span><?php echo $row_appointment['appointment_date'] . " " . $start . ' - ' . $end ?></span>
                                                        <?php if (!empty($row_appointment['parent_appointment_id'])): ?>
                                                            <div class="d-flex align-items-center mt-1 text-primary" style="font-size: 0.75rem; font-weight: 600;">
                                                                <i class="fas fa-level-up-alt fa-rotate-90 me-2" style="transform: scaleX(-1);"></i> Follow-up
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                                <td class="text-truncate">Dr.
                                                    <?php echo $row_appointment['doctor_first_name'] . " " . $row_appointment['doctor_last_name'] ?>
                                                </td>
                                                <?php
                                                // Check if editable (Status 0=Confirmed is editable, others are not)
                                                // Actually, pending (default) should probably also be editable? 
                                                // User specified: cancelled, no show, completed -> disabled.
                                                // Status codes: 0=Confirmed, 1=Completed, 2=Cancelled, 3=No Show
                                                // Pending usually implies no status set yet (maybe NULL or other?). 
                                                // Assuming editable unless 1, 2, or 3.
                                                $is_final = in_array($row_appointment['confirmed'], ['1', '2', '3']);
                                                $cell_class = !$is_final ? 'concern-cell' : '';
                                                $cell_style = !$is_final ? 'cursor: pointer; max-width: 200px;' : 'max-width: 200px;';
                                                $concern_val = htmlspecialchars($row_appointment['concern']);
                                                $cell_attrs = !$is_final ? 'data-appointment-id="' . $row_appointment['appointment_id'] . '" data-concern="' . $concern_val . '" title="' . $concern_val . ' - Click to edit"' : '';
                                                
                                                $displayConcern = strlen($row_appointment['concern']) > 30 ? substr($row_appointment['concern'], 0, 30) . '...' : $row_appointment['concern'];
                                                ?>
                                                <td class="<?php echo $cell_class; ?>" style="<?php echo $cell_style; ?>" <?php echo $cell_attrs; ?>>
                                                    <?php if (!$is_final): ?>
                                                        <span class="text-primary"><i class="fas fa-edit me-1"></i><?php echo htmlspecialchars($displayConcern); ?></span>
                                                    <?php else: ?>
                                                        <span><?php echo htmlspecialchars($displayConcern); ?></span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-truncate">
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
                                                <td>
                                                    <div class="d-flex justify-content-start align-items-center">
                                                        <?php
                                                        $status = $row_appointment['confirmed'];
                                                        // 0: Confirmed, 1: Completed, 2: Cancelled, 3: No Show
                                                        // Actionable only when status=0 (Confirmed)
                                                        if ($status == 0) {
                                                            ?>
                                                            <div class="dropdown">
                                                                <button class="btn btn-sm btn-primary rounded dropdown-toggle"
                                                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    Update Status
                                                                </button>
                                                                <ul class="dropdown-menu" style="width: 20rem;">
                                                                    <li class="px-3">
                                                                        <p class="h6 fw-bold">
                                                                            Update Appointment Status
                                                                        </p>
                                                                    </li>
                                                                    <li>
                                                                        <hr class="dropdown-divider">
                                                                    </li>

                                                                    <?php if ($status == 0): ?>
                                                                        <li>
                                                                            <a class="dropdown-item status"
                                                                                href="request-action.php?id=<?= $row_appointment['appointment_id'] ?>&status=1">
                                                                                <div class="d-flex align-items-center">
                                                                                    <i
                                                                                        class="fas fa-lg fa-check-circle me-3 text-primary"></i>
                                                                                    <div>
                                                                                        <p class="h6 fw-bold p-0 m-0 text-primary">
                                                                                            Procedure Completed</p>
                                                                                        <p class="lh-1 text-muted p-0 m-0">Mark as
                                                                                            completed</p>
                                                                                    </div>
                                                                                </div>
                                                                            </a>
                                                                        </li>
                                                                    <?php endif; ?>

                                                                    <!-- Status 1 (Completed) is a final state, no further actions needed -->

                                                                    <li>
                                                                        <a class="dropdown-item status"
                                                                            href="request-action.php?id=<?= $row_appointment['appointment_id'] ?>&status=2">
                                                                            <div class="d-flex align-items-center">
                                                                                <i
                                                                                    class="fas fa-lg fa-times-circle me-3 text-danger"></i>
                                                                                <div>
                                                                                    <p class="h6 fw-bold p-0 m-0 text-danger">Cancel
                                                                                        Appointment</p>
                                                                                    <p class="lh-1 text-muted p-0 m-0">Mark as
                                                                                        cancelled</p>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item status"
                                                                            href="request-action.php?id=<?= $row_appointment['appointment_id'] ?>&status=3">
                                                                            <div class="d-flex align-items-center">
                                                                                <i
                                                                                    class="fas fa-lg fa-calendar me-3 text-warning"></i>
                                                                                <div>
                                                                                    <p class="h6 fw-bold p-0 m-0 text-warning">Mark
                                                                                        No Show</p>
                                                                                    <p class="lh-1 text-muted p-0 m-0">Patient did
                                                                                        not show up</p>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <button class="btn btn-sm btn-primary rounded dropdown-toggle disabled"
                                                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                Update Status
                                                            </button>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        echo "No Data";
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
    <?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/scripts.php');
    ?>
    <script>
        document.querySelectorAll('.dropdown-toggle').forEach(el => {
            new bootstrap.Dropdown(el, {
                popperConfig: {
                    strategy: 'fixed',
                    modifiers: [
                        {
                            name: 'preventOverflow',
                            options: { boundary: document.body }
                        }
                    ]
                }
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('.status').on('click', function (e) {
                e.preventDefault();
                confirmBeforeRedirect("Do you want to update this appointment?", $(this).attr('href'))
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            var table = $('#dataTable').DataTable();
            var customFilter = `
    <div class="customFilterCol">
      <select id="statusFilter" class="form-control form-control-sm d-inline-block w-auto">
        <option value="">All</option>
        <option value="Confirmed">Confirmed</option>
        <option value="Completed">Completed</option>
        <option value="Cancelled">Cancelled</option>
        <option value="No Show">No Show</option>
      </select>
    </div>
  `;
            var topRow = $('.dataTables_wrapper .row .col-sm-12.col-md-6').last();
            topRow.addClass('d-flex flex-column flex-lg-row justify-content-end align-items-center gap-2');

            var wrapper = $('.dataTables_filter');
            wrapper.last().after(customFilter);

            $('#statusFilter').on('change', function () {
                var val = $(this).val();
                table
                    .column(4)
                    .search(val ? val : '', true, false)
                    .draw();
            });
        });

        // Concern cell click handler
        $('.concern-cell').on('click', function () {
            var appointmentId = $(this).data('appointment-id');
            var currentConcern = $(this).data('concern') || '';

            $('#concernAppointmentId').val(appointmentId);

            // Parse current concerns and check matching checkboxes
            var concerns = currentConcern.split(',').map(c => c.trim().toLowerCase());
            $('.concern-checkbox').each(function () {
                var label = $(this).next('label').text().trim().toLowerCase();
                if (concerns.includes(label)) {
                    $(this).prop('checked', true);
                } else {
                    $(this).prop('checked', false);
                }
            });

            $('#concernModal').modal('show');
        });

    </script>

    <!-- Concern Edit Modal -->
    <div class="modal fade" id="concernModal" tabindex="-1" aria-labelledby="concernModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="concernModalLabel">Edit Concern / Services</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="concern_appointment_id" id="concernAppointmentId">
                        <p class="text-muted small mb-3">Select all applicable services/concerns:</p>
                        <div class="row">
                            <?php
                            $query_services = "SELECT * FROM services";
                            $run_services = mysqli_query($conn, $query_services);
                            if ($run_services && mysqli_num_rows($run_services) > 0) {
                                while ($service = mysqli_fetch_assoc($run_services)) {
                                    ?>
                                    <div class="col-12 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input concern-checkbox" type="checkbox" name="concerns[]"
                                                value="<?php echo htmlspecialchars($service['name']); ?>"
                                                id="service_<?php echo $service['id']; ?>">
                                            <label class="form-check-label" for="service_<?php echo $service['id']; ?>">
                                                <?php echo htmlspecialchars($service['name']); ?>
                                            </label>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <div class="mt-3">
                            <label class="form-label">Other (custom):</label>
                            <input type="text" class="form-control" name="other_concern"
                                placeholder="Additional concern...">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="update_concern" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
    if (isset($_POST['update_status'])) {
        $appointment_id = $_POST['appointment_id'];

        $run_query = updateStatus($conn, $appointment_id);
        if ($run_query) {
            echo "<script> success('Updated successfully.', () => window.location.href = 'requests.php') </script>";
        } else {
            echo "<script> error('Something went wrong!', () => window.location.href = 'requests.php') </script>";
        }
    }

    // Handle concern update
    if (isset($_POST['update_concern'])) {
        $appointment_id = $_POST['concern_appointment_id'];
        $concerns = isset($_POST['concerns']) ? $_POST['concerns'] : [];
        $other = trim($_POST['other_concern'] ?? '');

        if (!empty($other)) {
            $concerns[] = $other;
        }

        $concern_str = implode(', ', $concerns);

        $sql = "UPDATE appointments SET concern = ? WHERE appointment_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $concern_str, $appointment_id);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script> success('Concern updated successfully.', () => window.location.href = 'requests.php') </script>";
        } else {
            echo "<script> error('Failed to update concern.', () => window.location.href = 'requests.php') </script>";
        }
    }

    ?>