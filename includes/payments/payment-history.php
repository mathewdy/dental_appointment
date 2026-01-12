<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/connection/connection.php');


$id = $_SESSION['user_id'];

if (isset($_POST['id']) && is_numeric($_POST['id']) || isset($_POST['appointment'])) {
  $payment_id = $_POST['id'] ??  null;
  $appointmentId = $_POST['appointment'] ?? null;

  $checkClause = $payment_id != null ?  "payment_history.payment_id = '$payment_id'" : "payments.appointment_id = '$appointmentId'";
  
  $query = "SELECT 
    payment_history.id, 
    payment_history.payment_id,
    payment_history.payment_received,
    payment_history.payment_method,
    payment_history.remaining_balance,
    payment_history.date_created,
    payment_history.date_updated, 
    payments.payment_id,
    payments.appointment_id,
    payments.initial_balance
    FROM payment_history 
    LEFT JOIN payments
    ON payment_history.payment_id = payments.payment_id
    WHERE " . $checkClause . " ORDER BY id DESC";
    $run = mysqli_query($conn, $query);

    if (mysqli_num_rows($run) > 0) {
    echo '
    <table class="table table-striped table-bordered w-100">
      <thead>
          <tr>
              <th>Received</th>
              <th>Remaining Balance</th>
              <th>Method</th>
              <th>Date Created</th>
          </tr>
      </thead>
      <tbody>
    ';

    while ($row = mysqli_fetch_assoc($run)) {
        echo "
        <tr>
            <td>₱{$row['payment_received']}</td>
            <td>₱{$row['remaining_balance']}</td>
            <td>{$row['payment_method']}</td>
            <td>{$row['date_created']}</td>
        </tr>";
    }
    echo '</tbody></table>';

  }else{
    ?>
    <div class="d-flex justify-content-center align-items-center gap-4 py-5">
      <div class="row text-center">
        <div class="col-lg-12">
          <h1 class="display-1">
            <i class="fas fa-box-open text-info"></i>
          </h1>
        </div>
        <div class="col-lg-12">
          <div class="w-100">
            <p class="h4 p-0 m-0 text-dark">
              No Payment History Available
            </p>
            <p class="p-0 m-0">There is currently no payment data associated with this user.</p>
          </div>
        </div>
      </div>
    </div>
    <?php
  }
}

?>