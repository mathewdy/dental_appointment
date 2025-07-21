<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/security.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$first_name = $_SESSION['first_name'];
include('../../includes/security.php');
?>

    <h1>Edit Balance</h1>

    <?php
    if(isset($_GET['payment_id'])){
        $payment_id = $_GET['payment_id'];
        $query_balance = "SELECT * FROM payments WHERE payment_id = '$payment_id'";
        $run_balance = mysqli_query($conn,$query_balance);

        if(mysqli_num_rows($run_balance) > 0){
            foreach($run_balance as $balance){
                ?>

                    <form action="" method="POST">

                 
                    <label for="">Balance:</label>
                    <input type="text" value="<?php echo $balance ['remaining_balance']?>" readonly>
                    <input type="number" name="edit_balance">
                    <input type="hidden" name="services" value="<?php echo $balance['services']?>">
                    <input type="hidden" name="user_id" value="<?php echo $balance['user_id']?>">
                    <input type="submit" name="update_balance" value="Update">

                    </form>
                <?php
            }
        }
    }
include "../../includes/scripts.php"; 


if(isset($_POST['update_balance'])){
    $payment_id = $_GET['payment_id'];
    $edit_balance = $_POST['edit_balance'];
    $user_id = $_POST['user_id'];
    $services = $_POST['services'];

    $query_update_balance = "UPDATE payments SET initial_balance = '$edit_balance' , remaining_balance = '$edit_balance' WHERE payment_id = '$payment_id'";
    $run_update_balance = mysqli_query($conn,$query_update_balance);

    if($run_update_balance){
        echo "Updated Balance";
            echo "<script>
                    window.alert('Updated Balance');
                    window.location.href='history-patient-payments.php?user_id=$user_id&concern=$services';
                </script>";
    }else{
        echo "Error" ; 
    }
}


?>