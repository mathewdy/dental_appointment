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
    <div class="container p-5">
        <div class="card px-5 py-3">
            <h1>LOGO</h1>
            <div class="row p-5">
                <div class="col-lg-6 text-center p-5">
                    <h1>Sign In</h1>
                    <form action="" method="POST">
                    <input type="email" class="form-control mb-5" name="email" placeholder="Email">
                    <input type="password" class="form-control" style="margin-bottom: 6em;" name="password" placeholder="Password">
                    <input type="submit" class="btn btn-black op-8 w-100 mb-2" name="login" value="Login">
                    </form>
                    <a href="#">Forgot Password</a>
                </div>
                <div class="col-lg-6">
                    <div class="card bg-dark op-9 text-light p-5 d-flex align-items-center justify-content-center" style="height:100%;">
                        <div class="row">
                            <div class="col-lg-12 align-items-center text-center">
                                <h1 class="display-5 fw-bold">Welcome to login</h1>
                                <p>Don't have an account?</p>
                                <a href="registration.php" class="btn text-white border-light btn-round">Sign Up</a>
                            </div>
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
                header("Location: dashboard.php");
            }
        }
    } else {
        // echo "username or password error";
        echo "<script>window.location.origin</script>";
    }
}

ob_end_flush();
?>