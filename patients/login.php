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
    <title>Document</title>
</head>
<body>
    <h1>Login</h1>

    <form action="" method="POST">
    <label for="">Email</label>
    <input type="email" name="email">
    <label for="">Password</label>
    <input type="password" name="password">
    <input type="submit" name="login" value="Login">
    </form>

    <a href="registration.php">Create Account</a>
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