<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Users/users.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Users/dentists.php');

$first_name = $_SESSION['first_name']
    ?>
<div class="wrapper">
    <?php include '../../includes/sidebar.php'; ?>
    <div class="main-panel">
        <?php include '../../includes/topbar.php'; ?>
        <div class="container">
            <div class="page-inner">
                <div class="page-header">
                    <div class="d-flex align-items-center gap-4 w-100">
                        <h4 class="page-title text-truncate">Create Dentist Account</h4>
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
                                <a href="view-dentists.php"
                                    class="text-decoration-none text-truncate text-muted">Dentists</a>
                            </div>
                            <div class="separator">
                                <i class="icon-arrow-right fs-bold"></i>
                            </div>
                            <div class="nav-item">
                                <a href="#" class="text-decoration-none text-truncate text-muted">Create</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-category">
                    <form action="add-dentist.php" method="POST">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card p-4 shadow-none form-card rounded-1">
                                    <div class="card-header">
                                        <h3>Basic Information</h3>
                                    </div>
                                    <div class="card-body">

                                        <div class="row gap-4">
                                            <div class="col-lg-12">
                                                <div class="row d-flex align-items-center w-100">
                                                    <div class="col-lg-2">
                                                        <label for="first_name">First Name</label>
                                                    </div>
                                                    <div class="col-lg-10">
                                                        <?php
                                                        ini_set('display_errors', 1);
                                                        ini_set('display_startup_errors', 1);
                                                        error_reporting(E_ALL);
                                                        ?>
                                                        <input type="text" class="form-control text" name="first_name">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="row d-flex align-items-center w-100">
                                                    <div class="col-lg-2">
                                                        <label for="">Middle Name</label>
                                                    </div>
                                                    <div class="col-lg-10">
                                                        <input type="text" class="form-control text" name="middle_name">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="row d-flex align-items-center w-100">
                                                    <div class="col-lg-2">
                                                        <label for="">Last Name</label>
                                                    </div>
                                                    <div class="col-lg-10">
                                                        <input type="text" class="form-control text" name="last_name">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="row d-flex align-items-center w-100">
                                                    <div class="col-lg-2">
                                                        <label for="">Mobile Number </label>
                                                    </div>
                                                    <div class="col-lg-10">
                                                        <input type="tel" class="form-control" name="mobile_number"
                                                            placeholder="09XXXXXXXXX" pattern="^09[0-9]{9}$"
                                                            maxlength="11"
                                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="row d-flex align-items-center w-100">
                                                    <div class="col-lg-2">
                                                        <label for="">Date of Birth</label>
                                                    </div>
                                                    <div class="col-lg-10">
                                                        <input type="date" class="form-control" name="date_of_birth"
                                                            max="<?= date('Y-m-d') ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="card p-4 shadow-none form-card rounded-1">
                                    <div class="card-header">
                                        <h3>Schedule Information</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row gap-4">
                                            <div class="col-lg-12">
                                                <label class="mb-3 h6 fw-bold">Weekly Schedule</label>
                                                <p class="text-muted small mb-3">Check the days this dentist is
                                                    available and set the working hours.</p>

                                                <!-- Header Row -->
                                                <div class="row mb-2 align-items-center fw-bold text-muted small">
                                                    <div class="col-lg-2">Day</div>
                                                    <div class="col-lg-5">Start Time</div>
                                                    <div class="col-lg-5">End Time</div>
                                                </div>

                                                <?php
                                                $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                                foreach ($days as $day):
                                                    ?>
                                                    <div class="row mb-2 align-items-center">
                                                        <div class="col-lg-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input day-checkbox" type="checkbox"
                                                                    name="schedule[<?= $day ?>][active]" value="1"
                                                                    id="check_<?= $day ?>">
                                                                <label class="form-check-label" for="check_<?= $day ?>">
                                                                    <?= $day ?>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-5">
                                                            <select class="form-control time-input"
                                                                name="schedule[<?= $day ?>][start]"
                                                                disabled required>
                                                                <option value="">Select Start Time</option>
                                                                <?php
                                                                // Generate hourly options from 10:00 to 16:00 (4 PM start, ends by 5 PM)
                                                                for ($h = 10; $h <= 16; $h++) {
                                                                    $time_24 = sprintf('%02d:00', $h);
                                                                    $time_12 = date('g:i A', strtotime($time_24));
                                                                    echo "<option value=\"$time_24\">$time_12</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-5">
                                                            <select class="form-control time-input"
                                                                name="schedule[<?= $day ?>][end]"
                                                                disabled required>
                                                                <option value="">Select End Time</option>
                                                                <?php
                                                                // Generate hourly options from 11:00 to 17:00 (5 PM end)
                                                                for ($h = 11; $h <= 17; $h++) {
                                                                    $time_24 = sprintf('%02d:00', $h);
                                                                    $time_12 = date('g:i A', strtotime($time_24));
                                                                    echo "<option value=\"$time_24\">$time_12</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 mb-4">
                            <div class="card p-4 shadow-none form-card rounded-1">
                                <div class="card-header">
                                    <h3>Account</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row gap-4">
                                        <div class="col-lg-12">
                                            <div class="row d-flex align-items-center w-100">
                                                <div class="col-lg-2">
                                                    <label for="">Email</label>
                                                </div>
                                                <div class="col-lg-10">
                                                    <input type="email" class="form-control" name="email" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="row d-flex align-items-center w-100">
                                                <div class="col-lg-2">
                                                    <label for="">Password</label>
                                                </div>
                                                <div class="col-lg-10">
                                                    <div class="input-group mb-3">
                                                        <input type="password" class="form-control pw" name="password"
                                                            aria-describedby="basic-addon2" id="pw"
                                                            placeholder="•••••••" required>
                                                        <span class="input-group-text pw-toggle" id="basic-addon2"
                                                            style="cursor:pointer;" data-target="#pw"><i
                                                                class="fas fa-eye"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 text-end">
                            <a href="view-dentists.php" class="btn btn-sm btn-danger">Cancel</a>
                            <input type="hidden" name="add_dentist" value="1">
                            <input type="submit" class="btn btn-sm btn-primary" value="Create">
                        </div>
                </div>
                </form>
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
        // Toggle time inputs based on checkbox
        $('.day-checkbox').on('change', function () {
            const inputs = $(this).closest('.row').find('.time-input');
            inputs.prop('disabled', !this.checked);
            if (!this.checked) {
                inputs.val(''); // Clear values if unchecked
            }
        });

        // Validate time on change
        $(document).on('change', '.time-input', function() {
            const val = $(this).val();
            if (!val) return;

            const [hours, minutes] = val.split(':').map(Number);
            const timeInMinutes = hours * 60 + minutes;
            const minTime = 10 * 60; // 10:00 AM
            const maxTime = 17 * 60; // 5:00 PM

            if (timeInMinutes < minTime || timeInMinutes > maxTime) {
                error('Please select a time between 10:00 AM and 5:00 PM.', () => {
                    $(this).val(''); 
                });
            }
        });

        $('form').on('submit', function (e) {
            e.preventDefault();

            var scheduleSelected = $('.day-checkbox:checked').length > 0;
            if (!scheduleSelected) {
                error('Please select at least one working day with valid times.', () => { });
                return false;
            }
            // Optional: Add validation that start < end time for each selected day

            confirmBeforeSubmit($(this), "You\'ve made changes. Do you want to save them?", function () {
                return true;
            });
        });
        nameOnly('.text')
    });
</script>

<?php
if (isset($_POST['add_dentist'])) {
    $user_id = date('Y') . rand('1', '10') . substr(str_shuffle(str_repeat("0123456789", 5)), 0, 3);
    $role_id = 3;
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $date_of_birth = date('Y-m-d', strtotime($_POST['date_of_birth']));
    $mobile_number = $_POST['mobile_number'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $new_password = password_hash($password, PASSWORD_DEFAULT);
    $schedule_data = $_POST['schedule'];

    $run_check_user = checkAllUserByEmail($conn, $email);
    if (mysqli_num_rows($run_check_user) > 0) {
        echo "<script> error('Email already exists.', () => location.reload()) </script>";
    } else {
        $run_sql = createUser($conn, $user_id, $role_id, $first_name, $middle_name, $last_name, $mobile_number, $email, $new_password, $date_of_birth, '');
        $run_insert_Schedule = createDentistScheduleV2($conn, $user_id, $schedule_data);

        if ($run_sql && $run_insert_Schedule) {
            echo "<script> success('Dentist added successfully.', () => window.location.href = 'view-dentists.php') </script>";
        } else {
            echo "<script> error('Something went wrong!', () => window.location.href = 'view-dentists.php') </script>";
        }
    }
}
ob_end_flush();


?>