<?php
ob_start();
include("../includes/header.php")

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="POST">
        <label for="">Email:</label>
        <input type="email" name="email" placeholder="Enter Email Address" required>
        <label for="">New Password:</label>
        <input type="password" name="password_1" placeholder="Enter New Password" required>
        <label for="">Confirm Password:</label>
        <input type="password" name="password_2" placeholder="Enter Confirm Password" required>
        <input type="hidden" name="token" value="<?php if(isset($_GET['token'])){echo $_GET['token'];} ?>">
        <input type="submit" name="update" Value="Update Password">
    </form>
</body>
</html>


<?php

if(isset($_POST['update'])){
    
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $password_1 = mysqli_real_escape_string($conn,$_POST['password_1']);
    $password_2 = mysqli_real_escape_string($conn,$_POST['password_2']);
    
    $new_password = password_hash($password_2,PASSWORD_DEFAULT);
    $token = mysqli_real_escape_string($conn,$_POST['token']);

    $check_token = "SELECT token, email FROM users WHERE email ='$email' AND token =  '$token' LIMIT 1";
    $check_token_run = mysqli_query($conn,$check_token);

    if(mysqli_num_rows($check_token_run) > 0){

        if($password_1 == $password_2){
            $query_update_password = "UPDATE users SET password = '$new_password' WHERE email = '$email' AND token =  '$token' LIMIT 1";
            $run_update_password = mysqli_query($conn,$query_update_password);
            echo "<script>alert('Password updated, please login') </script>";
            header("Location: login.php");
        }else{
            echo "Password Doesn't Match";
        }

    }else{
        echo "User not found & token not available";
    }


}

?>