<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/security.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$first_name = $_SESSION['first_name'];

if (isset($_GET['payment_id']) && isset($_GET['user_id']) && isset($_GET['service'])) {
    $user_id = $_GET['user_id'];
    $concern = $_GET['service'];
    $payment_id = $_GET['payment_id'];

    // Use prepared statement for payment - only use payment_id as it's the unique key
    $stmt_payment = $conn->prepare("SELECT * FROM payments WHERE payment_id = ?");
    $stmt_payment->bind_param("s", $payment_id);
    $stmt_payment->execute();
    $result_payment = $stmt_payment->get_result();

    if ($result_payment->num_rows > 0) {
        $row_payment = $result_payment->fetch_assoc();
        
        // Fetch patient details securely
        $stmt_patient = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt_patient->bind_param("s", $user_id);
        $stmt_patient->execute();
        $result_patient = $stmt_patient->get_result();
        $row_patient_name = $result_patient->fetch_assoc();
        ?>
        <div class="wrapper">
            <?php include '../../includes/sidebar.php'; ?>

            <div class="main-panel">
                <?php include '../../includes/topbar.php'; ?>
                <div class="container">
                    <div class="page-inner">
                        <div class="page-header">
                            <div class="d-flex align-items-center gap-4 w-100">
                                <h4 class="page-title text-truncate">Payments</h4>
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
                                        <a href="#" class="text-decoration-none text-truncate text-muted">Payments</a>
                                    </div>
                                    <div class="separator">
                                        <i class="icon-arrow-right fs-bold"></i>
                                    </div>
                                    <div class="nav-item">
                                        <a href="view-patient-payments.php?user_id=<?= htmlspecialchars($user_id) ?>&concern=<?= urlencode($concern) ?>"
                                            class="text-decoration-none text-truncate text-muted">View</a>
                                    </div>
                                    <div class="separator">
                                        <i class="icon-arrow-right fs-bold"></i>
                                    </div>
                                    <div class="nav-item">
                                        <a href="#" class="text-decoration-none text-truncate text-muted">New Payment</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="page-category">
                            <div class="row">
                                <div class="col-lg-12 mb-4">
                                    <?php
                                    if ($row_patient_name) {
                                        ?>
                                        <span>
                                            <label for="">Patient Name:</label>
                                            <h1 class="m-0 p-0">
                                                <?= htmlspecialchars($row_patient_name['first_name'] . " " . $row_patient_name['last_name']) ?>
                                            </h1>
                                        </span>
                                        <?php
                                    }
                                    ?>
                                    <form action="new-payment.php" method="POST">
                                        <div class="card p-4 shadow-none form-card rounded-1">
                                            <div class="card-header">
                                                <h3>Make a payment</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="row gap-4">
                                                    <div class="col-lg-12">
                                                        <div class="row d-flex align-items-center w-100">
                                                            <div class="col-lg-2">
                                                                <label for="">Remaining Balance</label>
                                                            </div>
                                                            <div class="col-lg-10">
                                                                <input type="text" class="form-control remainingBalance"
                                                                    name="remaining_balance"
                                                                    value="<?= htmlspecialchars($row_payment['remaining_balance']) ?>"
                                                                    readonly>
                                                                <input type="hidden" name="email"
                                                                    value="<?= htmlspecialchars($row_patient_name['email'] ?? '') ?>" readonly>
                                                                <input type="hidden" name="user_id"
                                                                    value="<?= htmlspecialchars($_GET['user_id']) ?>" readonly>
                                                                <input type="hidden" name="payment_id"
                                                                    value="<?= htmlspecialchars($_GET['payment_id']) ?>" readonly>
                                                                <input type="hidden" name="service"
                                                                    value="<?= htmlspecialchars($_GET['service']) ?>" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="row d-flex align-items-center w-100">
                                                                <div class="col-lg-2">
                                                                    <label for="">Add Payment</label>
                                                                </div>
                                                                <div class="col-lg-10">
                                                                    <input type="number" class="form-control payment" name="payment"
                                                                        required>
                                                                    <span class="err_message small"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="row d-flex align-items-center w-100">
                                                                <div class="col-lg-2">
                                                                    <label for="">Session Label</label>
                                                                </div>
                                                                <div class="col-lg-10">
                                                                    <input type="text" class="form-control" name="session_label"
                                                                        placeholder="e.g., Session 1, Adjustment Visit, Initial Payment">
                                                                    <small class="text-muted">Optional: Label for this payment
                                                                        (e.g., for braces sessions)</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="row d-flex align-items-center w-100">
                                                                <div class="col-lg-2">
                                                                    <label for="">Payment Method</label>
                                                                </div>
                                                                <div class="col-lg-10">
                                                                    <select name="payment_method" id="" class="form-control"
                                                                        required>
                                                                        <option value="">-Select-</option>
                                                                        <option value="Cash">Cash</option>
                                                                        <option value="GCash">GCash</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 text-end">
                                                            <a href="view-patient-payments.php?user_id=<?php echo $user_id ?>&concern=<?php echo $concern ?>"
                                                                class="btn btn-sm btn-danger">Cancel</a>
                                                            <?php
                                                            if ($row_payment['remaining_balance'] <= 0) {
                                                                ?>
                                                                <input type="submit" class="btn btn-sm btn-primary disabled"
                                                                    name="add_payment" value="Confirm">

                                                                <!-- <input type="submit" class="btn btn-sm btn-primary disabled" name="add_payment" value="Add Cash Payment">
                                                  <input type="submit" class="btn btn-sm btn-success disabled" name="add_payment_paymogo" value="Add Paymogo Payment"> -->
                                                                <?php
                                                            } else {
                                                                ?>

                                                                <input type="submit" class="btn btn-sm btn-primary" name="add_payment"
                                                                    value="Confirm">
                                                                <!-- <input type="submit" class="btn btn-sm btn-primary" name="add_payment" value="Add Cash Payment"> -->
                                                                <!-- <input type="submit" class="btn btn-sm btn-success" name="add_payment_paymogo" value="Add Paymogo Payment"> -->
                                                                <!-- <input type="submit" class="btn btn-sm btn-primary" name="add_payment_gcash" value="Add GCash Payment"> -->
                                                                <?php
                                                            }
                                                            ?>

                                                        </div>
                                        </form>

                                        <?php
    }
}
?>
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
<script>
    $(document).ready(function () {
        $('.payment').on('keyup', function () {
            const remaining = parseFloat($('.remainingBalance').val()) || 0;
            const payment = parseFloat($(this).val()) || 0;

            if (payment > remaining || payment < 0) {
                $(".payment").css('border', '1px solid red');
                $("input[name='add_payment']").attr('disabled', true);
                $(".err_message")
                    .html('Invalid value')
                    .css('color', 'red');
            } else {
                $(".payment").css('border', '1px solid #ced4da');
                $("input[name='add_payment']").attr('disabled', false);
                $(".err_message")
                    .html('')
                    .css('color', '');
            }
        });
    });

</script>