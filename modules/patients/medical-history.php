<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Appointments/appointments.php');

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
              <div class="d-flex align-items-center gap-4">
                <h4 class="page-title text-truncate">Medical History</h4>
                <div class="d-flex align-items-center gap-2">
                  <div class="nav-home">
                    <a href="dashboard.php" class="text-decoration-none text-muted">
                      <i class="icon-home"></i>
                    </a>
                  </div>
                  <div class="separator">
                    <i class="icon-arrow-right fs-bold"></i>
                  </div>
                  <div class="nav-item">
                    <a href="#" class="text-decoration-none text-truncate text-muted">Medical History</a>
                  </div>
                </div>
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