<?php
include('../../connection/connection.php');
session_start();
ob_start();
$first_name = $_SESSION['first_name'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include '../../includes/styles.php'; ?>
    <title>Document</title>
</head>
<body>
    <div class="wrapper">
      <?php include '../../includes/sidebar.php'; ?>
      <div class="main-panel">
        <?php include '../../includes/topbar.php'; ?>
        <div class="container">
          <div class="page-inner">
            <div class="page-header">
                <span class="d-flex justify-content-between align-items-center w-100">
                    <span class="d-flex">
                        <h4 class="page-title">Add New Patient</h4>
                        <ul class="breadcrumbs d-flex justify-items-center align-items-center">
                            <li class="nav-home">
                            <a href="dashboard.php">
                                <i class="icon-home"></i>
                            </a>
                            </li>
                            <li class="separator">
                                <i class="icon-arrow-right"></i>
                            </li>
                            <li class="nav-item">
                                <a href="patients.php">Patient</a>
                            </li>
                            <li class="separator">
                                <i class="icon-arrow-right"></i>
                            </li>
                            <li class="nav-item">
                                <a href="#">Add Patient</a>
                            </li>
                        </ul>
                    </span>    
                </span>
            </div>
            <div class="page-category">
                <div class="card p-5">
                    <form action="" method="POST">
                        <div class="row">
                            <div class="col-lg-4 mb-4">
                                <label for="">First Name</label>
                                <input type="text" class="form-control" name="first_name">
                            </div>
                            <div class="col-lg-4 mb-4">
                                <label for="">Middle Name</label>
                                <input type="text" class="form-control" name="middle_name">
                            </div>
                            <div class="col-lg-4 mb-4">
                                <label for="">Last Name</label>
                                <input type="text" class="form-control" name="last_name">
                            </div>
                            <div class="col-lg-6 mb-4">
                                <label for="">Mobile Number </label>
                                <input type="text" class="form-control" name="mobile_number">
                            </div>
                            <div class="col-lg-6 mb-4">
                                <label for="">Date of Birth</label>
                                <input type="date" class="form-control" name="date_of_birth">
                            </div>
                            <div class="col-lg-6 mb-4">
                                <label for="">Email</label>
                                <input type="email" class="form-control" name="email">
                            </div>
                            <div class="col-lg-6 mb-4">
                                <label for="">Password</label>
                                <input type="password" class="form-control" name="password">
                            </div>
                            <div class="col-lg-12 text-end">
                                <a href="patients.php" class="btn btn-danger">Cancel</a>
                                <input type="submit" class="btn btn-primary" name="register_patient" value="Save">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <a href="appointments.php">Appointment</a>
    <?php include "../../includes/scripts.php"; ?>
</body>
</html>

<?php
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
            echo "<script>window.location.href='patients.php'</script>";
        }else{
            echo "error" . $conn->error;
        }
    }

}
ob_end_flush();


?>