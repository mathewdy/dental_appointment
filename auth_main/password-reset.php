<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');

?>
<div class="container" style="height: 55em;">
    <div class="row d-flex justify-content-center align-items-center px-5" style="height: 100%;">
        <div class="col-6">
            <div class="card w-100 border-none rounded-0 px-5" style="height: 45em;">
                <div class="row" style="height: 100%;">
                    <div class="col-lg-12 d-flex flex-column justify-content-center ">
                        <form action="" method="POST">
                            <div class="row px-4">
                                <div class="col-lg-12 text-center">
                                    <i class="fas fa-lock fa-10x"></i>
                                </div>
                                <div class="col-lg-12">
                                    <span class="mb-5 text-center">
                                        <p class="h2">Reset Password</p>
                                        <p class="h6">Create a new password below to complete the process.</p>
                                        <hr class="featurette-divider">
                                    </span>
                                </div>
                                <div class="col-lg-12"></div>
                                <div class="col-lg-12 mb-4">
                                    <label for="">Email</label>
                                    <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
                                </div>
                                <div class="col-lg-12 mb-4">
                                    <label for="">New Password:</label>
                                    <div class="input-group mb-3">
                                        <input type="password" class="form-control pw" name="password_1" aria-describedby="basic-addon2" id="pw_1">
                                        <span class="input-group-text pw-toggle" id="basic-addon2" style="cursor:pointer;" data-target="#pw_1"><i class="fas fa-eye"></i></span>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-4">
                                    <label for="">Confirm Password:</label>
                                    <div class="input-group mb-3">
                                        <input type="password" class="form-control pw" name="password_2" aria-describedby="basic-addon2" id="pw_2">
                                        <span class="input-group-text pw-toggle" id="basic-addon2" style="cursor:pointer;" data-target="#pw_2"><i class="fas fa-eye"></i></span>
                                    </div>
                                </div>
                                <div class="col-lg-12 text-center mb-5">
                                    <input type="hidden" name="token" value="<?php if(isset($_GET['token'])){echo $_GET['token'];} ?>">
                                    <input type="submit" class="btn btn-black op-8 w-100 mb-2" name="update" value="Update Password">
                                    <!-- <a href="login.php" class="text-dark">Go back to login</a> -->
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
include "../includes/scripts.php";

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