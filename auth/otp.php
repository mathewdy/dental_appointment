<?php

include('../connection/connection.php');
session_start();
ob_start();
$email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Enter OTP</h2>

    <form action="" method="POST">
        <input type="number" name="otp_number">
        <input type="submit" name="verify" value="Verify">
    </form>
</body>
</html>

<?php
if(isset($_POST['verify'])){
    $otp_number = $_POST['otp_number'];
    
    $query_otp = "SELECT otp FROM users WHERE email =  '$email'";
    $run_otp = mysqli_query($conn,$query_otp);
    $row_otp = mysqli_fetch_assoc($run_otp);

    if($row_otp['otp'] == $otp_number){
        echo "accepted";
        header("Location: ../modules/patients/dashboard.php");
    }else{
        echo "wrong number";
    }

}


?>