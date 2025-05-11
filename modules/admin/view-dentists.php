<?php
include('../../connection/connection.php');
session_start();
ob_start();
$first_name = $_SESSION['first_name'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include '../../includes/styles.php' ?>
    <title>Document</title>
</head>
<body>

    <div class="wrapper">
        <?php include '../../includes/sidebar.php'; ?>

      <div class="main-panel">
        <?php include '../../includes/topbar.php'; ?>
        <div class="container">
          <div class="page-inner">
            <div class="page-header">
              <span class="d-flex justify-content-between align-items-center w-100">
                    <span class="d-flex">
                        <h4 class="page-title">Dentists</h4>
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
                                <a href="#">Dentists</a>
                            </li>
                        </ul>
                    </span>    
                    <a href="add-dentist.php" class="btn btn-dark op-7">Add New Dentist</a>
                </span>
            </div>
            <div class="page-category">
                <div class="card py-3">
                    <div class="table-responsive">
                    <table id="dataTable" class="display table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Schedule</th>
                                <th>Email</th>
                                <th>Contact Number</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            //errors
                            ini_set('display_errors', 1);
                            ini_set('display_startup_errors', 1);
                            error_reporting(E_ALL);

                            $query_dentists = "SELECT users.user_id AS user_id, users.first_name AS first_name, users.middle_name AS middle_name, users.last_name AS last_name, users.mobile_number AS mobile_number, users.email AS email, schedule.user_id AS schedule_user_id, schedule.day AS day , schedule.start_time AS start_time, schedule.end_time AS end_time
                            FROM
                            users 
                            LEFT JOIN schedule 
                            ON users.user_id = schedule.user_id 
                            WHERE users.role_id = '3'";
                            $run_dentists = mysqli_query($conn,$query_dentists);

                            if(mysqli_num_rows($run_dentists) > 0){
                                foreach($run_dentists as $row_dentist){
                                    ?>

                                    <tr>
                                        <td><?php echo $row_dentist['user_id']?></td>
                                        <td><?php echo $row_dentist['first_name']. " " . $row_dentist['middle_name'] . " " . $row_dentist['last_name']?></td>
                                        <td><?php echo $row_dentist['day']. " " . date("g:i A",strtotime($row_dentist['start_time'])). "& " . date("g:i A", strtotime($row_dentist['end_time'])) ?></td>
                                        <td><?php echo $row_dentist['email']?></td>
                                        <td><?php echo $row_dentist['mobile_number']?></td>
                                        <td>
                                            <a href="edit-dentist.php?user_id=<?php echo$row_dentist['user_id']?>">Edit</a>
                                            <a href="delete-dentist.php?user_id=<?php echo $row_dentist['user_id']?>">Delete</a>
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
    <?php include "../../includes/scripts.php"; ?>

</body>
</html>