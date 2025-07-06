<?php
include('../../connection/connection.php');
ob_start();
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$first_name = $_SESSION['first_name'];
include('../../includes/security.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <h1>Make a payment</h1>

    <?php

        if(isset($_GET['payment_id'])&isset($_GET['user_id'])&isset($_GET['service'])){
            $user_id = $_GET['user_id'];
            $concern = $_GET['service'];

            ?>
                    
                <a href="history-patient-payments.php?user_id=<?php echo $user_id?>&concern=<?php echo $concern?>">Back</a>
            <?php

            $payment_id = $_GET['payment_id'];
            $user_id = $_GET['user_id'];
            $concern = $_GET['service'];

            $query_payment = "SELECT * FROM payments WHERE user_id = '$user_id' AND services = '$concern' AND payment_id = '$payment_id'";
            $run_payment = mysqli_query($conn,$query_payment);

            if(mysqli_num_rows($run_payment) > 0){
                foreach($run_payment as $row_payment){
                    ?>

                        <form action="" method="POST">
                            <input type="text" name="remaining_balance" value="<?php echo $row_payment['remaining_balance']?>">
                            <label for="">Add payment</label>
                            <input type="number" name="payment">
                            <input type="submit" name="add_payment" value="Add Payment">
                        </form>

                    <?php
                }
            }
        }

    ?>

</body>
</html>

<?php

if(isset($_POST['add_payment'])){

    date_default_timezone_set("Asia/Manila");
    $date = date('y-m-d');

    $remaining_balance = $_POST['remaining_balance'];
    $payment = $_POST['payment'];
    $payment_id = $_GET['payment_id'];

    $updated_balance = $remaining_balance - $payment;

    $query_update_balance = "UPDATE payments SET remaining_balance = '$updated_balance', is_deducted = '1' , date_updated = '$date' WHERE payment_id = '$payment_id'";
    $run_update_balance =  mysqli_query($conn,$query_update_balance);

    if($run_update_balance){
        // need to integrate
        echo "updated balance";
        $query_insert_payment = "INSERT INTO payment_history (payment_id,payment_received,payment_method,date_created,date_updated) VALUES ('$payment_id','$payment',NULL, '$date', '$date')";
        $run_insert_payment = mysqli_query($conn,$query_insert_payment);

        if($run_insert_payment){
            echo "payment inserted";
        }else{
            echo "error payment inserted" . "<br>";
        }
    }else{
        echo "error updated balance" . "<brs>";
    }
    

}

?>