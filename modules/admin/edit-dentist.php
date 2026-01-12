<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Users/users.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Users/dentists.php');

$first_name = $_SESSION['first_name'];
?>
<div class="wrapper">
    <?php
    include '../../includes/sidebar.php';
    ?>
    <div class="main-panel">
        <?php
        include '../../includes/topbar.php';
        ?>
        <div class="container">
            <div class="page-inner">
                <div class="page-header">
                    <div class="d-flex align-items-center gap-4 w-100">
                        <h4 class="page-title text-truncate">Edit Dentist Account</h4>
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
                                <a href="#" class="text-decoration-none text-truncate text-muted">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-category">
                    <?php
                    if (isset($_GET['user_id'])) {
                        $user_id = $_GET['user_id'];
                        $run_dentist = getDentistById($conn, '3', $user_id);
                        if (mysqli_num_rows($run_dentist) > 0) {
                            foreach ($run_dentist as $row_dentist) {
                                ?>
                                <form action="" method="POST">
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
                                                                    <input type="text" class="form-control text" name="first_name"
                                                                        value="<?= $row_dentist['first_name'] ?>" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="row d-flex align-items-center w-100">
                                                                <div class="col-lg-2">
                                                                    <label for="">Middle Name</label>
                                                                </div>
                                                                <div class="col-lg-10">
                                                                    <input type="text" class="form-control text" name="middle_name"
                                                                        value="<?= $row_dentist['middle_name'] ?>" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="row d-flex align-items-center w-100">
                                                                <div class="col-lg-2">
                                                                    <label for="">Last Name</label>
                                                                </div>
                                                                <div class="col-lg-10">
                                                                    <input type="text" class="form-control text" name="last_name"
                                                                        value="<?= $row_dentist['last_name'] ?>" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="row d-flex align-items-center w-100">
                                                                <div class="col-lg-2">
                                                                    <label for="">Email</label>
                                                                </div>
                                                                <div class="col-lg-10">
                                                                    <input type="email" class="form-control text" name="email"
                                                                        value="<?= $row_dentist['email'] ?>" required>
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
                                                            $s_schedules = getDentistSchedules($conn, $user_id);
                                                            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                                            foreach ($days as $day):
                                                                $day_data = $s_schedules[$day] ?? null;
                                                                $checked = $day_data ? 'checked' : '';
                                                                $start_val = $day_data ? $day_data['start_time'] : '';
                                                                $end_val = $day_data ? $day_data['end_time'] : '';
                                                                $disabled = $day_data ? '' : 'disabled';
                                                                ?>
                                                                <div class="row mb-2 align-items-center">
                                                                    <div class="col-lg-2">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input day-checkbox" type="checkbox"
                                                                                name="schedule[<?= $day ?>][active]" value="1"
                                                                                id="check_<?= $day ?>" <?= $checked ?>>
                                                                            <label class="form-check-label" for="check_<?= $day ?>">
                                                                                <?= $day ?>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-5">
                                                                        <select class="form-control time-input"
                                                                            name="schedule[<?= $day ?>][start]"
                                                                            <?= $disabled ?> required>
                                                                            <option value="">Select Start Time</option>
                                                                            <?php
                                                                            // Generate hourly options from 10:00 to 16:00 (4 PM start, ends by 5 PM)
                                                                            for ($h = 10; $h <= 16; $h++) {
                                                                                $time_24 = sprintf('%02d:00', $h);
                                                                                $time_12 = date('g:i A', strtotime($time_24));
                                                                                $selected = ($start_val == $time_24) ? 'selected' : '';
                                                                                echo "<option value=\"$time_24\" $selected>$time_12</option>";
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-lg-5">
                                                                        <select class="form-control time-input"
                                                                            name="schedule[<?= $day ?>][end]"
                                                                            <?= $disabled ?> required>
                                                                            <option value="">Select End Time</option>
                                                                            <?php
                                                                            // Generate hourly options from 11:00 to 17:00 (5 PM end)
                                                                            for ($h = 11; $h <= 17; $h++) {
                                                                                $time_24 = sprintf('%02d:00', $h);
                                                                                $time_12 = date('g:i A', strtotime($time_24));
                                                                                $selected = ($end_val == $time_24) ? 'selected' : '';
                                                                                echo "<option value=\"$time_24\" $selected>$time_12</option>";
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
                                        <div class="col-lg-12 text-end">
                                            <a href="view-dentists.php" class="btn btn-sm btn-danger">Cancel</a>
                                            <input type="hidden" name="update_dentist" value="1">
                                            <input type="submit" class="btn btn-sm btn-primary" value="Save">
                                        </div>
                                    </div>
                                </form>
                                <?php
                            }
                        }
                    }
                    ?>
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

        // No additional validation needed - select dropdowns only contain valid times

        $('form').on('submit', function (e) {
            e.preventDefault();

            var scheduleSelected = $('.day-checkbox:checked').length > 0;
            if (!scheduleSelected) {
                error('Please select at least one working day.', () => { });
                return false;
            }
            confirmBeforeSubmit($(this), "You\'ve made changes. Do you want to save them?", function () {
                return true;
            });
        });
        nameOnly('.text')
    });
</script>
<?php

if (isset($_POST['update_dentist'])) {
    $user_id = $_GET['user_id'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $schedule_data = $_POST['schedule'];

    $check_email = checkAllUserByEmail($conn, $email);
    $is_duplicate = false;
    if (mysqli_num_rows($check_email) > 0) {
        foreach ($check_email as $row) {
            if ($row['user_id'] != $user_id) {
                $is_duplicate = true;
                break;
            }
        }
    }

    if ($is_duplicate) {
        echo "<script> error('Email already exists.', () => window.location.href = 'view-dentists.php') </script>";
    } else {
        $run_update = updateDentist($conn, $first_name, $middle_name, $last_name, $email, $user_id);
    // Perform update on schedule
    $run_update_schedule = updateDentistScheduleV2($conn, $user_id, $schedule_data);

    if ($run_update && $run_update_schedule) {
        echo "<script> success('User updated successfully.', () => window.location.href = 'view-dentists.php') </script>";
    } else {
        echo "<script> error('Something went wrong!', () => window.location.href = 'view-dentists.php') </script>";
    }

    }

}
?>