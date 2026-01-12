<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Appointments/appointments.php');

// Debug mode - comment out for production
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$first_name = $_SESSION['first_name'];
$user_id_patients = $_GET['user_id'] ?? 0;
?>

    <div class="wrapper">
      <?php include '../../includes/sidebar.php'; ?>
      <div class="main-panel">
        <?php include '../../includes/topbar.php'; ?>
        <div class="container">
          <div class="page-inner">
            <div class="page-header">
              <div class="d-flex align-items-center gap-4 w-100">
                <h4 class="page-title text-truncate">Patients</h4>
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
                    <a href="patients.php" class="text-decoration-none text-truncate text-muted">Patients</a>
                  </div>
                  <div class="separator">
                    <i class="icon-arrow-right fs-bold"></i>
                  </div>
                  <div class="nav-item">
                    <a href="#" class="text-decoration-none text-truncate text-muted">Medical History</a>
                  </div>
                </div>
                <a href="../admin/dental-chart.php?user_id=<?= $user_id_patients ?>" class="btn btn-sm btn-dark op-7 me-2">
                    <i class="fas fa-tooth me-1"></i>Dental Chart
                </a>
                <a href="patients.php" class="btn btn-sm btn-secondary">Back</a>
              </div>
            </div>
            <div class="page-category">
                <div class="card p-5">
                  <div class="table-responsive">
                    <table class="display table table-striped table-hover" id="dataTable">
                      <thead>
                        <tr>
                            <th>History</th>
                            <th>Current Medications</th>
                            <th>Allergies</th>
                            <th>Past Surgeries</th>
                        </tr>  
                      </thead>
                      <tbody>
                        <?php

                        if($user_id_patients){   

                        $query_history = "SELECT * FROM medical_history WHERE user_id = '$user_id_patients'";
                        $run_history = mysqli_query($conn, $query_history);
                        if(mysqli_num_rows($run_history) > 0){
                            foreach($run_history as $row_appointment){
                            ?>
                                <tr>
                                    <td><?php echo $row_appointment['history']; ?></td>
                                    <td><?php echo $row_appointment['current_medications']; ?></td>
                                    <td><?php echo $row_appointment['allergies']; ?></td>
                                    <td><?php echo $row_appointment['past_surgeries']; ?></td>
                                    
                                </tr>
                            <?php
                            }
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

    
  </div>
<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/scripts.php'); 
?>