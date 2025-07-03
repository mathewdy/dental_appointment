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
    

    <a href="payments.php">Back</a>

    <table>

    <tr>
        <th>Services</th>
        <th>Initial Price</th>
        <th>Maximum Price</th>
    </tr>
        
    <?php

        $query_services = "SELECT * FROM services";
        $run_services = mysqli_query($conn,$query_services);

        if(mysqli_num_rows($run_services) > 0){
            foreach($run_services as $row_services_2){
                ?>

                    <tr>
                        <td><?php echo $row_services_2['name']?></td>
                        <td><?php echo $row_services_2['price']?></td>
                        <td><?php echo $row_services_2['price_2']?></td>
                    </tr>
                   
                    

                <?php
            }
        }

    ?>

    </table>

    <?php

        if(isset($_GET['user_id'])){
            $user_id = $_GET['user_id'];
            $query_patient_name = "SELECT * FROM users WHERE user_id = '$user_id'";
            $run_patient_name = mysqli_query($conn,$query_patient_name);
            if(mysqli_num_rows($run_patient_name) > 0){
                foreach($run_patient_name as $row_patient_name){
                    ?>

                        <label for="">Name:</label>
                        <p><?php echo $row_patient_name['first_name'] . " " . $row_patient_name['last_name']?></p>
                        <br>

                    <?php
                }
            }
            
        }

    ?>
     <!---gagawa ako ng conditional statements kapag walang laman ang balance, lalabas ay add payment.
                            pero pag may laman, update payment na lang

                            gagawa din ako ng conditional statement kapag ang remaining balance ay 0 , matik lalabas lang ay 0
                            pero pag meron, call lang yung data
                        --->
    <?php

        if(isset($_GET['user_id'])){
            $user_id = $_GET['user_id'];

            $query_patient = "SELECT users.user_id, users.first_name, users.last_name,
            payments.services, payments.payment, payments.remaining_balance
            FROM users
            LEFT JOIN payments ON users.user_id = payments.user_id
            WHERE users.user_id = '$user_id'";
            $run_patient = mysqli_query($conn,$query_patient);

            if (mysqli_num_rows($run_patient) > 0){
                foreach ($run_patient as $row_patient){
                ?>
                    <form action="" method="POST">
                        <input type="hidden" name="service_name" value="<?php echo $row_patient['services']; ?>">
                        
                        <label>Service:</label>
                        <p><strong><?php echo $row_patient['services']; ?></strong></p>

                        <label>Remaining Balance:</label>
                        <input type="text" name="remaining_balance" value="<?php echo $row_patient['remaining_balance']; ?>">
                        <br>

                        <label>Add Payment:</label>
                        <input type="text" name="payment" required>
                        <br>

                        <?php if (is_null($row_patient['payment'])) { ?>
                            <input type="submit" name="add_payment" value="Add Payment">
                        <?php } else { ?>
                            <input type="submit" name="update_payment" value="Update Payment">
                        <?php } ?>
                    </form>
            <?php
    }
}
        }

    ?>

</body>
</html>

<?php

if(isset($_POST['add_payment'])) {
    $user_id = $_GET['user_id'];
    $service = $_POST['service_name'];
    $payment = $_POST['payment'];
    $remaining_balance = $_POST['remaining_balance'];
    $date = date('Y-m-d');

    $insert_query = "INSERT INTO payments (user_id, services, payment, remaining_balance, date_created, date_updated) VALUES ('$user_id', '$service', '$payment', '$remaining_balance', '$date', '$date')";
    mysqli_query($conn, $insert_query);
}

if(isset($_POST['update_payment'])) {
    $user_id = $_GET['user_id'];
    $service = $_POST['service_name'];
    $payment = $_POST['payment'];
    $remaining_balance = $_POST['remaining_balance'];
    $date = date('Y-m-d');

    $update_query = "UPDATE payments SET payment = '$payment', remaining_balance = '$remaining_balance', date_updated = '$date' WHERE user_id = '$user_id' AND services = '$service'";
    mysqli_query($conn, $update_query);
}


?>