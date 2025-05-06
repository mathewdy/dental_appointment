<?php
ob_start();
session_start();
date_default_timezone_set('Asia/Manila');
include('../connection/connection.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include '../includes/styles.php' ?>
    <title>Document</title>
</head>
<body>
<div class="container" style="height: 55em;">
        <div class="row d-flex justify-content-center align-items-center p-5" style="height: 100%;">
            <div class="col-6">
                <div class="card w-100 border-none rounded-0" style="height: 45em;">
                    <div class="row" style="height: 100%;">
                        <div class="col-lg-12 p-5 d-flex flex-column justify-content-center ">
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
                                        <span class="d-flex justify-content-end">
                                            <a href="forgot-password.php" class="text-dark">Forgot Password?</a>
                                        </span>
                                    </div>
                                    <div class="col-lg-12 text-center">
                                        <input type="submit" class="btn btn-black op-8 w-100 mb-2" name="login" value="Login">
                                        <a href="registration.php" class="text-black">Create new account</a>
                                    </div>
                                </div>                                                      
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <?php include "../includes/scripts.php"; ?>
</html>

<?php

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query_login = "SELECT * FROM users WHERE email = '$email'";
    $run_login = mysqli_query($conn, $query_login);

    if (mysqli_num_rows($run_login) > 0) {
        foreach ($run_login as $row) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['email'] = $email;
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['first_name'] = $row['first_name'];
                $_SESSION['last_name'] = $row['last_name'];
                $_SESSION['image'] = $row['image'];
                $_SESSION['role_id'] = $row['role_id'];


                switch ($row['role_id']){
                    case '2':
                        header("Location: ../modules/admin/dashboard.php");
                        break;
                    case '3':
                        header("Location: ../modules/dentist/dashboard.php");
                        break;
                }
                exit;
            }
        }
    } else {
        echo "<script>window.alert('Invalid Credentials')</script>";
        echo "<script>window.location.origin</script>";
    }
}
ob_end_flush();
?>