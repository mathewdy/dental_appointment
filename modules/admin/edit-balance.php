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
                    <input type="submit" name="update_balance" value="Update">

                    </form>
                <?php
            }
        }
    }
  

    ?>
</body>
</html>

<?php
if(isset($_POST['update_balance'])){
    $payment_id = $_GET['payment_id'];
    $edit_balance = $_POST['edit_balance'];

    $query_update_balance = "UPDATE payments SET initial_balance = '$edit_balance' , remaining_balance = '$edit_balance' WHERE payment_id = '$payment_id'";
    $run_update_balance = mysqli_query($conn,$query_update_balance);

    if($run_update_balance){
        echo "Updated Balance";
    }else{
        echo "Error" ; 
    }
}


?>