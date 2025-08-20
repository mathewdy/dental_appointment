<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/Users/users.php');

$first_name = $_SESSION['first_name'];
$email = $_SESSION['email'];
$roleId = $_SESSION['role_id'];

ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);


?>


    <div class="wrapper">
        <?php include '../../includes/sidebar.php'; ?>

      <div class="main-panel">
        <?php include '../../includes/topbar.php'; ?>
        <div class="container">
          <div class="page-inner">
            <div class="page-header">
            <span class="d-flex justify-content-between align-items-center w-100">
              <span class="d-flex">
                  <h4 class="page-title">Edit Profile</h4>
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
                <?php
                    if(isset($_GET['user_id'])){
                        $user_id = $_GET['user_id'];
                        $run_profile = getProfile($conn, $user_id, $roleId);
                        if(mysqli_num_rows($run_profile) > 0){
                            foreach($run_profile as $row_profile){
                              $dob = date("Y-m-d", strtotime($row_profile['date_of_birth']));
                              ?>
                              <form action="" method="POST">
                                  <div class="row">
                                    <div class="col-lg-12 mb-4">
                                      <div class="card p-4 shadow-none form-card rounded-1">
                                        <div class="card-header">
                                            <h3>Profile Information</h3>
                                        </div>
                                        <div class="card-body">
                                          <div class="row gap-4">
                                            <div class="col-lg-12">
                                              <div class="row d-flex align-items-center w-100">
                                                <div class="col-lg-2">
                                                  <label for="">First Name</label>
                                                </div>
                                                <div class="col-lg-10">
                                                  <input type="text" name="first_name" class="form-control" value="<?php echo $row_profile['first_name']?>">
                                                </div>
                                              </div>
                                            </div>
                                            <div class="col-lg-12">
                                              <div class="row d-flex align-items-center w-100">
                                                <div class="col-lg-2">
                                                  <label for="">Middle Name</label>
                                                </div>
                                                <div class="col-lg-10">
                                                  <input type="text" name="middle_name" class="form-control" value="<?php echo $row_profile['middle_name']?>">
                                                </div>
                                              </div>
                                            </div>
                                            <div class="col-lg-12">
                                              <div class="row d-flex align-items-center w-100">
                                                <div class="col-lg-2">
                                                  <label for="">Last Name</label>
                                                </div>
                                                <div class="col-lg-10">
                                                  <input type="text" name="last_name" class="form-control" value="<?php echo $row_profile['last_name']?>">
                                                </div>
                                              </div>
                                            </div>
                                            <div class="col-lg-12">
                                              <div class="row d-flex align-items-center w-100">
                                                <div class="col-lg-2">
                                                  <label for="">Mobile Number</label>
                                                </div>
                                                <div class="col-lg-10">
                                                  <div class="input-group mb-3">
                                                    <input type="text" name="mobile_number" class="form-control" value="<?php echo $row_profile['mobile_number']?>">
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="col-lg-12">
                                              <div class="row d-flex align-items-center w-100">
                                                <div class="col-lg-2">
                                                  <label for="">Email</label>
                                                </div>
                                                <div class="col-lg-10">
                                                  <div class="input-group mb-3">
                                                    <input type="email" name="email" class="form-control" value="<?php echo $row_profile['email']?>">
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="col-lg-12">
                                              <div class="row d-flex align-items-center w-100">
                                                <div class="col-lg-2">
                                                  <label for="">Date of Birth</label>
                                                </div>
                                                <div class="col-lg-10">
                                                  <div class="input-group mb-3">
                                                    <input type="date" class="form-control" value="<?= $dob ?>" name="birth_date">
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-lg-12 text-end">
                                      <a href="my-profile.php" class="btn btn-sm btn-danger">Cancel</a>
                                      <input type="submit" class="btn btn-sm btn-primary" name="update_profile" value="Update">
                                    </div>
                                </div>                        
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
<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/scripts.php'); 

if(isset($_POST['update_profile'])){

    $user_id = $_GET['user_id'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $mobile_number = $_POST['mobile_number'];
    $email = $_POST['email'];
    if(!empty($_POST['date_of_birth'])){
        $date_of_birth = $_POST['date_of_birth'];
    }else{
        $date_of_birth = $_POST['birth_date'];
    }

    $run_update = updateProfile($conn, $first_name, $middle_name, $last_name, $mobile_number, $email, $date_of_birth, $user_id);
    if($run_update){
      echo "<script> success('Profile has been updated successfully.', () => window.location.href = 'my-profile.php') </script>";
    }else{
      echo "<script> error('Something went wrong!', () => window.location.href = 'my-profile.php') </script>";
    }

}

?>