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
                            <div class="separator">
                                <i class="icon-arrow-right fs-bold"></i>
                            </div>
                            <div class="nav-item">
                                <a href="my-profile.php"
                                    class="text-decoration-none text-truncate text-muted">Profile</a>
                            </div>
                            <div class="separator">
                                <i class="icon-arrow-right fs-bold"></i>
                            </div>
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
                        $run_profile = getProfile($conn, $user_id, $roleId);
                        if (mysqli_num_rows($run_profile) > 0) {
                            foreach ($run_profile as $row_profile) {
                                $dob = date("Y-m-d", strtotime($row_profile['date_of_birth']));
                                ?>
                                <form action="update-profile.php" method="POST">
                                    <div class="row">
                                        <div class="col-lg-12 mb-4">
                                            <div class="card p-4 shadow-none form-card rounded-1">
                                                <div class="card-header">
                                                    <h3>Profile Information</h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row gap-4">
                                                        <div class="col-lg-12">
                                                            <div class="row d-flex align-items-center w-100">
                                                                <div class="col-lg-2">
                                                                    <label for="">First Name</label>
                                                                </div>
                                                                <div class="col-lg-10">
                                                                    <input type="text" name="first_name" class="form-control text"
                                                                        value="<?php echo $row_profile['first_name'] ?>" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="row d-flex align-items-center w-100">
                                                                <div class="col-lg-2">
                                                                    <label for="">Middle Name</label>
                                                                </div>
                                                                <div class="col-lg-10">
                                                                    <input type="text" name="middle_name" class="form-control text"
                                                                        value="<?php echo $row_profile['middle_name'] ?>" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="row d-flex align-items-center w-100">
                                                                <div class="col-lg-2">
                                                                    <label for="">Last Name</label>
                                                                </div>
                                                                <div class="col-lg-10">
                                                                    <input type="text" name="last_name" class="form-control text"
                                                                        value="<?php echo $row_profile['last_name'] ?>" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="row d-flex align-items-center w-100">
                                                                <div class="col-lg-2">
                                                                    <label for="">Mobile Number</label>
                                                                </div>
                                                                <div class="col-lg-10">
                                                                    <div class="input-group mb-3">
                                                                        <input type="tel" class="form-control" name="mobile_number"
                                                                            placeholder="09XXXXXXXXX" pattern="^09[0-9]{9}$"
                                                                            maxlength="11"
                                                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                                            value="<?= htmlspecialchars($row_profile['mobile_number']) ?>"
                                                                            required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="row d-flex align-items-center w-100">
                                                                <div class="col-lg-2">
                                                                    <label for="">Email</label>
                                                                </div>
                                                                <div class="col-lg-10">
                                                                    <div class="input-group mb-3">
                                                                        <input type="email" name="email" class="form-control"
                                                                            value="<?php echo $row_profile['email'] ?>" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="row d-flex align-items-center w-100">
                                                                <div class="col-lg-2">
                                                                    <label for="">Date of Birth</label>
                                                                </div>
                                                                <div class="col-lg-10">
                                                                    <div class="input-group mb-3">
                                                                        <input type="date" class="form-control" value="<?= $dob ?>"
                                                                            name="birth_date" max="<?= date('Y-m-d') ?>" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 text-end">
                                            <a href="my-profile.php" class="btn btn-sm btn-danger">Cancel</a>
                                            <input type="submit" class="btn btn-sm btn-primary" value="Save">
                                            <input type="hidden" name="update_profile" value="1">
                                            <input type="hidden" name="user_id" value="<?= $user_id ?>">
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
        $('form').on('submit', function (e) {
            const $btn = $('input[type="submit"]');
            $btn.prop('disabled', true).val('Submitting...');
            e.preventDefault();
            confirmBeforeSubmit($(this), "Do you want to save your changes?")
        });
        lettersOnly('.text')
    });
</script>