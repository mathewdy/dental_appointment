<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/security.php');

$first_name = $_SESSION['first_name'];
$user_id_patient = $_SESSION['user_id'];
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../../includes/security.php');
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
                                $query_appointments = "SELECT appointments.user_id, appointments.user_id_patient, appointments.concern, appointments.appointment_date, users.first_name, users.middle_name, users.last_name, schedule.start_time, schedule.end_time, appointments.confirmed, appointments.appointment_time, appointments.appointment_id
                                FROM appointments
                                LEFT JOIN users
                                ON
                                appointments.user_id_patient = users.user_id
                                LEFT JOIN schedule 
                                ON appointments.user_id = schedule.user_id";
                                $run_appointments = mysqli_query($conn,$query_appointments);
                                if(mysqli_num_rows($run_appointments) > 0){
                                    foreach($run_appointments as $row_appointment){
                                        ?>
                                        <tr>
                                            <td><?php echo $row_appointment['first_name'] . " " . $row_appointment['last_name']?></td>
                                            <td><?php echo $row_appointment['appointment_date']. " ". $row_appointment['appointment_time']?></td>
                                            <td>Dr. <?php echo $row_appointment['first_name'] . " " . $row_appointment['last_name']?></td>
                                            <td><?php echo $row_appointment['concern']?></td>
                                            <td>
                                                <?php
                                                    $handler = match($row_appointment['confirmed']){
                                                        '1' => '<span class="badge bg-success">Confirmed</span>',
                                                        '2' => '<span class="badge bg-danger">Cancelled</span>',
                                                        default => '<span class="badge bg-warning">Pending</span>'
                                                    };
                                                    echo $handler;
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                    if(!$row_appointment['confirmed']){
                                                        ?>
                                                        <form action="" method="POST" onsubmit="return confirm('Confirmed? Yes or No');">
                                                            <input type="submit" name="update_status" value="Update Status" class="btn btn-sm btn-primary">
                                                            <input type="hidden" name="appointment_id" value="<?php echo $row_appointment['appointment_id']?>">
                                                        </form>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <span class="d-flex align-items-center justify-content-center">
                                                            <p class="text-muted p-0 m-0">Update Status </p>
                                                        </span>
                                                        <?php
                                                    }
                                                ?>  
                                               
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

if(isset($_POST['update_status'])){
    date_default_timezone_set("Asia/Manila");
    $date = date('y-m-d');

    $appointment_id = $_POST['appointment_id'];
    $update_query = "UPDATE appointments SET confirmed = '1', date_updated = '$date' WHERE appointment_id = '$appointment_id' ";
    $run_query = mysqli_query($conn,$update_query);

    if($run_query){
        echo "<script>window.location.href='requests.php'</script>";
    }else{
        echo "error";
    }
}

?>