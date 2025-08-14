<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/Appointments/appointments.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/Payments/payments.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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
                    <h4 class="page-title">Payments</h4>
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
                          <a href="payments.php">Payments</a>
                      </li>
                      <li class="separator">
                          <i class="icon-arrow-right"></i>
                      </li>
                      <li class="nav-item">
                          <a href="payments.php">View</a>
                      </li>
                    </ul>
                  </span>    
                </span>
            </div>
    

    <!-- <table class="display table table-bordered" id="dataTable">
        <thead>
            <tr>
                <th>Services</th>
                <th>Initial Price</th>
                <th>Maximum Price</th>
            </tr>
        </thead>
        <tbody>
        <?php

                $query_services = "SELECT * FROM services";
                $run_services = mysqli_query($conn,$query_services);

                if(mysqli_num_rows($run_services) > 0){
                    foreach($run_services as $row_services_2){
                        ?>

                            <tr>
                                <td><?php echo $row_services_2['name']?></td>
                                <td><?php echo $row_services_2['price']?></td>
                                <td><?php echo $row_services_2['price_2']?></td>
                            </tr>
                        
                            

                        <?php
                    }
                }

            ?>
        </tbody>
    

    </table> -->
        <?php
            if(isset($_GET['user_id'])){
                $user_id = $_GET['user_id'];
                $query_patient_name = "SELECT * FROM users WHERE user_id = '$user_id'";
                $run_patient_name = mysqli_query($conn,$query_patient_name);
                if(mysqli_num_rows($run_patient_name) > 0){
                    foreach($run_patient_name as $row_patient_name){
                        ?>
                            <span>
                                <label for="">Patient Name:</label>
                                <h1 class="m-0 p-0"><?php echo $row_patient_name['first_name'] . " " . $row_patient_name['last_name']?></h1>
                            </span>		
                            
                        <?php
                    }
                }
                
            }

        ?>
    <!-- </ul> -->
  
     <!--- gagawa ako ng conditional statements kapag walang laman ang balance, lalabas ay add payment.
        pero pag may laman, update payment na lang

        gagawa din ako ng conditional statement kapag ang remaining balance ay 0 , matik lalabas lang ay 0
        pero pag meron, call lang yung data
    --->
    <?php

        if(isset($_GET['user_id'])){
            $user_id = $_GET['user_id'];

            //     $query_patient = "SELECT users.user_id, users.first_name, users.last_name,
            //     payments.services, payments.payment, payments.remaining_balance
            //     FROM users
            //     LEFT JOIN payments ON users.user_id = payments.user_id
            //     WHERE users.user_id = '$user_id'";
            //     $run_patient = mysqli_query($conn,$query_patient);

            //     if (mysqli_num_rows($run_patient) > 0){
            //         foreach ($run_patient as $row_patient){
            //         ?>
            <!-- //             <form action="" method="POST">
            //                 <input type="hidden" name="service_name" value="<?php echo $row_patient['services']; ?>">
                            
            //                 <label>Service:</label>
            //                 <p><strong><?php echo $row_patient['services']; ?></strong></p>

            //                 <label>Remaining Balance:</label>
            //                 <input type="text" name="remaining_balance" value="<?php echo $row_patient['remaining_balance']; ?>">
            //                 <br>

            //                 <label>Add Payment:</label>
            //                 <input type="text" name="payment" required>
            //                 <br>

            //                 <?php if (is_null($row_patient['payment'])) { ?>
            //                     <input type="submit" name="add_payment" value="Add Payment">
            //                 <?php } else { ?>
            //                     <input type="submit" name="update_payment" value="Update Payment">
            //                 <?php } ?>
            //             </form>
            ---->
                        <?php  
            //     }
            // }
            ?>
            <div class="card p-4">
							<div class="table-responsive">
								<table class="display table" id="dataTable">
									<thead>
											<tr>
													<th>Services / Concern:</th>
													<th>Initial Balance</th>
													<th>Remaining Balance</th>
													<th style="width:10%;">Actions</th>
											</tr>
									</thead>
									<tbody>
										<?php
										$run_patients_appointments = getAppointments($conn, $user_id, '1');

										if(mysqli_num_rows($run_patients_appointments) > 0){
												foreach($run_patients_appointments as $row_patients_appointments){
														?>
														<tr>
															<td>
																<?= $row_patients_appointments['concern']?>
															</td>
															<td><?= $row_patients_appointments['initial_balance'] ? '₱'.$row_patients_appointments['initial_balance'] : '₱ '. 0 ?></td>
															<td>
																<?= $row_patients_appointments['remaining_balance'] ?  '₱'.$row_patients_appointments['remaining_balance'] : '₱ '. 0 ?>
															</td>
															<td class="d-flex justify-content-center" >
																<div class="dropdown">	
																		<a class="btn btn-sm btn-outline-primary rounded-circle d-flex justify-content-center align-items-center" style="width: 12px;" data-bs-toggle="dropdown" aria-expanded="false">
																				<i class="fas fa-ellipsis-v"></i>
																		</a>
																		<ul class="dropdown-menu">
                                        <?php 
                                        if($row_patients_appointments['payment_id'] == null){
                                        ?>
                                        <li>
																					<a class="dropdown-item add-balance" 
                                          href="#"
                                          data-bs-toggle="modal" data-bs-target="#addBalanceDialog"
                                          data-id="<?= $row_patients_appointments['id'] ?>"
                                          data-concern="<?= $row_patients_appointments['concern']?>"
                                          >
                                            Add Balance
                                          </a>
																				</li>
                                        <?php
                                        }else{
                                        ?>
                                        <li>
																					<a class="dropdown-item" 
                                          href="update-payment.php?payment_id=<?= $row_patients_appointments['payment_id']?>&user_id=<?= $user_id?>&service=<?= $row_patients_appointments['concern']?>"
                                          >
                                            Process Payment
                                          </a>
																				</li>
                                        <?php 
                                        if($row_patients_appointments['is_deducted'] != 1){
                                        ?>
                                        <li>
																					<a class="dropdown-item edit-balance" 
                                          data-bs-toggle="modal" data-bs-target="#editBalanceDialog"
                                          data-id="<?= $row_patients_appointments['payment_id']?>"
                                          >
                                            Edit Balance
                                          </a>
																				</li>
                                        <li>
																					<a class="dropdown-item" href="delete-balance.php?payment_id=<?= $row_patients_appointments['payment_id']?>&user_id=<?= $user_id?>&concern=<?= $row_patients_appointments['concern']?>" 
																						onclick="return confirm('Are you sure you want to delete this?')">
																						Delete Balance
																					</a>
																				</li>
                                        <?php
                                        }
                                        ?>
                                        <li>
                                          <a class="dropdown-item payment-history" 
                                            href="#"
                                            data-bs-toggle="modal" data-bs-target="#paymentHistoryDialog"
                                            data-id="<?= $row_patients_appointments['payment_id']?>"
                                          >
                                            Payment History
                                          </a>
                                        </li>
                                      <?php
                                        }
                                        ?>
																		</ul>
																</div>
															</td>
														</tr>
														<?php
												}
										}
										?>
									</tbody>
								</table>
							</div>
						</div>
			<?php
			 //next step, create ako ng add balance tapos, add payment.
            // tas more on deduction na to and update na ito ng payment.
            //integration of PayMaya
        }

    ?>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="addBalanceDialog" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Balance</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="add-balance.php" method="POST" data-message="edit">
          <div class="modal-body">
            <div class="row addForm">
            </div>
          </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-md btn-primary" value="Add">                      
            <input type="hidden" name="add_balance" value="1">                      
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="editBalanceDialog" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Balance</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="edit-balance.php" method="POST" data-message="edit">
          <div class="modal-body">
            <div class="row editForm">
            </div>
          </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-md btn-primary" value="Update">                      
            <input type="hidden" name="update_balance" value="1">                      
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="paymentHistoryDialog" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Payment History</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="payment-list"></div>
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
          var message = $(this).data('message')
          e.preventDefault();
          confirmBeforeSubmit($(this), `Do you want to ${message} balance?`)
      });
  });
</script>
<?php
// if(isset($_POST['add_payment'])) {
//     $user_id = $_GET['user_id'];
//     $service = $_POST['service_name'];
//     $payment = $_POST['payment'];
//     $remaining_balance = $_POST['remaining_balance'];
//     $date = date('Y-m-d');

//     $insert_query = "INSERT INTO payments (user_id, services, payment, remaining_balance, date_created, date_updated) VALUES ('$user_id', '$service', '$payment', '$remaining_balance', '$date', '$date')";
//     mysqli_query($conn, $insert_query);
// }

// if(isset($_POST['update_payment'])) {
//     $user_id = $_GET['user_id'];
//     $service = $_POST['service_name'];
//     $payment = $_POST['payment'];
//     $remaining_balance = $_POST['remaining_balance'];
//     $date = date('Y-m-d');

//     $update_query = "UPDATE payments SET payment = '$payment', remaining_balance = '$remaining_balance', date_updated = '$date' WHERE user_id = '$user_id' AND services = '$service'";
//     mysqli_query($conn, $update_query);

//     //kunin ko info ng patient
//     //kunin ko yung concern ng patient
//     //add ako ng payments
// }


?>