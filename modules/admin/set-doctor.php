<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/Users/dentists.php');

$first_name = $_SESSION['first_name'];
?>
<style>
    .icon-check:hover{
        color: green;
    }
</style>

    <div class="wrapper">
      <?php include '../../includes/sidebar.php'; ?>
      <div class="main-panel">
        <?php include '../../includes/topbar.php'; ?>
        <div class="container">
          <div class="page-inner">
            <div class="page-header">
            <span class="d-flex justify-content-between align-items-center w-100">
                    <span class="d-flex">
                        <h4 class="page-title">Set Doctor</h4>
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
                            <a href="#">Set Doctor</a>
                            </li>
                        </ul>
                    </span>    
                </span>
            </div>
            <div class="page-category">
                <div class="card p-5">
                    <div class="table-responsive">
                        <table class="display table table-hover table-striped table-bordered" id="dataTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Schedule</th>
                                    <th>Action</th>
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
                                                        <a href="set-schedule.php?user_id_dentist=<?= $row_dentist['user_id']; ?>&user_id_patient=<?= $user_id_patient; ?>" style="text-decoration: none; color: black;"><i class="icon-check fs-2 p-0 m-0"></i></a>
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
