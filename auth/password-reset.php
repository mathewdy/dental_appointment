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
    <div class="container" style="height: 55em;">
        <div class="row d-flex justify-content-center align-items-center p-5" style="height: 100%;">
            <div class="col-12">
                <div class="card w-100 border-none rounded-0" style="height: 45em;">
                    <div class="row" style="height: 100%;">
                        <div class="col-lg-6 p-5 d-flex flex-column justify-content-center ">
                            <span class="text-center">
                                <img src="../assets/img/logo.png" height="100" alt="">
                            </span>
                            <span class="mb-4 text-center">
                                <h1>Sign In</h1>
                            </span>
                            <form action="" method="POST">
                                <div class="row px-4">
                                    <div class="col-lg-12 mb-5">
                                        <label for="">Email</label>
                                        <input type="email" class="form-control" name="email" placeholder="Email">
                                    </div>
                                    <div class="col-lg-12 mb-5">
                                        <label for="">Password </label>
                                        <input type="password" class="form-control" name="password" placeholder="Password">
                                    </div>
                                    <div class="col-lg-12 text-center">
                                        <input type="submit" class="btn btn-black op-8 w-100 mb-2" name="login" value="Login">
                                        <a href="forgot-password.php" class="text-dark">Forgot Password?</a>
                                    </div>
                                </div>                                                      
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include "../includes/scripts.php"; ?>
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