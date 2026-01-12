<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Users/users.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Mailer/mail.php');
?>

    <div class="container">
        <div class="row d-flex justify-content-center align-items-lg-center p-lg-5 h-100">
            <div class="col-lg-12">
                <div class="card w-100 border-none rounded-0" style="height: 45em;">
                    <div class="row" style="height: 100%;">
                        <div class="col-lg-6 p-5 d-flex flex-column justify-content-center ">
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
                                        <input type="email" class="form-control" name="email" placeholder="Enter your email">
                                    </div>
                                    <div class="col-lg-12 mb-5">
                                        <div class="input-group mb-3">
                                            <input type="password" class="form-control pw" name="password" aria-describedby="basic-addon2" id="pw" placeholder="•••••••">
                                            <span class="input-group-text pw-toggle" id="basic-addon2" style="cursor:pointer;" data-target="#pw"><i class="fas fa-eye"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 text-center">
                                        <input type="submit" class="btn btn-black op-8 w-100 mb-2" name="login" value="Login">
                                        <a href="forgot-password.php" class="text-dark">Forgot Password?</a>
                                    </div>
                                </div>                                                      
                            </form>
                        </div>
                        <div class="col-lg-6 bg-dark">
                            <div class=" text-light d-flex align-items-center justify-content-center" style="height:100%;">
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
        </div>
    </div>
<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/scripts.php');

ob_end_flush();

?>