<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Users/users.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Users/patients.php');
$first_name = $_SESSION['$first_name'];
// Debug mode - comment out for production
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$user_id = $_GET['user_id'] ?? 0;
$result = getPatientById($conn, $user_id);
$row_profile = mysqli_fetch_assoc($result);
?>
<div class="wrapper">
    <?php include '../../includes/sidebar.php'; ?>
    <div class="main-panel">
        <?php include '../../includes/topbar.php'; ?>
        <div class="container">
            <div class="page-inner">
                <div class="page-header">
                    <div class="d-flex align-items-center gap-4">
                        <h4 class="page-title text-truncate">Medical History</h4>
                        <div class="d-flex align-items-center gap-2">
                            <div class="nav-home">
                                <a href="dashboard.php" class="text-decoration-none text-muted">
                                    <i class="icon-home"></i>
                                </a>
                            </div>
                            <div class="separator"><i class="icon-arrow-right fs-bold"></i></div>
                            <div class="nav-item">
                                <a href="patients.php" class="text-decoration-none text-truncate text-muted">Patients</a>
                            </div>
                            <div class="separator"><i class="icon-arrow-right fs-bold"></i></div>
                            <div class="nav-item">
                                <a href="#" class="text-decoration-none text-truncate text-muted"><?= $row_profile['first_name'] . ' ' . $row_profile['last_name'];?></a>
                            </div>
                            <div class="separator"><i class="icon-arrow-right fs-bold"></i></div>
                            <div class="nav-item">
                                <a href="#" class="text-decoration-none text-truncate text-muted">Medical History</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="page-category">
                    <?php
                    if (isset($_GET['user_id'])) {
                        $user_id = $_GET['user_id'];

                        $query = "
                            SELECT mh.*
                            FROM medical_history mh
                            WHERE mh.user_id = ?
                        ";
                        $stmt = mysqli_prepare($conn, $query);
                        mysqli_stmt_bind_param($stmt, "i", $user_id);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        $row_history = mysqli_fetch_assoc($result);

                        $checked_history = [];
                        if (!empty($row_history['history'])) {
                            $checked_history = explode(',', $row_history['history']);
                        }
                        ?>

                        <div class="card p-4 shadow-none form-card rounded-1">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">Medical History</h4>
                                <button id="editBtn" class="btn btn-sm btn-primary">Edit</button>
                            </div>
                            <div class="card-body">
                                <form id="medicalHistoryForm" action="update-medical-history.php" method="POST">
                                    <!-- Known Conditions -->
                                    <div class="mb-4">
                                        <label class="form-label fw-bold">Known Conditions</label><br>
                                        <?php
                                        $array_history = ["High Blood Pressure", "Diabetes", "Heart Disease", "Asthma", "Hepatitis", "Bleeding Disorder", "Tuberculosis"];
                                        foreach ($array_history as $history) {
                                            $checked = in_array($history, $checked_history) ? 'checked' : '';
                                            $safe_id = str_replace(' ', '_', $history);
                                            ?>
                                            <div class="form-check form-check-inline me-4 mb-2">
                                                <input class="form-check-input history-checkbox" type="checkbox" name="history[]" value="<?= htmlspecialchars($history) ?>"
                                                       id="history_<?= $safe_id ?>" <?= $checked ?> disabled>
                                                <label class="form-check-label" for="history_<?= $safe_id ?>">
                                                    <?= htmlspecialchars($history) ?>
                                                </label>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>

 
                                    <div class="mb-3">
                                        <label class="form-label">Current Medications</label>
                                        <input type="text" name="current_medications" class="form-control" value="<?= htmlspecialchars($row_history['current_medications'] ?? '') ?>" disabled>
                                    </div>

  
                                    <div class="mb-3">
                                        <label class="form-label">Allergies (Drugs/Foods/Anesthesia)</label>
                                        <input type="text" name="allergies" class="form-control" value="<?= htmlspecialchars($row_history['allergies'] ?? '') ?>" disabled>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Past Surgeries / Hospitalizations</label>
                                        <input type="text" name="past_surgeries" class="form-control" value="<?= htmlspecialchars($row_history['past_surgeries'] ?? '') ?>" disabled>
                                    </div>

                                    <div class="text-end mt-3">
                                        <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                        <input type="hidden" name="update_medical_history" value="1">
                                        <button type="submit" id="saveBtn" class="btn btn-sm btn-primary" style="display: none;">Save Changes</button>
                                        <button type="button" id="cancelEditBtn" class="btn btn-sm btn-danger" style="display: none;">Cancel Editing</button>
                                    </div>


                                </form>
                            </div>
                        </div>

                        <?php
                    } else {
                        echo "<div class='alert alert-warning'>No user ID provided.</div>";
                    }
                    ?>
                     <div class="mt-3 text-end">
                        <a href="patients.php" class="btn btn-sm btn-primary">Back to Patients</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/scripts.php'); ?>
<script>
   $(document).ready(function() {
        $('#editBtn').click(function(e) {
            e.preventDefault();
            $('#medicalHistoryForm').find('input').prop('disabled', false);
            $('#saveBtn, #cancelEditBtn').show();
            $(this).hide();
        });
    
        $('#cancelEditBtn').click(function() {
            $('#medicalHistoryForm').find('input').prop('disabled', true);
            $('#saveBtn, #cancelEditBtn').hide();
            $('#editBtn').show();
            $('#medicalHistoryForm')[0].reset();
        });
    });

</script>
