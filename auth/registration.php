<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');

?>

    <div class="container" style="height: 50em;">
        <div class="row d-flex justify-content-center align-items-center p-5" style="height: 100%;">
            <div class="col-12">
                <div class="card w-100 border-none rounded-0">
                    <div class="row" style="height: 100%;">
                        <div class="col-lg-6 p-5 bg-dark">
                            <div class="  op-9 text-light p-5 d-flex align-items-center justify-content-center" style="height:100%;">
                                <div class="row">
                                    <div class="col-lg-12 align-items-center text-center">
                                        <img src="../assets/img/logo-with-name.png" alt="logo" height="150">
                                        <h1 class="display-7 fw-bold">We take care of your teeth</h1>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-lg-6 p-5 d-flex flex-column justify-content-center">
                            <form action="" method="POST">
                                <div class="row px-4">
                                    <div class="col-lg-12 text-center mb-5">
                                        <h1>Register Here</h1>
                                    </div>
                                    <div class="col-lg-12 mb-4">
                                        <label for="">First Name</label>
                                        <input type="text" class="form-control" name="first_name">
                                    </div>
                                    <div class="col-lg-12 mb-4">
                                        <label for="">Middle Name</label>
                                        <input type="text" class="form-control" name="middle_name">
                                    </div>
                                    <div class="col-lg-12 mb-4">
                                        <label for="">Last Name</label>
                                        <input type="text" class="form-control" name="last_name">
                                    </div>
                                    <div class="col-lg-12 mb-4">
                                        <label for="">Mobile Number </label>
                                        <input type="number" class="form-control" name="mobile_number">
                                    </div>
                                    <div class="col-lg-12 mb-4">
                                        <label for="">Date of Birth</label>
                                        <input type="date" class="form-control" name="date_of_birth">
                                    </div>
                                    <div class="col-lg-12 mb-4">
                                        <label for="">Email</label>
                                        <input type="email" class="form-control" name="email">
                                    </div>
                                    <div class="col-lg-6 mb-5">
                                        <label for="">Password </label>
                                        <div class="input-group mb-3">
                                            <input type="password" class="form-control pw" name="password" aria-describedby="basic-addon2" id="pw">
                                            <span class="input-group-text pw-toggle" id="basic-addon2" style="cursor:pointer;" data-target="#pw"><i class="fas fa-eye"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-5">
                                        <label for="">Confirm Password </label>
                                        <div class="input-group mb-3">
                                            <input type="password" class="form-control pw" id="pw2" name="password_2" aria-describedby="basic-addon2" pattern="(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder="•••••••" title="Password must be at least 8 characters and contain both uppercase and lowercase letters" required>
                                            <span class="input-group-text pw-toggle" id="basic-addon2" style="cursor:pointer;" data-target="#pw2"><i class="fas fa-eye"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mb-4 text-center">
                                        <input type="submit" class="btn btn-black op-8 w-100" name="register_patient" value="Register">
                                        <a href="login.php" class="text-dark">Already have an account?</a>
                                    </div>
                                    <div class="col-lg-12 p-0 m-0 text-center">
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
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/scripts.php');

if(isset($_POST['register_patient'])){

    $user_id = "2025".rand('1','10') . substr(str_shuffle(str_repeat("0123456789", 5)), 0, 3) ;
    $role_id = 1;
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $date_of_birth = date('Y-m-d',strtotime($_POST['date_of_birth']));
    $mobile_number = $_POST['mobile_number'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_2 = $_POST['password_2'];

    if ($password !== $password_2) {
        echo "<script>window.alert('Password does not match')</script>";
        echo "<script>window.location.origin</script>";
    }else{
        $new_password = password_hash($password,PASSWORD_DEFAULT);

        date_default_timezone_set("Asia/Manila");
        $date = date('y-m-d');
        
        //errors
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        $query_check_user = "SELECT * FROM users WHERE email='$email'";
        $run_check_user = mysqli_query($conn,$query_check_user);
        
        if(mysqli_num_rows($run_check_user) > 0){
            echo "<script>alert('User Already Added')</script>";
            exit();
        }else{
            $query_register = "INSERT INTO users (user_id,role_id,first_name,middle_name,last_name,mobile_number,email,password,date_of_birth,date_created,date_updated) VALUES ('$user_id','$role_id', '$first_name','$middle_name','$last_name','$mobile_number','$email','$new_password','$date_of_birth','$date','$date')";
            $run_sql = mysqli_query($conn,$query_register);
            echo "user_added" ; 

            if($run_sql){
                echo "<script>window.alert('Account Created')</script>";
                echo "<script>window.location.href='login.php'</script>";
            }else{
                echo "error" . $conn->error;
            }
        }

    }


    
}
ob_end_flush();


?>