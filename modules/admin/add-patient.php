<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Users/users.php');

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
                        <h4 class="page-title text-truncate">Create Patient Account</h4>
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
                                <a href="#" class="text-decoration-none text-truncate text-muted">Create</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-category">
                    <form action="" method="POST">
                        <div class="row gap-2">
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
                                            <div class="col-lg-12">
                                                <div class="row d-flex align-items-center w-100">
                                                    <div class="col-lg-2">
                                                        <label for="">Address</label>
                                                    </div>
                                                    <div class="col-lg-10">
                                                        <input type="text" class="form-control" name="address">
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
                                                            <input type="password" class="form-control pw"
                                                                name="password" aria-describedby="basic-addon2" id="pw"
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
                            <div class="col-lg-12">
                                <div class="card p-4 shadow-none form-card rounded-1">
                                    <div class="card-header">
                                        <h3>Medical History</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row gap-4">
                                            <div class="col-lg-12">
                                                <div class="row d-flex align-items-start w-100">
                                                    <div class="col-lg-2">
                                                        <label for="">History</label>
                                                    </div>
                                                    <div class="col-lg-10">
                                                        <?php
                                                        $array_history = array("High Blood Pressure", "Diabetes", "Heart Disease", "Asthma", "Hepatitis", "Bleeding Disorder", "Tuberculosis");
                                                        foreach ($array_history as $history) {
                                                            ?>
                                                            <input class="form-check-input" type="checkbox" name="history[]"
                                                                value="<?php echo $history; ?>" id="flexCheckDefault">
                                                            <label class="form-check-label" for="flexCheckDefault">
                                                                <?php echo $history; ?>
                                                            </label>
                                                            <br>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="row d-flex align-items-start w-100">
                                                    <div class="col-lg-2">
                                                        <label for="">Medication & Allergies</label>
                                                    </div>
                                                    <div class="col-lg-10">
                                                        <div class="mb-3">
                                                            <label for="exampleFormControlInput1"
                                                                class="form-label">Current Medications</label>
                                                            <input type="text" name="current_medications"
                                                                class="form-control" id="exampleFormControlInput1"
                                                                placeholder="">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="exampleFormControlInput1"
                                                                class="form-label">Allergies(Drugs/Foods/Anesthesia)</label>
                                                            <input type="text" name="allergies" class="form-control"
                                                                id="exampleFormControlInput1" placeholder="">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="exampleFormControlInput1"
                                                                class="form-label">Past Surgeries /
                                                                Hospitalizations</label>
                                                            <input type="text" name="past_surgeries"
                                                                class="form-control" id="exampleFormControlInput1"
                                                                placeholder="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 text-end">
                            <a href="patients.php" class="btn btn-sm btn-danger">Cancel</a>
                            <input type="hidden" name="register_patient" value="1">
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
        $('form').on('submit', function (e) {
            e.preventDefault();
            confirmBeforeSubmit($(this), "Do you want to create this user?")
        });
        nameOnly('.text')
    });
</script>
<?php
if (isset($_POST['register_patient'])) {
    $user_id = date('Y') . rand('1', '10') . substr(str_shuffle(str_repeat("0123456789", 5)), 0, 3);
    $role_id = 1;
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $date_of_birth = date('Y-m-d', strtotime($_POST['date_of_birth']));
    $mobile_number = $_POST['mobile_number'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $new_password = password_hash($password, PASSWORD_DEFAULT);

    $history_string = isset($_POST['history']) && is_array($_POST['history'])
        ? implode(", ", $_POST['history'])
        : "";
    $current_medications = $_POST['current_medications'] ?? "";
    $allergies = $_POST['allergies'] ?? "";
    $past_surgeries = $_POST['past_surgeries'] ?? "";

    // 		$run_check_user = checkUser($conn, $email, $first_name, $middle_name, $last_name);
    $run_check_user = checkAllUserByEmail($conn, $email);
    if (mysqli_num_rows($run_check_user) > 0) {
        echo "<script> error('Email already exists.', () => window.location.href = 'patients.php') </script>";
    } else {
        $run_sql = createUser($conn, $user_id, $role_id, $first_name, $middle_name, $last_name, $mobile_number, $email, $new_password, $date_of_birth, $address);
        $sql_insert_history = "INSERT INTO medical_history (user_id, history, current_medications, allergies, past_surgeries,date_created,date_updated) VALUES ('$user_id', '$history_string', '$current_medications', '$allergies', '$past_surgeries','$date','$date')";
        $run_insert_history = mysqli_query($conn, $sql_insert_history);

        if ($run_sql) {
            echo "<script> success('Patient added successfully.', () => window.location.href = 'patients.php') </script>";
        } else {
            echo "<script> error('Something went wrong!', () => window.location.href = 'vpatients.php') </script>";
        }
    }
}
ob_end_flush();


?>