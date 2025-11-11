<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/Users/users.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/Users/dentists.php');

$first_name = $_SESSION['first_name']
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
						<form action="add-dentist.php" method="POST">
							<div class="row">
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
															<input type="tel" class="form-control" name="mobile_number" 
															placeholder="09XXXXXXXXX"
															pattern="^09[0-9]{9}$"
															maxlength="11"
															oninput="this.value = this.value.replace(/[^0-9]/g, '')"
															required>
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
											<h3>Schedule Information</h3>
										</div>
										<div class="card-body">
											<div class="row gap-4">
												<div class="col-lg-12">
													<div class="row d-flex align-items-center w-100">
														<div class="col-lg-2">
															<label for="">Start Time</label>
														</div>
														<div class="col-lg-10">
															<input type="time" class="form-control" name="start_time" id="start_time" min="10:00" max="17:00">
														</div>
													</div>
												</div>
												<div class="col-lg-12">
													<div class="row d-flex align-items-center w-100">
														<div class="col-lg-2">
															<label for="">End Time</label>
														</div>
														<div class="col-lg-10">
															<input type="time" class="form-control" name="end_time" id="end_time" min="10:00" max="17:00">
														</div>
													</div>
												</div>
												<div class="col-lg-12">
													<div class="row d-flex align-items-start w-100">
														<div class="col-lg-2">
															<label for="">Working Days:</label>
														</div>
														<div class="col-lg-10">
															<span class="d-flex align-items-center gap-2">
																<input type="checkbox" name="schedule[]" value="Monday"> Monday
															</span>
															<span class="d-flex align-items-center gap-2">
																<input type="checkbox" name="schedule[]" value="Tuesday"> Tuesday 
															</span>
															<span class="d-flex align-items-center gap-2">
																<input type="checkbox" name="schedule[]" value="Wednesday"> Wednesday
															</span>
															<span class="d-flex align-items-center gap-2">
																<input type="checkbox" name="schedule[]" value="Thursday"> Thursday 
															</span>
															<span class="d-flex align-items-center gap-2">
																<input type="checkbox" name="schedule[]" value="Friday"> Friday 
															</span>
															<span class="d-flex align-items-center gap-2">
																<input type="checkbox" name="schedule[]" value="Saturday"> Saturday 
															</span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-12 mb-4">
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
								<div class="col-lg-12 text-end">
									<a href="view-dentists.php" class="btn btn-sm btn-danger">Cancel</a>
									<input type="hidden" name="add_dentist" value="1">
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
        confirmBeforeSubmit($(this), "Do you want to create this user?", function() {
            return validate('start_time', 'end_time');
        });
    });
});
</script>

<?php
if(isset($_POST['add_dentist'])){
    $user_id = "2025".rand('1','10') . substr(str_shuffle(str_repeat("0123456789", 5)), 0, 3) ;
    $role_id = 3;
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $date_of_birth = date('Y-m-d',strtotime($_POST['date_of_birth']));
    $mobile_number = $_POST['mobile_number'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $new_password = password_hash($password, PASSWORD_DEFAULT);
    $schedule = $_POST['schedule'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $days_combined = implode(', ', $schedule);

    $run_check_user = checkUser($conn, $email, $first_name, $middle_name, $last_name, $date_of_birth);
    if(mysqli_num_rows($run_check_user) > 0){
			echo "<script> error('User Already Added.', () => location.reload()) </script>";
    }else{
			$run_sql = createUser($conn, $user_id, $role_id, $first_name, $middle_name, $last_name, $mobile_number, $email, $new_password, $date_of_birth);
			$run_insert_Schedule = createDentistSchedule($conn, $user_id, $days_combined, $start_time, $end_time);

			if($run_sql){
				echo "<script> success('Dentist added successfully.', () => window.location.href = 'view-dentists.php') </script>";
			}else{
				echo "<script> error('Something went wrong!', () => window.location.href = 'view-dentists.php') </script>";
			}
    }
}
ob_end_flush();


?>