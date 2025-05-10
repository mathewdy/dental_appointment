<?php

include('../../connection/connection.php');
session_start();
ob_start();
//errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Edit Patient</h1>
    <a href="patients.php">Back</a>

    <?php

    if(isset($_GET['user_id'])){
        $user_id_patient = $_GET['user_id'];
        $query_patients = "SELECT users.user_id, users.first_name,users.middle_name,users.last_name,users.mobile_number,users.email,users.password,users.date_of_birth,users.address, appointments.appointment_id,appointments.concern,appointments.confirmed,appointments.appointment_date,appointments.remarks
        FROM users
        LEFT JOIN appointments
        ON users.user_id = appointments.user_id WHERE users.role_id = '1' AND users.user_id = '$user_id_patient'";

        $run_patients = mysqli_query($conn,$query_patients);

        if(mysqli_num_rows($run_patients) > 0){
            foreach($run_patients as $row_patients){
                ?>

                <form action="" method="POST">
                    <h2>Patient's Info</h2>
                    <label for="">First Name</label>
                    <input type="text" name="first_name" value="<?php echo $row_patients['first_name']?>">
                    <label for="">Middle Name</label>
                    <input type="text" name="middle_name" value="<?php echo $row_patients['middle_name']?>">
                    <label for="">Last Name</label>
                    <input type="text" name="last_name" value="<?php echo $row_patients['last_name']?>">
                    <label for="">Mobile Number</label>
                    <input type="text" name="mobile_number" value="<?php echo $row_patients['mobile_number']?>">
                    <label for="">Email</label>
                    <input type="email" name="email" value="<?php echo $row_patients['email']?>">
                    <label for="">Date of Birth</label>
                    <input type="date" name="date_of_birth" value="<?php echo $row_patients['date_of_birth']?>">
                    <label for="">Address</label>
                    <input type="text" name="address" value="<?php echo $row_patients['address']?>">

                    <h2>Patient's Appointments</h2>

                    <label for="">Status</label>
                    <p>
                    
                        <?php 
                        
                        $status = (int)$row_patients['confirmed'];
                        if ($status === 0) {
                            echo "Unverified / No Data";
                        } elseif ($status === 1) {
                            echo "Confirmed";
                        } elseif ($status === 2) {
                            echo "Canceled";
                        }
                        
                        ?>
                
                    </p>

                    <label for="">Appointment Date</label>
                    <p><?php echo $row_patients['appointment_date']?></p>
                    <label for="">Doctor's Remarks</label>
                    <p><?php echo $row_patients['remarks']?></p>

                    <input type="submit" name="update" value="Update">
                </form>

                <form action="send_reset_password.php" method="POST">

                    <h3>Send Reset Password</h3>
                        
                    <input type="submit" name="send_reset_password" value="Send Email">
                    <input type="hidden" name="email" value="<?php echo $row_patients['email']?>">

                </form>
                <?php
                
            }
        }
    }

    ?>
</body>
</html>

<?php

if(isset($_POST['update'])){

    date_default_timezone_set("Asia/Manila");
    $date = date('y-m-d');
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $mobile_number = $_POST['mobile_number'];
    $email = $_POST['email'];
    $date_of_birth = $_POST['date_of_birth'];
    $address = $_POST['address'];
    $user_id_patient = $_GET['user_id'];

    $query_update = "UPDATE users SET first_name = '$first_name', middle_name = '$middle_name',last_name='$last_name',mobile_number = '$mobile_number', email = '$email', date_of_birth =  '$date_of_birth', address = '$address', date_updated = '$date' WHERE user_id = '$user_id_patient'" ;
    $run_update = mysqli_query($conn,$query_update);

    if($run_update){
        echo "updated";
    }else{
        echo "error";
    }




}



?>