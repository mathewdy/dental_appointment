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
                        <a href="add-dentist.php" class="btn btn-sm btn-dark op-7">Add New Dentist</a>
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
                                $run_dentists = getAllDentist($conn, "3");
                                if(mysqli_num_rows($run_dentists) > 0){
                                    foreach($run_dentists as $row_dentist){
                                        ?>

                                        <tr>
                                            <td><?php echo $row_dentist['user_id']?></td>
                                            <td><?php echo $row_dentist['first_name']. " " . $row_dentist['middle_name'] . " " . $row_dentist['last_name']?></td>
                                            <td><?php echo $row_dentist['day']. " " . date("g:i A",strtotime($row_dentist['start_time'])). " & " . date("g:i A", strtotime($row_dentist['end_time'])) ?></td>
                                            <td><?php echo $row_dentist['email']?></td>
                                            <td><?php echo $row_dentist['mobile_number']?></td>
                                            <td class="d-flex justify-content-center">
                                                <div class="dropdown">
                                                    <a class="btn btn-sm btn-outline-primary rounded-circle d-flex justify-content-center align-items-center" style="width: 12px;" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </a>
                                                    <ul class="dropdown-menu"> 
                                                        <li>
                                                            <a href="edit-dentist.php?user_id=<?php echo$row_dentist['user_id']?>" class="dropdown-item">Edit</a>
                                                        </li>
                                                        <li>
                                                            <a href="delete-dentist.php?user_id=<?php echo $row_dentist['user_id']?>" 
                                                            class="dropdown-item"
                                                            onclick="return confirm('Are you sure you want to delete this dentist?');">
                                                            Delete
                                                            </a>
                                                        </li>
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
            </div>
        </div>
    </div>
</div>
<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/scripts.php'); 
?>