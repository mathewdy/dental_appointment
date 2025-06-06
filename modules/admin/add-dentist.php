<?php
include('../../connection/connection.php');

session_start();
ob_start();
$first_name = $_SESSION['first_name']
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include '../../includes/styles.php' ?>
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
                        <h4 class="page-title">Add New Dentist</h4>
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
                                <a href="view-dentists.php">Dentists</a>
                            </li>
                            <li class="separator">
                                <i class="icon-arrow-right"></i>
                            </li>
                            <li class="nav-item">
                                <a href="#">Add Dentist</a>
                            </li>
                        </ul>
                    </span>    
                </span>
            </div>
            <div class="page-category">
                <div class="card p-5">
                    <form action="add-dentist.php" method="POST">
                        <div class="row">
                            <div class="col-lg-12">
                                <h3>Basic Information</h3>
                            </div>
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
                            <div class="col-lg-12">
                                <h3>Schedule Information</h3>
                            </div>
                            <div class="col-lg-12 mb-4">
                                <label for="">Schedule</label><br>
                                <input type="checkbox" name="schedule[]" value="Monday"> Monday <br>
                                <input type="checkbox" name="schedule[]" value="Tuesday"> Tuesday <br>
                                <input type="checkbox" name="schedule[]" value="Wednesday"> Wednesday <br>
                                <input type="checkbox" name="schedule[]" value="Thursday"> Thursday <br>
                                <input type="checkbox" name="schedule[]" value="Friday"> Friday <br>
                                <input type="checkbox" name="schedule[]" value="Saturday"> Saturday <br>
                            </div>
                            <div class="col-lg-6">
                                <label for="">Start Time</label>
                                <input type="time" class="form-control" name="start_time" id="start_time" min="10:00" max="17:00">
                                
                            </div>
                            <div class="col-lg-6 mb-5">
                                <label for="">End Time</label>
                                <input type="time" class="form-control" name="end_time" id="end_time" min="10:00" max="17:00">
                            </div>
                            <div class="col-lg-12 text-end">
                                <a href="view-dentists.php" class="btn btn-danger">Cancel</a>
                                <input type="submit" class="btn btn-primary" name="add_dentist" value="Create">

                            </div>
                        </div>                        
                    </form>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include "../../includes/scripts.php"; ?>

</body>
</html>


    <h1>Add Dentist</h1>
   

</body>
<script>
document.querySelector('form').addEventListener('submit', function(e) {
    const start = document.getElementById('start_time').value;
    const end = document.getElementById('end_time').value;

    if (!start || !end) {
        alert("Please select both start and end time.");
        e.preventDefault();
        return;
    }

    const startTime = new Date("1970-01-01T" + start + ":00");
    const endTime = new Date("1970-01-01T" + end + ":00");
    const minTime = new Date("1970-01-01T10:00:00");
    const maxTime = new Date("1970-01-01T17:00:00");

    if (startTime < minTime || startTime > maxTime) {
        alert("Start time must be between 10:00 AM and 5:00 PM.");
        e.preventDefault();
        return;
    }

    if (endTime <= startTime) {
        alert("End time must be after start time.");
        e.preventDefault();
        return;
    }

    if (endTime > maxTime) {
        alert("End time must not be later than 5:00 PM.");
        e.preventDefault();
        return;
    }
});

</script>
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
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    $days_combined = implode(', ', $schedule);
   
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

        $query_insert_schedule = "INSERT INTO schedule (user_id,day,start_time,end_time,date_created,date_updated)VALUES ('$user_id', '$days_combined', '$start_time','$end_time', '$date', '$date')";
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