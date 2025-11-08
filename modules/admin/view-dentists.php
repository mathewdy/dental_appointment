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
                                        <td>
                                          <div class="d-flex justify-content-center align-items-center">
                                            <a class="text-info h4 mx-2" href="edit-dentist.php?user_id=<?php echo$row_dentist['user_id']?>" class="dropdown-item"><i class="fas fa-edit"></i></a>
                                            <a class="text-danger h4 delete" href="delete-dentist.php?user_id=<?php echo $row_dentist['user_id']?>" class="dropdown-item delete-btn"><i class="fas fa-trash"></i></a>
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
<script>
$(document).ready(function() {
  $('.delete').on('click', function(e) {
    e.preventDefault();
    confirmBeforeRedirect("Do you want to delete this dentist?", $(this).attr('href'))
  });
});
</script>