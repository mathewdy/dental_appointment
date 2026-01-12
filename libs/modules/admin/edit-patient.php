<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Users/users.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Users/patients.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$first_name = $_SESSION['first_name'];

?>


<div class="wrapper">
<?php 
include '../../includes/sidebar.php'; 
?>

<div class="main-panel">
    <?php 
    include '../../includes/topbar.php'; 
    ?>
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
                  <a href="#" class="text-decoration-none text-truncate text-muted">Edit</a>
                </div>
              </div>
            </div>
          </div>
            <div class="page-category">
              <?php
              if(isset($_GET['user_id'])){
                $user_id_patient = $_GET['user_id'];

                $run_patients = getPatientById($conn, $user_id_patient);
                if(mysqli_num_rows($run_patients) > 0){
                    foreach($run_patients as $row_patients){
                      ?>
                      <form action="" method="POST">
                        <div class="row gap-2">
                            <div class="col-lg-12">
                                <div class="card p-4 shadow-none form-card rounded-1">
                                    <div class="card-header">
                                        <h3>Basic Information</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row gap-4">
                                            <div class="col-lg-12">
                                                <div class="row d-flex align-items-center w-100">
                                                    <div class="col-lg-2">
                                                        <label for="first_name">First Name</label>
                                                    </div>
                                                    <div class="col-lg-10">
                                                        <input type="text" class="form-control" name="first_name" value="<?php echo $row_patients['first_name']?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="row d-flex align-items-center w-100">
                                                    <div class="col-lg-2">
                                                        <label for="">Middle Name</label>
                                                    </div>
                                                    <div class="col-lg-10">
                                                        <input type="text" class="form-control" name="middle_name" value="<?php echo $row_patients['middle_name']?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="row d-flex align-items-center w-100">
                                                    <div class="col-lg-2">
                                                        <label for="">Last Name</label>
                                                    </div>
                                                    <div class="col-lg-10">
                                                        <input type="text" class="form-control" name="last_name" value="<?php echo $row_patients['last_name']?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="row d-flex align-items-center w-100">
                                                    <div class="col-lg-2">
                                                        <label for="">Mobile Number </label>
                                                    </div>
                                                    <div class="col-lg-10">
                                                        <input type="text" class="form-control" name="mobile_number" value="<?php echo $row_patients['mobile_number']?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="row d-flex align-items-center w-100">
                                                    <div class="col-lg-2">
                                                        <label for="">Date of Birth</label>
                                                    </div>
                                                    <div class="col-lg-10">
                                                        <input type="date" class="form-control" name="date_of_birth" value="<?php echo $row_patients['date_of_birth']?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="row d-flex align-items-center w-100">
                                                    <div class="col-lg-2">
                                                        <label for="">Address</label>
                                                    </div>
                                                    <div class="col-lg-10">
                                                        <input type="text" class="form-control" name="address" value="<?php echo $row_patients['address']?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                              <div class="card p-4 shadow-none form-card rounded-1">
                                  <div class="card-header">
                                    <h3>Account</h3>
                                  </div>
                                  <div class="card-body">
                                    <div class="row gap-4">
                                      <div class="col-lg-12">
                                        <div class="row d-flex align-items-center w-100">
                                          <div class="col-lg-2">
                                            <label for="">Email</label>
                                          </div>
                                          <div class="col-lg-10">
                                            <input type="email" class="form-control" name="email" value="<?php echo $row_patients['email']?>">
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-lg-12">
                                        <hr class="featurette-divider">
                                          <p class="h5">Send Reset Password</p>
                                          <a href="javascript:void(0)" data-href="send_reset_password.php?email=<?= $row_patients['email']?>" class="btn btn-sm btn-primary send-email">Send Email</a>
                                      </div>
                                    </div>
                                  </div>
                              </div>
                          </div>
                        </div>
                        <div class="col-lg-12 text-end">
                          <a href="patients.php" class="btn btn-sm btn-danger">Cancel</a>
                          <input type="submit" class="btn btn-sm btn-primary" value="Save">	
                          <input type="hidden" name="update" value="1">
                        </div>
                      </div>
                    </form>
                  <?php
                    }
                  }
                }
                ?>
                                            
                    <!-- <div class="col-lg-12">
                        <div class="card p-5">
                            <h2>Patient's Appointment</h2>
                            <table>
                                    <tr>
                                        <th>Date</th>
                                        <th>Concern</th>
                                        <th>Status</th>
                                        <th>Dentist</th>
                                    </tr>

                                    <?php

                                    $query_appointment = "SELECT appointments.user_id, appointments.user_id_patient, appointments.appointment_id, appointments.concern, appointments.appointment_date, appointments.confirmed, appointments.walk_in, users.first_name, users.last_name
                                    FROM appointments
                                    LEFT JOIN users
                                    ON appointments.user_id = users.user_id 
                                    WHERE appointments.user_id_patient = '$user_id_patient'";
                                    $run_appointment = mysqli_query($conn,$query_appointment);

                                    if(mysqli_num_rows($run_appointment) > 0){
                                        foreach($run_appointment as $row_appointment){
                                            ?>
                                            <tr>
                                                <td><?php echo $row_appointment['appointment_date']?></td>
                                                <td><?php echo $row_appointment['concern']?></td>
                                                <td>
                                                    <?php 
                                                    echo  $status = match($row_appointment['confirmed']){
                                                        '0' => '<span class="badge bg-warning">Pending</span>',
                                                        '1' => '<span class="badge bg-success">Completed</span>',
                                                        '2' => '<span class="badge bg-danger">Canceled</span>'
                                                    };

                                                    ?>
                                                </td>
                                                <td><?php echo "Dr. " . $row_appointment['first_name']. " " . $row_appointment['last_name']?></td>
                                            </tr>

                                            <?php


                                        }
                                    }

                                    
                                    ?>
                                </table>

                        </div> -->
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
<script>
$(document).ready(function() {
    $('form').on('submit', function(e) {
        e.preventDefault()
        confirmBeforeSubmit($(this), "You\'ve made changes. Do you want to save them?")
    })

    $('.send-email').on('click', function(e) {
      var url = $(this).data("href")
      Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to proceed?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Confirm',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#3085d6'
    }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = url
        }
    });
    })
});
</script>
<?php
if(isset($_POST['update'])){
  date_default_timezone_set("Asia/Manila");
  $date = date('y-m-d');
  $first_name = $_POST['first_name'];
  $middle_name = $_POST['middle_name'];
  $last_name = $_POST['last_name'];
  $mobile_number = $_POST['mobile_number'];
  $email = $_POST['email'];
  $date_of_birth = $_POST['date_of_birth'];
  $address = $_POST['address'];
  $user_id_patient = $_GET['user_id'];

  $run_update = updatePatient($conn, $first_name, $middle_name, $last_name, $mobile_number, $email, $date_of_birth, $address, $user_id_patient);
  if($run_update){
    echo "<script> success('Patient updated successfully.', () => window.location.href = 'patients.php') </script>";
  }else{
    echo "<script> error('Something went wrong!', () => window.location.href = 'patients.php') </script>";
  }
}



?>