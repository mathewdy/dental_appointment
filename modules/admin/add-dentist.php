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

    <h1>Add Dentist</h1>
    <form action="add-dentist.php" method="POST">
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
        <br>
        <label for="">Password</label>
        <input type="password" name="password">
        <br>
        <label for="">Schedule</label><br>
        <input type="checkbox" name="schedule[]" value="Monday"> Monday <br>
        <input type="checkbox" name="schedule[]" value="Tuesday"> Tuesday <br>
        <input type="checkbox" name="schedule[]" value="Wednesday"> Wednesday <br>
        <input type="checkbox" name="schedule[]" value="Thursday"> Thursday <br>
        <input type="checkbox" name="schedule[]" value="Friday"> Friday <br>
        <input type="checkbox" name="schedule[]" value="Saturday"> Saturday <br>
        <label for="">Time</label>
        <input type="time" name="time">

        
        <input type="submit" name="add_dentist" value="Create">
    </form>

</body>
</html>

<?php
if(isset($_POST['add_dentist'])){
    date_default_timezone_set("Asia/Manila");
    $date = date('y-m-d');

    $user_id = "2025".rand('1','10') . substr(str_shuffle(str_repeat("0123456789", 5)), 0, 3) ;
    $role_id = 3;
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $date_of_birth = date('Y-m-d',strtotime($_POST['date_of_birth']));
    $mobile_number = $_POST['mobile_number'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $new_password = password_hash($password,PASSWORD_DEFAULT);

    $schedule = $_POST['schedule'];
    $time = $_POST['time'];

    $days_combined = implode(' ', $schedule);
   
    $query_check_user = "SELECT * FROM users WHERE email='$email' AND first_name = '$first_name' AND last_name = '$last_name' AND date_of_birth = '$date_of_birth' ";
    $run_check_user = mysqli_query($conn,$query_check_user);
    
    if(mysqli_num_rows($run_check_user) > 0){
        echo "<script>alert('User Already Added')</script>";
        exit();
    }else{
        $query_register = "INSERT INTO users (user_id,role_id,first_name,middle_name,last_name,mobile_number,email,password,date_of_birth,date_created,date_updated) VALUES ('$user_id','$role_id', '$first_name','$middle_name','$last_name','$mobile_number','$email','$new_password','$date_of_birth','$date','$date')";
        $run_sql = mysqli_query($conn,$query_register);
       

        if($run_sql){
            echo "user_added" ; 
        }else{
            echo "error register". mysqli_error($conn);
        }

        $query_insert_schedule = "INSERT INTO schedule (user_id,day,time,date_created,date_updated)VALUES ('$user_id', '$days_combined', '$time', '$date', '$date')";
        $run_insert_Schedule = mysqli_query($conn,$query_insert_schedule);
        echo "added schedule";
    

        if($run_sql){
            echo "<script>window.alert('added')</script>";
            echo "<script>window.location.href='view-dentists.php'</script>";
        }else{
            echo "error" . $conn->error;
        }
    }

}
ob_end_flush();


?>