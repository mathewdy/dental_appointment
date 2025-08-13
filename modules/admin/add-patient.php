<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/security.php');
$first_name = $_SESSION['first_name'];
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
						<form action="" method="POST">
							<div class="row gap-2">
									<div class="col-lg-12">
											<div class="card p-4 shadow-none form-card rounded-1">
													<div class="card-header">
															<h3>Basic Information</h3>
													</div>
													<div class="card-body">
															<div class="row gap-4">
																	<div class="col-lg-12">
																			<div class="row d-flex align-items-center w-100">
																					<div class="col-lg-2">
																							<label for="first_name">First Name</label>
																					</div>
																					<div class="col-lg-10">
																							<input type="text" class="form-control" name="first_name">
																					</div>
																			</div>
																	</div>
																	<div class="col-lg-12">
																			<div class="row d-flex align-items-center w-100">
																					<div class="col-lg-2">
																							<label for="">Middle Name</label>
																					</div>
																					<div class="col-lg-10">
																							<input type="text" class="form-control" name="middle_name">
																					</div>
																			</div>
																	</div>
																	<div class="col-lg-12">
																			<div class="row d-flex align-items-center w-100">
																					<div class="col-lg-2">
																							<label for="">Last Name</label>
																					</div>
																					<div class="col-lg-10">
																							<input type="text" class="form-control" name="last_name">
																					</div>
																			</div>
																	</div>
																	<div class="col-lg-12">
																			<div class="row d-flex align-items-center w-100">
																					<div class="col-lg-2">
																							<label for="">Mobile Number </label>
																					</div>
																					<div class="col-lg-10">
																							<input type="text" class="form-control" name="mobile_number">
																					</div>
																			</div>
																	</div>
																	<div class="col-lg-12">
																			<div class="row d-flex align-items-center w-100">
																					<div class="col-lg-2">
																							<label for="">Date of Birth</label>
																					</div>
																					<div class="col-lg-10">
																							<input type="date" class="form-control" name="date_of_birth">
																					</div>
																			</div>
																	</div>
															</div>
													</div>
											</div>
									</div>
									<div class="col-lg-12">
										<div class="card p-4 shadow-none form-card rounded-1">
												<div class="card-header">
													<h3>Account</h3>
												</div>
												<div class="card-body">
													<div class="row gap-4">
														<div class="col-lg-12">
															<div class="row d-flex align-items-center w-100">
																<div class="col-lg-2">
																	<label for="">Email</label>
																</div>
																<div class="col-lg-10">
																	<input type="email" class="form-control" name="email">
																</div>
															</div>
														</div>
														<div class="col-lg-12">
															<div class="row d-flex align-items-center w-100">
																<div class="col-lg-2">
																	<label for="">Password</label>
																</div>
																<div class="col-lg-10">
																	<div class="input-group mb-3">
																		<input type="password" class="form-control pw" name="password" aria-describedby="basic-addon2" id="pw" placeholder="•••••••">
																		<span class="input-group-text pw-toggle" id="basic-addon2" style="cursor:pointer;" data-target="#pw"><i class="fas fa-eye"></i></span>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
										</div>
								</div>
							</div>
							<div class="col-lg-12 text-end">
									<a href="patients.php" class="btn btn-sm btn-danger">Cancel</a>
									<input type="submit" class="btn btn-sm btn-primary" name="register_patient" value="Save">
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