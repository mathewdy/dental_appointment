<?php
include('../connection/connection.php');
session_start();
ob_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <h1>Create a new account
    It’s quick and easy.</h1>
    <form action="" method="POST">
        <label for="">First Name</label>
        <input type="text" name="first_name">
        <label for="">Middle Name</label>
        <input type="text" name="middle_name">
        <label for="">Last Name</label>
        <input type="text" name="last_name">
        <label for="">Mobile Number </label>
        <input type="text" name="mobile_number">
        <label for="">Date of Birth</label>
        <input type="date" name="date_of_birth">
        <label for="">Email</label>
        <input type="email" name="email">
        <label for="">Password</label>
        <input type="password" name="password">
        <input type="submit" name="register_patient" value="Register">
    </form>

    <a href="login.php">Already have an account?</a>
    
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
    

    $query_check_user = "SELECT * FROM users WHERE email='$email' AND first_name = '$first_name' AND last_name = '$last_name' AND date_of_birth = '$date_of_birth' ";
    $run_check_user = mysqli_query($conn,$query_check_user);
    
    if(mysqli_num_rows($run_check_user) > 0){
        echo "<script>alert('User Already Added')</script>";
        exit();
    }else{
        $query_register = "INSERT INTO users (user_id,role_id,first_name,middle_name,last_name,mobile_number,email,password,date_of_birth,date_created,date_updated) VALUES ('$user_id','$role_id', '$first_name','$middle_name','$last_name','$mobile_number','$email','$new_password','$date_of_birth','$date','$date')";
        $run_sql = mysqli_query($conn,$query_register);
        echo "user_added" ; 

        if($run_sql){
            echo "<script>window.location.href='login.php'</script>";
        }else{
            echo "error" . $conn->error;
        }
    }

}
ob_end_flush();


?>