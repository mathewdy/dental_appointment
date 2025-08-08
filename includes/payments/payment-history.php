<?php
session_start();
require_once('../../connection/connection.php');

$id = $_SESSION['user_id'];

if (isset($_POST['id']) && is_numeric($_POST['id'])) {
  $payment_id = $_POST['id'];

  $query = "SELECT *
    FROM payment_history 
    WHERE payment_id = '$payment_id'";
  $run = mysqli_query($conn, $query);

  if(mysqli_num_rows($run) > 0){
    foreach($run as $row){
      ?>
      <tr>
          <td><?= '₱'.$row['payment_received']?></td>
          <td><?= $row['payment_method']?></td>
          <td><?= $row['date_created']?></td>
      </tr>

      <?php
    }
  }
}

?>