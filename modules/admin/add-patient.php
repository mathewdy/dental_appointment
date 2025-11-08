<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/Users/users.php');

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
									<div class="col-lg-12">
										<div class="card p-4 shadow-none form-card rounded-1">
											<div class="card-header">
												<h3>Medical History</h3>
											</div>
											<div class="card-body">
												<div class="row gap-4">
													<div class="col-lg-12">
														<div class="row d-flex align-items-start w-100">
															<div class="col-lg-2">
																<label for="">History</label>
															</div>
															<div class="col-lg-10">
																<?php
																	$array_history = array("High Blood Pressure", "Diabetes", "Heart Disease", "Asthma", "Hepatitis", "Bleeding Disorder", "Tuberculosis");
																	foreach($array_history as $history){
																			?>
																			<input class="form-check-input" type="checkbox" name="history[]" value="<?php echo $history; ?>" id="flexCheckDefault">
																			<label class="form-check-label" for="flexCheckDefault">
																							<?php echo $history; ?>
																			</label>
																			<br>
																			<?php
																	}
																?>
															</div>
														</div>
													</div>
													<div class="col-lg-12">
														<div class="row d-flex align-items-start w-100">
															<div class="col-lg-2">
																<label for="">Medication & Allergies</label>
															</div>
															<div class="col-lg-10">
																<div class="mb-3">
																		<label for="exampleFormControlInput1" class="form-label">Current Medications</label>
																		<input type="text" name="current_medications" class="form-control" id="exampleFormControlInput1" placeholder="">
																</div>
																<div class="mb-3">
																		<label for="exampleFormControlInput1" class="form-label">Allergies(Drugs/Foods/Anesthesia)</label>
																		<input type="text" name="allergies" class="form-control" id="exampleFormControlInput1" placeholder="">
																</div>
																	<div class="mb-3">
																		<label for="exampleFormControlInput1" class="form-label">Past Surgeries / Hospitalizations</label>
																		<input type="text" name="past_surgeries" class="form-control" id="exampleFormControlInput1" placeholder="">
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
									<input type="hidden" name="register_patient" value="1">
									<input type="submit" class="btn btn-sm btn-primary" value="Create">	
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
?>
<script>
$(document).ready(function() {
    $('form').on('submit', function(e) {
        e.preventDefault();
        confirmBeforeSubmit($(this), "Do you want to create this user?")
    });
});
</script>
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

		$history_string = isset($_POST['history']) && is_array($_POST['history']) 
      ? implode(", ", $_POST['history']) 
      : "";
		$current_medications = $_POST['current_medications'] ?? "";
		$allergies = $_POST['allergies'] ?? "";  
		$past_surgeries = $_POST['past_surgeries'] ?? "";
		
		$run_check_user = checkUser($conn, $email, $first_name, $middle_name, $last_name, $date_of_birth);
    if(mysqli_num_rows($run_check_user) > 0){
			echo "<script> error('User already added.', () => window.location.href = 'vpatients.php') </script>";
    }else{
			$run_sql = createUser($conn, $user_id, $role_id, $first_name, $middle_name, $last_name, $mobile_number, $email, $new_password, $date_of_birth);
			$sql_insert_history = "INSERT INTO medical_history (user_id, history, current_medications, allergies, past_surgeries,date_created,date_updated) VALUES ('$user_id', '$history_string', '$current_medications', '$allergies', '$past_surgeries','$date','$date')";
			$run_insert_history = mysqli_query($conn, $sql_insert_history);

			if($run_sql){
				echo "<script> success('Patient added successfully.', () => window.location.href = 'patients.php') </script>";
			}else{
				echo "<script> error('Something went wrong!', () => window.location.href = 'vpatients.php') </script>";
			}
    }
}
ob_end_flush();


?>