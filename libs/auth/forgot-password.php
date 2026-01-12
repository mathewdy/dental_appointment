<?php

ob_start();
session_start();
date_default_timezone_set('Asia/Manila');
include($_SERVER['DOCUMENT_ROOT'] .'/connection/connection.php');

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
<div class="container">
    <div class="row d-flex justify-content-center align-items-center px-lg-5 h-100">
        <div class="col-lg-6">
            <div class="card w-100 border-none rounded-0 px-5" style="height: 45em;">
                <div class="row" style="height: 100%;">
                    <div class="col-lg-12 d-flex flex-column justify-content-center ">
                        <form action="mailer.php" method="POST">
                            <div class="row px-4">
                                <div class="col-lg-12 text-center">
                                    <i class="fas fa-lock fa-10x"></i>
                                </div>
                                <div class="col-lg-12">
                                    <span class="mb-5 text-center">
                                        <p class="h2">Forgot Your Password?</p>
                                        <p class="h6">No worries! Enter your email address below to receive instructions on how to reset your password.</p>
                                        <hr class="featurette-divider">
                                    </span>
                                </div>
                                <div class="col-lg-12"></div>
                                <div class="col-lg-12 mb-5">
                                    <label for="">Email</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                                <div class="col-lg-12 text-center">
                                    <input type="submit" class="btn btn-black op-8 w-100 mb-2" name="send_email" value="Send Email">
                                    <a href="login.php" class="text-dark">Go back to login</a>
                                </div>
                            </div>                                                      
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/scripts.php');
?>
</body>
</html>