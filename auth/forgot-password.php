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

<h1>Forgot Password</h1>

<form action="../includes/mailer.php" method="POST">
    <div class="row">
        <div class="col-12 mb-2">
            <p class="h2">Forgot Your Password?</p>
            <p class="h6">No worries! Enter your email address below to receive instructions on how to reset your password and regain access to your inventory.</p>
            <hr class="featurette-divider">
        </div>
        <div class="col-12 mb-4">
            <label for="">Email</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <div class="col-12 ">
            <input type="submit" class="btn btn-success w-100" name="send_email" value="Send Email">
        </div>
    </div>
</form>
    
</body>
</html>