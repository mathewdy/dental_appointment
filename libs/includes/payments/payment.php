<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/connection/connection.php');

if (isset($_POST['id']) && is_numeric($_POST['id'])) {
  $id  = $_POST['id'];

  $query = "SELECT
    appointments.user_id_patient,
    appointments.appointment_id AS id,
    appointments.concern,
    appointments.date_created,
    appointments.confirmed,
    payments.payment_id,
    payments.appointment_id,
    payments.initial_balance, 
    payments.remaining_balance, 
    payments.is_deducted
    FROM appointments 
    LEFT JOIN payments 
    ON appointments.appointment_id = payments.appointment_id
    WHERE appointments.appointment_id = '$id'
  ";
  $run = mysqli_query($conn, $query);

  if(mysqli_num_rows($run) > 0){
    foreach($run as $row){
    ?>
    <div class="col-lg-12">
      <label for="">Set new balance:</label>
      <input type="number" class="form-control" name="remaining_balance">
      <input type="hidden" class="form-control" name="concern" value="<?= $row['concern']?>">
      <input type="hidden" class="form-control" name="user_id" value="<?= $row['user_id_patient']?>">
      <input type="hidden" class="form-control" name="appointment_id" value="<?= $row['id'] ?>">
    </div>
    <?php
    }
  }
}

?>