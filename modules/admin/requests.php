<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/Appointments/appointments.php');

$first_name = $_SESSION['first_name'];
$user_id_patient = $_SESSION['user_id'];
?>
<style>
  .dataTable_wrapper input {
    padding: 20px 12px !important;
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
                        <h4 class="page-title">Appointment Requests</h4>
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
                                <a href="appointments.php">Appointments</a>
                            </li>
                            <li class="separator">
                                <i class="icon-arrow-right"></i>
                            </li>
                            <li class="nav-item">
                                <a href="#">Requests</a>
                            </li>
                        </ul>
                    </span>    
                </span>
            </div>
            <div class="page-category">
              <div class="card p-5">
                <div class="table-responsive">
                  <table class="display table table-border table-hover" id="dataTable">
                    <thead>
                        <tr>
                            <th>Name of Patient</th>
                            <th>Date & Time</th>
                            <th>Doctor</th>
                            <th>Concern</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php
                        $run_appointments = getAllRequests($conn);
                        if(mysqli_num_rows($run_appointments) > 0){
                          foreach($run_appointments as $row_appointment){
                          ?>
                          <tr>
                            <td><?php echo $row_appointment['patient_first_name'] . " " . $row_appointment['patient_last_name']?></td>
                            <td><?php echo $row_appointment['appointment_date']. " ". $row_appointment['appointment_time']?></td>
                            <td>Dr. <?php echo $row_appointment['doctor_first_name'] . " " . $row_appointment['doctor_last_name']?></td>
                            <td><?php echo $row_appointment['concern']?></td>
                            <td>
                              <?php
                                $handler = match($row_appointment['confirmed']){
                                    1 => '<span class="badge text-dark text-body-secondary fw-bold" style="background: #94f7c9; border: #94f7c9;"><i class="fas fa-check-circle"></i> Confirmed</span>',
                                    2 => '<span class="badge text-dark text-body-secondary fw-bold" style="background: #f79494; border: #f79494;"><i class="fas fa-times-circle"></i> Cancelled</span>',
                                    3 => '<span class="badge text-dark text-body-secondary fw-bold" style="background: #fab273; border: #fab273;"><i class="fas fa-times"></i> No Show</span>',
                                    default => '<span class="badge text-dark text-body-secondary fw-bold" style="background: #fae373; border: #fae373;"><i class="fas fa-clock"></i> Pending</span>'
                                };
                                echo $handler;
                              ?>
                            </td>
                            <td>
                              <div class="d-flex justify-content-start align-items-center">
                                <?php 
                                    if(!$row_appointment['confirmed']){
                                      ?>
                                      <div class="dropdown">
                                        <button class="btn btn-sm btn-primary rounded dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                          Update Status 
                                        </button>
                                        <ul class="dropdown-menu" style="width: 20rem;">
                                          <li class="px-3">
                                            <p class="h6 fw-bold">
                                              Update Appointment Status
                                            </p>
                                          </li>
                                          <li><hr class="dropdown-divider"></li>
                                          <li>
                                            <a class="dropdown-item status" href="request-action.php?id=<?= $row_appointment['appointment_id']?>&status=1">
                                              <div class="d-flex align-items-center">
                                                <i class="fas fa-lg fa-check-circle me-3 text-success"></i>
                                                <div>
                                                  <p class="h6 fw-bold p-0 m-0 text-success">Confirm Appointment</p>
                                                  <p class="lh-1 text-muted p-0 m-0">Mark as confirmed</p>
                                                </div>
                                              </div>  
                                            </a>
                                          </li>
                                          <li>
                                            <a class="dropdown-item status" href="request-action.php?id=<?= $row_appointment['appointment_id']?>&status=2">
                                              <div class="d-flex align-items-center">
                                                <i class="fas fa-lg fa-times-circle me-3 text-danger"></i>
                                                <div>
                                                  <p class="h6 fw-bold p-0 m-0 text-danger">Cancel Appointment</p>
                                                  <p class="lh-1 text-muted p-0 m-0">Mark as cancelled</p>
                                                </div>
                                              </div>  
                                            </a>
                                          </li>
                                          <li>
                                            <a class="dropdown-item status" href="request-action.php?id=<?= $row_appointment['appointment_id']?>&status=3">
                                              <div class="d-flex align-items-center">
                                                <i class="fas fa-lg fa-calendar me-3 text-warning"></i>
                                                <div>
                                                  <p class="h6 fw-bold p-0 m-0 text-warning">Mark No Show</p>
                                                  <p class="lh-1 text-muted p-0 m-0">Patient did not show up</p>
                                                </div>
                                              </div>  
                                            </a>
                                          </li>
                                        </ul>
                                      </div>
                                      <!-- <form action="" method="POST">
                    
                                        <input type="submit" value="Update Status" class="btn btn-sm btn-primary">
                                        
                                        <input type="hidden" name="appointment_id" value="<?php echo $row_appointment['appointment_id']?>">
                                      </form> -->
                                      <?php
                                    }else{
                                        ?>
                                        <button class="btn btn-sm btn-primary rounded dropdown-toggle disabled" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                          Update Status 
                                        </button>
                                        <?php
                                    }
                                ?>  
                              </div>
                            </td>
                          </tr>
                        <?php
                        }
                    }else{
                        echo "No Data";
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
<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/scripts.php'); 
?>
<script>
  document.querySelectorAll('.dropdown-toggle').forEach(el => {
  new bootstrap.Dropdown(el, {
    popperConfig: {
      strategy: 'fixed',
      modifiers: [
        {
          name: 'preventOverflow',
          options: { boundary: document.body }
        }
      ]
    }
  });
});
</script>
<script>
$(document).ready(function() {
  $('.status').on('click', function(e) {
    e.preventDefault();
    confirmBeforeRedirect("Do you want to update this appointment?", $(this).attr('href'))
  });
});
</script>
<script>
$(document).ready(function () {
  var table = $('#dataTable').DataTable();
  var customFilter = `
    <div class="col-sm-12 col-md-4 customFilterCol">
      <select id="statusFilter" class="form-control form-control-sm d-inline-block w-auto">
        <option value="">All</option>
        <option value="Confirmed">Confirmed</option>
        <option value="Cancelled">Cancelled</option>
        <option value="Pending">Pending</option>
        <option value="No Show">No Show</option>
      </select>
    </div>
  `;

  var topRow = $('.dataTables_wrapper .row:first');
  topRow.find('.col-sm-12.col-md-6')
    .removeClass('col-md-6')
    .addClass('col-md-4');

  topRow.find('.col-md-4').first().after(customFilter);

  $('#statusFilter').on('change', function () {
    var val = $(this).val();
    table
      .column(4)
      .search(val ? val : '', true, false)
      .draw();
  });
});
</script>


<?php
if(isset($_POST['update_status'])){
  $appointment_id = $_POST['appointment_id'];

  $run_query = updateStatus($conn, $appointment_id);
  if($run_query){
		echo "<script> success('Updated successfully.', () => window.location.href = 'requests.php') </script>";
	}else{
		echo "<script> error('Something went wrong!', () => window.location.href = 'requests.php') </script>";
	}
}

?>