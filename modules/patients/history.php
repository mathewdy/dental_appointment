<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/Appointments/appointments.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$first_name = $_SESSION['first_name'];
$user_id_patients = $_SESSION['user_id'];
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
                        <h4 class="page-title">History</h4>
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
                              <a href="#">History</a>
                            </li>
                        </ul>
                    </span>    
                </span>
            </div>
            <div class="page-category">
                <div class="card p-5">
                  <div class="table-responsive">
                    <table class="display table table-striped table-hover" id="dataTable">
                      <thead>
                        <tr>
                            <th>Appointment Date & Time</th>
                            <th>Dentist</th>
                            <th>Concern</th>
                            <th>Doctor's Remarks</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>  
                      </thead>
                      <tbody>
                        <?php
                          $run_appointments = getAllRequestsById($conn, $user_id_patients);
                          if(mysqli_num_rows($run_appointments) > 0){
                              foreach($run_appointments as $row_appointment){
                                  ?>
                                  <tr>
                                      <td><?php echo $row_appointment['appointment_date']. " " . $row_appointment['appointment_time']?></td>
                                      <td>Dr. <?php echo $row_appointment['doctor_first_name'] . " " . $row_appointment['doctor_last_name']?></td>
                                  <td><?php echo $row_appointment['concern']?></td>
                                  <td><?php echo $row_appointment['remarks'] ? $row_appointment['remarks'] : 'N/A' ?></td>
                                  <td>
                                    <?php 
                                      if($row_appointment['confirmed'] === '1'){
                                        echo "Completed";
                                      }elseif($row_appointment['confirmed'] === '2'){
                                        echo "Cancelled";
                                      }elseif($row_appointment['confirmed'] === '3') {
                                        echo "Pending";
                                      }else{
                                        echo "Pending";
                                      }
                                    ?>
                                  </td>
                                  <td class="d-flex justify-content-center">
                                    <a class="btn btn-sm btn-outline-primary rounded-circle d-flex justify-content-center align-items-center" style="width: 12px;" data-bs-toggle="dropdown" aria-expanded="false">
																				<i class="fas fa-ellipsis-v"></i>
																		</a>
																		<ul class="dropdown-menu">
                                      <li>
                                        <a class="dropdown-item payment-history" 
                                          href="#"
                                          data-bs-toggle="modal" data-bs-target="#paymentHistoryDialog"
                                          data-appointment="<?= $row_appointment['appointment_id']?>"
                                        >
                                          Payment History
                                        </a>
                                      </li>
                                    </ul>

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
          </div>
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