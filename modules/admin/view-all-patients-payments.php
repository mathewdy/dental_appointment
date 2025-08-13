<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/security.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$first_name = $_SESSION['first_name'];
?>


    <?php
    if (isset($_GET['payment_id']) && isset($_GET['service']) && isset($_GET['user_id'])) {
        $user_id = $_GET['user_id'];
        $concern = $_GET['service'];
    }
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
                                        <a href="#">Payments</a>
                                    </li>
                                    <li class="separator">
                                        <i class="icon-arrow-right"></i>
                                    </li>
                                    <li class="nav-item">
                                        <a href="view-patient-payments.php?user_id=<?php echo $user_id ?>&concern=<?php echo $concern ?>">View</a>
                                    </li>
                                    <li class="separator">
                                        <i class="icon-arrow-right"></i>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#">Payment history</a>
                                    </li>
                                </ul>
                            </span>    
                        </span>
                    </div>
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
                    <div class="page-category">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card p-4">
                                    <div class="table-responsive">
                                        <table class="display table" id="dataTable">
                                            <thead>
                                                <tr>
                                                    <th>Payment Received</th>
                                                    <th>Payment Method</th>
                                                    <th>Date Created</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                    if(isset($_GET['payment_id'])&isset($_GET['service'])&isset($_GET['user_id'])){
                                                        $payment_id = $_GET['payment_id'];
                                                        $user_id = $_GET['user_id'];
                                                        $concern = $_GET['service'];

                                                        $query_all_history = "SELECT * FROM payment_history WHERE payment_id = '$payment_id'";
                                                        $run_all_history = mysqli_query($conn,$query_all_history);

                                                        if(mysqli_num_rows($run_all_history) > 0){
                                                            foreach($run_all_history as $row_history){
                                                                ?>

                                                                    <tr>
                                                                        <td><?php echo $row_history['payment_received']?></td>
                                                                        <td><?php echo $row_history['payment_method']?></td>
                                                                        <td><?php echo $row_history['date_created']?></td>
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
                            <div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
<?php 
  include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/scripts.php');
?>
