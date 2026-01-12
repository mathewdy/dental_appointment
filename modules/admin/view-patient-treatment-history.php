<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Appointments/appointments.php');

// Debug mode - comment out for production
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$first_name = $_SESSION['first_name'];
$user_id_patients = $_GET['user_id'] ?? 0;
?>

<div class="wrapper">
    <?php include '../../includes/sidebar.php'; ?>
    <div class="main-panel">
        <?php include '../../includes/topbar.php'; ?>
        <div class="container">
            <div class="page-inner">
                <div class="page-header">
                    <div class="d-flex align-items-center gap-4 w-100">
                        <h4 class="page-title text-truncate">Treatment History</h4>
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
                                <a href="patients.php"
                                    class="text-decoration-none text-truncate text-muted">Patients</a>
                            </div>
                            <div class="separator">
                                <i class="icon-arrow-right fs-bold"></i>
                            </div>
                            <div class="nav-item">
                                <a href="#" class="text-decoration-none text-truncate text-muted">Treatment History</a>
                            </div>
                        </div>
                        <a href="dental-chart.php?user_id=<?= $user_id_patients ?>" class="btn btn-sm btn-dark op-7">
                            <i class="fas fa-tooth me-1"></i>Dental Chart
                        </a>
                    </div>
                </div>

                <div class="page-category">
                    <div class="card p-4">
                        <div class="table-responsive">
                            <table class="display table table-striped table-hover" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>Treatment</th>
                                        <th>Doctor</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($user_id_patients) {
                                        // Appointments (confirmed = 1 = Completed in new workflow)
                                        $query_history = "
                                            SELECT 
                                                a.concern,
                                                a.parent_appointment_id,
                                                CONCAT(d.first_name, ' ', d.last_name) AS doctor_name,
                                                a.appointment_date
                                            FROM appointments a
                                            LEFT JOIN users d ON a.user_id = d.user_id
                                            WHERE a.user_id_patient = '$user_id_patients'
                                            AND a.confirmed = 1
                                            ORDER BY a.appointment_date DESC, a.appointment_time DESC
                                        ";
                                        $run_history = mysqli_query($conn, $query_history);

                                        if (mysqli_num_rows($run_history) > 0) {
                                            foreach ($run_history as $row) {
                                                ?>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex flex-column">
                                                            <span><?php echo htmlspecialchars($row['concern']); ?></span>
                                                            <?php if (!empty($row['parent_appointment_id'])): ?>
                                                                <div class="d-flex align-items-center mt-1 text-primary" style="font-size: 0.75rem; font-weight: 600;">
                                                                    <i class="fas fa-level-up-alt fa-rotate-90 me-2" style="transform: scaleX(-1);"></i> Follow-up
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($row['doctor_name']); ?></td>
                                                    <td><?php echo $row['appointment_date']; ?></td>
                                                </tr>
                                                <?php
                                            }
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

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/scripts.php');
?>
<script>
    $(document).ready(function () {
        if ($.fn.DataTable.isDataTable('#dataTable')) {
            $('#dataTable').DataTable().destroy();
        }
        $('#dataTable').DataTable({
            order: [[2, 'desc']]
        });
    });
</script>