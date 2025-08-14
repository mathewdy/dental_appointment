<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/Payments/payments.php');

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
                                        <a href="#">Payments</a>
                                    </li>
                                </ul>
                            </span>    
                        </span>
                    </div>
                    <div class="page-category">
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- <table class="table">
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
                                </table>  -->
                                <!-- <h2>Payments of Patient</h2> -->
                                <div class="card p-4">
                                    <div class="table-responsive">
                                        <table class="display table" id="dataTable">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th style="width:10%;">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $run_patients = getAllPayment($conn);
                                                    if(mysqli_num_rows($run_patients) > 0){
                                                        foreach($run_patients as $row_patients){
                                                            ?>
                                                                <tr>
                                                                    <td><?php echo $row_patients['first_name']. " " . $row_patients['last_name']?></td>
                                                                    <td style="width:10%;">
                                                                        <a href="view-patient-payments.php?user_id=<?php echo $row_patients['user_id']?>">View</a>
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