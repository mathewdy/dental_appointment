<?php
session_start();
require_once('../../connection/connection.php');

if (isset($_POST['id']) && is_numeric($_POST['id'])) {
  $user_id = $_POST['id'];
  $concern = $_POST['concern'];

  $query = "SELECT 
												payments.id, 
												payments.user_id AS payment_user_id,
												payments.payment_id,
												payments.initial_balance, 
												payments.remaining_balance,
												payments.is_deducted,
												users.user_id AS user_id,
												users.first_name,
												users.last_name,
                        appointments.appointment_id,
												appointments.user_id_patient,
                        appointments.concern,
												appointments.confirmed
										FROM `appointments`
										LEFT JOIN users ON appointments.user_id_patient = users.user_id
										LEFT JOIN payments ON appointments.user_id_patient = payments.user_id
										WHERE appointments.concern = '$concern' AND users.user_id = '$user_id'
										GROUP BY appointments.appointment_id
  ";
  $run = mysqli_query($conn, $query);

  if(mysqli_num_rows($run) > 0){
    foreach($run as $row){
    ?>
    <div class="col-lg-12">
      <label for="">Remaining Balance:</label>
      <input type="number" class="form-control" name="remaining_balance">
      <input type="hidden" class="form-control" name="concern" value="<?= $row['concern']?>">
      <input type="hidden" class="form-control" name="user_id" value="<?= $user_id ?>">
    </div>
    <?php
    }
  }
}

?>