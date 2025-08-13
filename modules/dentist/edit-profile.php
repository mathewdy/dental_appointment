<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/security.php');

$first_name = $_SESSION['first_name'];
$email = $_SESSION['email'];
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>

    <div class="wrapper">
        <?php 
        include '../../includes/sidebar.php'; 
        ?>

      <div class="main-panel">
        <?php 
        include '../../includes/topbar.php'; 
        ?>
        <div class="container">
          <div class="page-inner">
            <div class="page-header">
                <span class="d-flex justify-content-between align-items-center w-100">
                    <span class="d-flex">
                        <h4 class="page-title">My Profile</h4>
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
                                <a href="my-profile.php">Profile</a>
                            </li>
                            <li class="separator">
                                <i class="icon-arrow-right"></i>
                            </li>
                            <li class="nav-item">
                                <a href="#">Edit Profile</a>
                            </li>
                        </ul>
                    </span>    
                </span>
            </div>
            <div class="page-category">
                <div class="card p-5">
                <?php
                    if(isset($_GET['user_id'])){
                        $user_id = $_GET['user_id'];
                        $query_profile = "SELECT users.user_id AS user_id, users.first_name AS first_name, users.middle_name AS middle_name, users.last_name AS last_name, users.mobile_number AS mobile_number, users.email AS email, users.date_of_birth AS date_of_birth FROM users
                        WHERE users.role_id = '3' AND users.user_id = '$user_id'";
                        $run_profile = mysqli_query($conn,$query_profile);

                        if(mysqli_num_rows($run_profile) > 0){
                            foreach($run_profile as $row_profile){
                                $formattedDate = date("m/d/Y", strtotime($row_profile['date_of_birth']));
                                ?>


                                    <form action="" method="POST">
                                        <div class="row">
                                            <div class="col-lg-6 mb-4">
                                                <label for="">First Name</label>
                                                <input type="text" name="first_name" class="form-control" value="<?php echo $row_profile['first_name']?>">
                                            </div>
                                            <div class="col-lg-6 mb-4">
                                                <label for="">Last Name</label>
                                                <input type="text" name="last_name" class="form-control" value="<?php echo $row_profile['last_name']?>">
                                            </div>
                                            <div class="col-lg-12 mb-4">
                                            <label for="">Mobile Number</label>
                                            <input type="text" name="mobile_number" class="form-control" value="<?php echo $row_profile['mobile_number']?>">
                                            </div>
                                            <div class="col-lg-12 mb-4"> 
                                                <label for="">Email</label>
                                                <input type="email" name="email" class="form-control" value="<?php echo $row_profile['email']?>">
                                            </div>
                                            <div class="col-lg-12 mb-5">
                                                <label for="">Date of Birth</label>
                                                <p><?php echo $formattedDate?></p>
                                                <input type="hidden" name="birth_date" value="<?= $row_profile['date_of_birth']?>">
                                                <input type="date" class="form-control"  name="date_of_birth">
                                                
                                            </div>
                                            <div class="col-lg-12 text-end">
                                                <a href="my-profile.php" class="btn btn-danger">Cancel</a>
                                                <input type="submit" class="btn btn-primary" name="update_profile" value="Update">
                                            </div>
                                        </div>
                                        
                                        <!-- <label for="">Middle Name</label>
                                        <input type="text" name="middle_name" class="form-control" value="<?php echo $row_profile['middle_name']?>">
                                         -->
                                        
                                       

                                    </form>


                                <?php
                            }
                        }
                    }


                    ?>
                </div>
   
            </div>
          </div>
        </div>
      </div>
    </div>
<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/scripts.php'); 

if(isset($_POST['update_profile'])){
    date_default_timezone_set("Asia/Manila");
    $date = date('y-m-d');
    $user_id = $_GET['user_id'];
    $first_name = $_POST['first_name'];
    // $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $mobile_number = $_POST['mobile_number'];
    $email = $_POST['email'];
    if(!empty($_POST['date_of_birth'])){
        $date_of_birth = $_POST['date_of_birth'];
    }else{
        $date_of_birth = $_POST['birth_date'];
    }
    $query_update = "UPDATE users SET first_name = '$first_name', last_name='$last_name',mobile_number = '$mobile_number', email = '$email', date_of_birth =  '$date_of_birth', date_updated = '$date' WHERE user_id = '$user_id'" ;
    $run_update = mysqli_query($conn,$query_update);

    if($run_update){
        header("Location: my-profile.php");
        
    }else{
        echo "error". $conn->error;
    }

}

?>