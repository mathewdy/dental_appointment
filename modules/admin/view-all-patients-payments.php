<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/security.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$first_name = $_SESSION['first_name'];
include('../../includes/security.php');
?>


    <?php
    if (isset($_GET['payment_id']) && isset($_GET['service']) && isset($_GET['user_id'])) {
        $user_id = $_GET['user_id'];
        $concern = $_GET['service'];
        ?>
        <a href="history-patient-payments.php?user_id=<?php echo $user_id ?>&concern=<?php echo $concern ?>">Back</a>
        <?php
    }
    ?>


            

    <h1>List of Payments</h1>
    
    <table>
        <tr>
            <th>Payment Received</th>
            <th>Payment Method</th>
            <th>Date Created</th>
        </tr>
        
        <?php

        if(isset($_GET['payment_id'])&isset($_GET['service'])&isset($_GET['user_id'])){
            $payment_id = $_GET['payment_id'];
            $user_id = $_GET['user_id'];
            $concern = $_GET['service'];

            $query_all_history = "SELECT * FROM payment_history WHERE payment_id = '$payment_id'";
            $run_all_history = mysqli_query($conn,$query_all_history);

            if(mysqli_num_rows($run_all_history) > 0){
                foreach($run_all_history as $row_history){
                    ?>

                        <tr>
                            <td><?php echo $row_history['payment_received']?></td>
                            <td><?php echo $row_history['payment_method']?></td>
                            <td><?php echo $row_history['date_created']?></td>
                        </tr>

                    <?php
                }
            }
        }



        ?>


    </table>
<?php include "../../includes/scripts.php"; ?>
