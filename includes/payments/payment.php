<?php
session_start();
require_once('../../connection/connection.php');

if (isset($_POST['id']) && is_numeric($_POST['id'])) {
  $user_id = $_POST['id'];
  $concern = $_POST['concern'];

  $query = "SELECT *
    FROM payments
    WHERE user_id = '$user_id' AND services  = '$concern'
    GROUP BY services
  ";
  $run = mysqli_query($conn, $query);

  if(mysqli_num_rows($run) > 0){
    foreach($run as $row){
    ?>
    <div class="col-lg-12">
      <label for="">Remaining Balance:</label>
      <input type="number" class="form-control" name="remaining_balance">
      <input type="hidden" class="form-control" name="concern" value="<?= $row['services']?>">
      <input type="hidden" class="form-control" name="user_id" value="<?= $user_id ?>">
    </div>
    <?php
    }
  }
}

?>