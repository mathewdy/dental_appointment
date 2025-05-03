<?php
include('../../connection/connection.php');
session_start();
ob_start();

$email = $_SESSION['email'];
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
    <a href="my-profile.php">Back</a>
    <?php

    

    if(isset($_GET['user_id'])){
        $user_id = $_GET['user_id'];
        $query_profile = "SELECT users.user_id AS user_id, users.first_name AS first_name, users.middle_name AS middle_name, users.last_name AS last_name, users.mobile_number AS mobile_number, users.email AS email, users.date_of_birth AS date_of_birth FROM users
        WHERE users.role_id = '2' AND users.user_id = '$user_id'";
        $run_profile = mysqli_query($conn,$query_profile);

        if(mysqli_num_rows($run_profile) > 0){
            foreach($run_profile as $row_profile){
                ?>


                    <form action="" method="POST">
                        <label for="">First Name</label>
                        <input type="text" name="first_name" value="<?php echo $row_profile['first_name']?>">
                        <label for="">Middle Name</label>
                        <input type="text" name="middle_name" value="<?php echo $row_profile['middle_name']?>">
                        <label for="">Last Name</label>
                        <input type="text" name="last_name" value="<?php echo $row_profile['last_name']?>">
                        <label for="">Mobile Number</label>
                        <input type="text" name="mobile_number" value="<?php echo $row_profile['mobile_number']?>">
                        <label for="">Email</label>
                        <input type="email" name="email" value="<?php echo $row_profile['email']?>">
                        <label for="">Date of Birth</label>
                        <p><?php echo $row_profile['date_of_birth']?></p>
                        <input type="date" name="date_of_birth">

                        <input type="submit" name="update_profile" value="Update">
                    </form>


                <?php
            }
        }
    }


    ?>
</body>
</html>

<?php


if(isset($_POST['update_profile'])){
    date_default_timezone_set("Asia/Manila");
    $date = date('y-m-d');
    $user_id = $_GET['user_id'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $mobile_number = $_POST['mobile_number'];
    $email = $_POST['email'];
    $date_of_birth = $_POST['date_of_birth'];


    $query_update = "UPDATE users SET first_name = '$first_name', middle_name = '$middle_name', last_name='$last_name',mobile_number = '$mobile_number', email = '$email', date_of_birth =  '$date_of_birth', date_updated = '$date' WHERE user_id = '$user_id'" ;
    $run_update = mysqli_query($conn,$query_update);

    if($run_update){
        echo "updated";
        
    }else{
        echo "error". $conn->error;
    }

}

?>