<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/Users/users.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/Mailer/mail.php');

$email = $_SESSION['email'] ?? null;

if(!empty($email)) {
  session_destroy();
}
?>
<div class="container">
        <div class="row d-flex justify-content-center align-items-center p-lg-5 h-100">
            <div class="col-lg-6 p-0">
                <div class="card w-100 border-none rounded-0">
                    <div class="row" style="height: 100%;">
                        <div class="col-lg-12 p-5 d-flex flex-column justify-content-center ">
                            <span class="text-center">
                                <img src="../assets/img/logo.png" height="100" alt="">
                            </span>
                            <span class="mb-4 text-center">
                                <h1>Sign In</h1>
                            </span>
                            <form action="auth.php" method="POST">
                                <div class="row px-4">
                                    <div class="col-lg-12 mb-5">
                                        <label for="">Email</label>
                                        <input type="email" class="form-control" name="email" placeholder="Email">
                                    </div>
                                    <div class="col-lg-12 mb-5">
                                        <label for="">Password </label>
                                        <div class="input-group mb-3">
                                            <input type="password" class="form-control pw" name="password" aria-describedby="basic-addon2" id="pw">
                                            <span class="input-group-text pw-toggle" id="basic-addon2" style="cursor:pointer;" data-target="#pw"><i class="fas fa-eye"></i></span>
                                        </div>
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
<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/scripts.php');

ob_end_flush();
?>