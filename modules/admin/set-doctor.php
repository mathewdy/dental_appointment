<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/Users/dentists.php');

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
                <h4 class="page-title text-truncate">Set Doctor</h4>
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
                    <a href="patients.php" class="text-decoration-none text-truncate text-muted">Patient</a>
                  </div>
                  <div class="separator">
                    <i class="icon-arrow-right fs-bold"></i>
                  </div>
                  <div class="nav-item">
                    <a href="#" class="text-decoration-none text-truncate text-muted">Set Doctor</a>
                  </div>
                </div>
              </div>
            </div>

            <div class="page-category">
                <div class="card p-5">
                    <div class="table-responsive">
                        <table class="display table table-hover table-striped table-bordered" id="dataTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Schedule</th>
                                    <th>Walk-in Booking</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <?php

                                    if(isset($_GET['user_id_patient'])){
                                        $user_id_patient = $_GET['user_id_patient'];

                                        $run_dentist = getAllDentist($conn, '3');
                                        $all_dentists = mysqli_fetch_all($run_dentist, MYSQLI_ASSOC);
                                        foreach ($all_dentists as $row_dentist) {
                                        ?>

                                            <form action="" method="GET">
                                                <tr>
                                                    <td><?php echo "Dr. " . $row_dentist['first_name'] . " " . $row_dentist['last_name']?></td>
                                                    <td><?php echo $row_dentist['day']. " " . date("g:i A",strtotime($row_dentist['start_time'])) . " - " . date("g:i A", strtotime($row_dentist['end_time']))?></td>
                                                    <td class="text-center">
                                                        <a href="set-schedule.php?user_id_dentist=<?= $row_dentist['user_id']; ?>&user_id_patient=<?= $user_id_patient; ?>" class="btn btn-sm btn-primary">
                                                          Proceed
                                                        </a>
                                                    </td>
                                                </tr>
                                            </form>

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
<?php 
  include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/scripts.php');
?>
