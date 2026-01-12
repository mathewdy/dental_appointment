<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/security.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$first_name = $_SESSION['first_name'];
?>


<?php

if(isset($_GET['user_id'])&& isset($_GET['concern'])){
    $user_id = $_GET['user_id'];
    $concern = $_GET['concern'];
    ?>

        <a href="view-patient-payments.php?user_id=<?php echo $user_id ?>&concern=<?php echo $concern ?>">Back</a>

    <?php
}

?>


    <h1>History</h1>

    <table>
        <tr>
            <th>Initial Balance</th>
            <th>Actions</th>
        </tr>
    <?php

    if(isset($_GET['user_id'])&&isset($_GET['concern'])){
        $user_id = $_GET['user_id'];
        $concern = $_GET['concern'];
        $query_info = "SELECT * FROM payments WHERE user_id = '$user_id' AND services = '$concern'";

                $run_info = mysqli_query($conn,$query_info);

                if(mysqli_num_rows($run_info) > 0){
                    foreach($run_info as $row_info){
                        ?>

                        <tr>

                            <td>
                                <?php echo $row_info['initial_balance']?>
                                <?php
                                    if($row_info['is_deducted'] == 1){
                                        echo "";
                                    }else{
                                        ?>
                                            <td>
                                                <a href="edit-balance.php?payment_id=<?php echo $row_info['payment_id']?>">Edit Balance</a>
                                                <a href="delete-balance.php?payment_id=<?php echo $row_info['payment_id']?>&user_id=<?php echo $user_id?>&concern=<?php echo $concern?>" 
                                                onclick="return confirm('Are you sure you want to delete this?')">
                                                Delete
                                                </a>
                                            </td>
                                        <?php
                                    }
                                ?>
                            </td>

                        </tr>


                        <?php
                    }
                }else{
                    echo "No Data";

                    ?>

                        <a href="add-balance.php?user_id=<?php echo $user_id?>&concern=<?php echo $concern?>">Add</a>

                    <?php
                }

    }

    
       

    ?>

    </table>

    <table>
        <tr>
            <th>Remaining Balance</th>
            <th>Action</th>
        </tr>

        <?php

        if(isset($_GET['user_id'])&&isset($_GET['concern'])){
            $user_id = $_GET['user_id'];
            $concern = $_GET['concern'];
            $query_info = "SELECT * FROM payments WHERE user_id = '$user_id' AND services = '$concern'";

                    $run_info = mysqli_query($conn,$query_info);

                    if(mysqli_num_rows($run_info) > 0){
                        foreach($run_info as $row_info){
                            //gagawa ako ng trigger button kung nakapag make a payment na ba talaga or di pa, pag di pa both initial balance at remaining balance
                            //ang mapapalitan

                            //pero pag nakabayad na, leave as it is yung inital balance
                            ?>

                            <tr>
                                <td>
                                    <?php
                                        if($row_info['is_deducted'] = 1){
                                            echo $row_info['remaining_balance'];
                                        }else{
                                            echo $row_info['initial_balance'];
                                        }
                                    ?>
                                </td>
                                <td>
                                    <a href="update-payment.php?payment_id=<?php echo $row_info['payment_id']?>&user_id=<?php echo $user_id?>&service=<?php echo $concern?>">Update Payment</a>
                                    <a href="view-all-patients-payments.php?payment_id=<?php echo $row_info['payment_id']?>&user_id=<?php echo $user_id?>&service=<?php echo $concern?>">View All Payments</a>
                                </td>
                            </tr>


                            <?php
                        }
                    }else{
                        echo "No Data";
                    }

        }

        
        

        ?>
    </table>

<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/scripts.php'); 
?>