<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Appointments/appointments.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Payments/payments.php');

$first_name = $_SESSION['first_name'];
?>

    <div class="wrapper">
        <?php include '../../includes/sidebar.php'; ?>

      <div class="main-panel">
        <?php include '../../includes/topbar.php'; ?>
        <div class="container">
          <div class="page-inner">
            <div class="page-header">
              <div class="d-flex align-items-center gap-4 w-100">
                <h4 class="page-title text-truncate">Payments</h4>
                <div class="d-flex align-items-center gap-2 me-auto">
                  <div class="nav-home">
                    <a href="dashboard.php" class="text-decoration-none text-muted">
                      <i class="icon-home"></i>
                    </a>
                  </div>
                  <div class="separator">
                    <i class="icon-arrow-right fs-bold"></i>
                  </div>
                  <div class="nav-item">
                    <a href="payments.php" class="text-decoration-none text-truncate text-muted">Payments</a>
                  </div>
                  <div class="separator">
                    <i class="icon-arrow-right fs-bold"></i>
                  </div>
                  <div class="nav-item">
                    <a href="#" class="text-decoration-none text-truncate text-muted">View</a>
                  </div>
                </div>
              </div>
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
							<div class="table-responsive" style="overflow: visible; padding-bottom: 100px;">
								<table class="display table" id="dataTable">
									<thead>
											<tr>
													<th>Services / Concern:</th>
													<th>Initial Balance</th>
													<th>Total Paid</th>
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
															<td><?= $row_patients_appointments['initial_balance'] ? '₱'.number_format($row_patients_appointments['initial_balance'], 2) : '₱ 0.00' ?></td>
															<td>
																<?php 
																	$initial = $row_patients_appointments['initial_balance'] ?? 0;
																	$remaining = $row_patients_appointments['remaining_balance'] ?? 0;
																	$paid = $initial - $remaining;
																	echo '₱'.number_format($paid, 2);
																?>
															</td>
															<td>
																<?= $row_patients_appointments['remaining_balance'] ?  '₱'.number_format($row_patients_appointments['remaining_balance'], 2) : '₱ 0.00' ?>
															</td>
															<td class="d-flex justify-content-center" >
																<div class="dropstart">	
																		<a class="btn btn-sm btn-outline-primary rounded-circle d-flex justify-content-center align-items-center" style="width: 12px;" data-bs-toggle="dropdown" aria-expanded="false">
																				<i class="fas fa-ellipsis-v"></i>
																		</a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item view-chart-summary" href="#" 
                                                   data-appointment-id="<?= $row_patients_appointments['id'] ?>"
                                                   data-user-id="<?= $user_id ?>">
                                                   <i class="fas fa-list-alt me-2"></i> View Chart Summary
                                                </a>
                                            </li>
                                        <?php 
                                        if($row_patients_appointments['payment_id'] == null){
                                        ?>
                                        <li>
																					<a class="dropdown-item add-balance" 
                                          href="#"
                                          data-bs-toggle="modal" data-bs-target="#addBalanceDialog"
                                          data-id="<?= $row_patients_appointments['id'] ?>"
                                          data-concern="<?= urlencode($row_patients_appointments['concern'])?>"
                                          >
                                            Set Total Cost
                                          </a>
																				</li>
                                        <?php
                                        }else{
                                        ?>
                                        <li>
																					<a class="dropdown-item" 
                                          href="update-payment.php?payment_id=<?= $row_patients_appointments['payment_id']?>&user_id=<?= $user_id?>&service=<?= urlencode($row_patients_appointments['concern'])?>"
                                          >
                                            Process Payment
                                          </a>
																				</li>
                                        <li>
																					<a class="dropdown-item edit-balance" 
                                          data-bs-toggle="modal" data-bs-target="#editBalanceDialog"
                                          data-payment-id="<?= $row_patients_appointments['payment_id']?>"
                                          data-concern="<?= htmlspecialchars($row_patients_appointments['concern'])?>"
                                          data-balance="<?= $row_patients_appointments['initial_balance']?>"
                                          >
                                            Edit Total Cost
                                          </a>
																				</li>
                                        <?php 
                                        if($row_patients_appointments['is_deducted'] != 1){
                                        ?>
                                        <li>
																					<a class="dropdown-item delete" href="delete-balance.php?payment_id=<?= $row_patients_appointments['payment_id']?>&user_id=<?= $user_id?>&concern=<?= urlencode($row_patients_appointments['concern'])?>">
																						Delete Balance
																					</a>
																				</li>
                                        <?php
                                        }
                                        ?>
                                        <li>
                                          <a class="dropdown-item payment-history" 
                                            href="view-all-patients-payments.php?payment_id=<?= $row_patients_appointments['payment_id']?>&user_id=<?= $user_id?>&service=<?= urlencode($row_patients_appointments['concern'])?>"
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
            <h5 class="modal-title" id="exampleModalLabel">Set Total Cost</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="add-balance.php" method="POST" data-message="edit">
          <div class="modal-body">
            <div class="row">
               <div class="col-12 mb-3">
                    <label>Concern / Service</label>
                    <input type="text" class="form-control" name="concern" id="add_concern" readonly>
                </div>
                <div class="col-12 mb-3">
                    <label>Total Service Cost</label>
                    <input type="number" class="form-control" name="balance" required>
                </div>
                <input type="hidden" name="appointment_id" id="add_appointment_id">
                <input type="hidden" name="user_id" value="<?= $user_id ?>">
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
            <h5 class="modal-title" id="exampleModalLabel">Edit Total Cost</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="edit-balance.php" method="POST" data-message="edit">
          <div class="modal-body">
            <div class="row">
                <div class="col-12 mb-3">
                    <label>Concern / Service</label>
                    <input type="text" class="form-control" name="concern" id="edit_concern" required>
                </div>
                <div class="col-12 mb-3">
                    <label>Total Service Cost</label>
                    <input type="number" class="form-control" name="edit_balance" id="edit_balance" required>
                </div>
                <input type="hidden" name="payment_id" id="edit_payment_id">
                <input type="hidden" name="user_id" value="<?= $user_id ?>">
                <input type="hidden" name="services" id="edit_services"> 
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
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Payment History</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="payment-list table-responsive">
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

<!-- Chart Summary Modal -->
<div class="modal fade" id="chartSummaryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-tooth text-info me-2"></i>Dental Chart Summary
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="chartSummaryContent">
                    <div class="text-center py-3">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/scripts.php');
?>
<script>
  $(document).ready(function() {
        $('form').on('submit', function(e) {
          var message = $(this).data('message')
          //e.preventDefault(); // This prevented submission? It has confirm logic inside confirmBeforeSubmit? 
          // confirmBeforeSubmit handles standard confirm. 
          // If e.preventDefault is here, confirmBeforeSubmit must submit eventually.
          // Let's assume confirmBeforeSubmit works as existing.
          e.preventDefault();
          confirmBeforeSubmit($(this), `Do you want to ${message} balance?`);
        });
        $('.delete').on('click', function(e) {
            e.preventDefault();
            confirmBeforeRedirect("Do you want to delete this balance?", $(this).attr('href'))
        });

        // Handler for Edit Balance
        $('.edit-balance').on('click', function() {
            var paymentId = $(this).data('payment-id');
            var concern = $(this).data('concern');
            var balance = $(this).data('balance');
            
            $('#edit_payment_id').val(paymentId);
            $('#edit_concern').val(concern);
            $('#edit_balance').val(balance);
            $('#edit_services').val(concern);
        });

        // Handler for Add Balance (Basic)
         $('.add-balance').on('click', function() {
             var concern = $(this).data('concern'); // Passed encoded
             var id = $(this).data('id'); // Appointment ID
             
             try {
                concern = decodeURIComponent(concern); 
             } catch(e){}

             $('#add_concern').val(concern);
             $('#add_appointment_id').val(id);
             $('#add_concern').val(concern);
             $('#add_appointment_id').val(id);
         });

         // Handler for Chart Summary
         $('.view-chart-summary').on('click', function(e) {
             e.preventDefault();
             var apptId = $(this).data('appointment-id');
             var userId = $(this).data('user-id');
             
             $('#chartSummaryContent').html('<div class="text-center py-3"><div class="spinner-border text-primary"></div></div>');
             $('#chartSummaryModal').modal('show');

             $.ajax({
                 url: 'get_chart_summary.php',
                 method: 'GET',
                 // Revert: Use Global Chart (appointment_id: 0)
                 data: { patient_id: userId, appointment_id: 0 },
                 dataType: 'json',
                 success: function(res) {
                     if(res.success && res.data.length > 0) {
                         let html = '<div class="table-responsive"><table class="table table-sm table-striped table-bordered mb-0">';
                         html += '<thead class="table-light"><tr><th>Tooth #</th><th>Surface</th><th>Status</th><th>Notes</th></tr></thead><tbody>';
                         res.data.forEach(item => {
                             html += `<tr>
                                 <td class="text-center fw-bold">${item.tooth}</td>
                                 <td>${item.surface}</td>
                                 <td><span class="badge bg-secondary">${item.status}</span></td>
                                 <td class="small text-muted">${item.notes}</td>
                             </tr>`;
                         });
                         html += '</tbody></table></div>';
                         $('#chartSummaryContent').html(html);
                     } else {
                         $('#chartSummaryContent').html('<div class="alert alert-light text-center mb-0">No dental chart records found for this appointment.</div>');
                     }
                 },
                 error: function() {
                     $('#chartSummaryContent').html('<div class="alert alert-danger">Failed to load chart data.</div>');
                 }
             });
         });

  });
</script>
