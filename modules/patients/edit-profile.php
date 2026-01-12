<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Users/users.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$first_name = $_SESSION['first_name'];
$email = $_SESSION['email'];
$roleId = $_SESSION['role_id'];
?>

<div class="wrapper">
    <?php include '../../includes/sidebar.php'; ?>
    <div class="main-panel">
        <?php include '../../includes/topbar.php'; ?>
        <div class="container">
            <div class="page-inner">
                <div class="page-header">
                    <div class="d-flex align-items-center gap-4">
                        <h4 class="page-title text-truncate">Edit Profile</h4>
                        <div class="d-flex align-items-center gap-2">
                            <div class="nav-home">
                                <a href="dashboard.php" class="text-decoration-none text-muted">
                                    <i class="icon-home"></i>
                                </a>
                            </div>
                            <div class="separator"><i class="icon-arrow-right fs-bold"></i></div>
                            <div class="nav-item">
                                <a href="my-profile.php"
                                    class="text-decoration-none text-truncate text-muted">Profile</a>
                            </div>
                            <div class="separator"><i class="icon-arrow-right fs-bold"></i></div>
                            <div class="nav-item">
                                <a href="#" class="text-decoration-none text-truncate text-muted">Edit Profile</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="page-category">
                    <?php
                    if (isset($_GET['user_id'])) {
                        $user_id = $_GET['user_id'];
                        $query = "
                            SELECT u.*, mh.history, mh.current_medications, mh.allergies, mh.past_surgeries
                            FROM users u
                            LEFT JOIN medical_history mh ON u.user_id = mh.user_id
                            WHERE u.user_id = ?
                        ";
                        $stmt = mysqli_prepare($conn, $query);
                        mysqli_stmt_bind_param($stmt, "i", $user_id);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);

                        if (mysqli_num_rows($result) > 0) {
                            $row_profile = mysqli_fetch_assoc($result);
                            $dob = date("Y-m-d", strtotime($row_profile['date_of_birth']));

                            // Prepare checked medical history
                            $checked_history = [];
                            if (!empty($row_profile['history'])) {
                                $checked_history = explode(',', $row_profile['history']);
                            }
                            ?>
                            <form action="update-profile.php" method="POST">
                                <div class="row">

                                    <!-- ========== PERSONAL INFORMATION ========== -->
                                    <div class="col-lg-12 mb-4">
                                        <div class="card p-4 shadow-none form-card rounded-1">
                                            <div class="card-header">
                                                <h3>Profile Information</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="row gap-4">
                                                    <div class="col-lg-12">
                                                        <div class="row d-flex align-items-center w-100">
                                                            <div class="col-lg-2"><label>First Name</label></div>
                                                            <div class="col-lg-10">
                                                                <input type="text" name="first_name" class="form-control text"
                                                                    value="<?= htmlspecialchars($row_profile['first_name']) ?>"
                                                                    required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="row d-flex align-items-center w-100">
                                                            <div class="col-lg-2"><label>Middle Name</label></div>
                                                            <div class="col-lg-10">
                                                                <input type="text" name="middle_name" class="form-control text"
                                                                    value="<?= htmlspecialchars($row_profile['middle_name']) ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="row d-flex align-items-center w-100">
                                                            <div class="col-lg-2"><label>Last Name</label></div>
                                                            <div class="col-lg-10">
                                                                <input type="text" name="last_name" class="form-control text"
                                                                    value="<?= htmlspecialchars($row_profile['last_name']) ?>"
                                                                    required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="row d-flex align-items-center w-100">
                                                            <div class="col-lg-2"><label>Mobile Number</label></div>
                                                            <div class="col-lg-10">
                                                                <input type="tel" class="form-control" name="mobile_number"
                                                                    placeholder="09XXXXXXXXX" pattern="^09[0-9]{9}$"
                                                                    maxlength="11"
                                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                                    value="<?= htmlspecialchars($row_profile['mobile_number']) ?>"
                                                                    required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="row d-flex align-items-center w-100">
                                                            <div class="col-lg-2"><label>Email</label></div>
                                                            <div class="col-lg-10">
                                                                <input type="email" name="email" class="form-control"
                                                                    value="<?= htmlspecialchars($row_profile['email']) ?>"
                                                                    required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="row d-flex align-items-center w-100">
                                                            <div class="col-lg-2"><label>Date of Birth</label></div>
                                                            <div class="col-lg-10">
                                                                <input type="date" class="form-control" name="birth_date"
                                                                    value="<?= $dob ?>" max="<?= date('Y-m-d') ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="row d-flex align-items-center w-100">
                                                            <div class="col-lg-2"><label>Address</label></div>
                                                            <div class="col-lg-10">
                                                                <input type="text" name="address" class="form-control"
                                                                    value="<?= htmlspecialchars($row_profile['address']) ?>"
                                                                    required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- ========== MEDICAL HISTORY SECTION ========== -->
                                    <div class="col-lg-12 mb-5">
                                        <div class="card p-4 shadow-none form-card rounded-1">
                                            <div class="card-header bg-light">
                                                <h4 class="mb-0">Medical History <small class="text-muted">(Optional)</small>
                                                </h4>
                                            </div>
                                            <div class="card-body">

                                                <!-- History Checkboxes -->
                                                <div class="mb-4">
                                                    <label class="form-label fw-bold">Known Conditions</label><br>
                                                    <?php
                                                    $array_history = ["High Blood Pressure", "Diabetes", "Heart Disease", "Asthma", "Hepatitis", "Bleeding Disorder", "Tuberculosis"];
                                                    foreach ($array_history as $history) {
                                                        $checked = in_array($history, $checked_history) ? 'checked' : '';
                                                        $safe_id = str_replace(' ', '_', $history);
                                                        ?>
                                                        <div class="form-check form-check-inline me-4 mb-2">
                                                            <input class="form-check-input" type="checkbox" name="history[]"
                                                                value="<?= htmlspecialchars($history) ?>"
                                                                id="history_<?= $safe_id ?>" <?= $checked ?>>
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
                                                    <input type="text" name="current_medications" class="form-control"
                                                        value="<?= htmlspecialchars($row_profile['current_medications'] ?? '') ?>"
                                                        placeholder="e.g. Losartan 50mg once daily">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Allergies (Drugs/Foods/Anesthesia)</label>
                                                    <input type="text" name="allergies" class="form-control"
                                                        value="<?= htmlspecialchars($row_profile['allergies'] ?? '') ?>"
                                                        placeholder="e.g. Penicillin, Shellfish">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Past Surgeries / Hospitalizations</label>
                                                    <input type="text" name="past_surgeries" class="form-control"
                                                        value="<?= htmlspecialchars($row_profile['past_surgeries'] ?? '') ?>"
                                                        placeholder="e.g. Appendectomy 2019">
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 text-end">
                                        <a href="my-profile.php" class="btn btn-sm btn-danger">Cancel</a>
                                        <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                        <input type="hidden" name="update_profile" value="1">
                                        <button type="submit" class="btn btn-sm btn-primary">Save Changes</button>
                                    </div>

                                </div>
                            </form>
                            <?php
                        } else {
                            echo "<div class='alert alert-danger'>User not found.</div>";
                        }
                    } else {
                        echo "<div class='alert alert-warning'>No user ID provided.</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/scripts.php'); ?>
<script>
    $(document).ready(function () {
        nameOnly('.text')
    })
</script>