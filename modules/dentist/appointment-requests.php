<?php
include('../../connection/connection.php');
ob_start();
session_start();
$first_name = $_SESSION['first_name'];
$user_id = $_SESSION['user_id'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include '../../includes/styles.php'; ?>
    <title>Document</title>
</head>
<body>
    <div class="wrapper">
      <?php 
    //   include '../../includes/sidebar.php'; 
      ?>
      <div class="main-panel">
        <?php 
        // include '../../includes/topbar.php'; 
        ?>
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
                                <a href="view-appointments.php">Appointments</a>
                            </li>
                            <li class="separator">
                                <i class="icon-arrow-right"></i>
                            </li>
                            <li class="nav-item">
                                <a href="#">Appointment Requests</a>
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
                            <th>Concern</th>
                            <th>Remarks</th>
                            <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                                <?php
                                $query_appointments = "SELECT appointments.user_id, appointments.user_id_patient, appointments.concern, appointments.appointment_date, users.first_name, users.middle_name, users.last_name, schedule.start_time, schedule.end_time, appointments.confirmed , appointments.remarks
                                FROM appointments
                                LEFT JOIN users
                                ON
                                appointments.user_id = users.user_id
                                LEFT JOIN schedule 
                                ON appointments.user_id = schedule.user_id WHERE users.user_id = '$user_id'";
                                $run_appointments = mysqli_query($conn,$query_appointments);
                                if(mysqli_num_rows($run_appointments) > 0){
                                    foreach($run_appointments as $row_appointment){
                                        echo '<form action="accepted.php" method="POST">';
                                        ?>
                                        <tr>
                                            <td><?php echo $row_appointment['first_name']. " " . $row_appointment['last_name']?></td>
                                            <td><?php echo $row_appointment['appointment_date']. " " . date("g:i A",strtotime($row_appointment['start_time'])). "-". date("g:i A",strtotime($row_appointment['end_time']))?></td>
                                            <td><?php echo $row_appointment['concern']?></td>
                                            <td>

                                            <?php
                                            $status = (int)$row_appointment['confirmed'];
                                            if ($status === 0) {
                                                ?>
                                                    <input type="text" name="remarks">
                                                <?php
                                            }elseif ($status === 1){
                                                ?>
                                                <p><?php echo $row_appointment['remarks']?></p>
                                                <?php

                                            }elseif($status === 2){
                                                echo "Cancelled";
                                            }
                                                
                                            ?>
                                            
                                            
                                            </td>
                                            <td>

                                            <?php
                                                $status = (int)$row_appointment['confirmed'];
                                                if ($status === 1) {
                                                    echo '<span class="badge bg-success">Confirmed</span>';                                                  
                                                }
                                                elseif ($status === 2) {
                                                    echo '<span class="badge bg-danger">Cancelled</span>';  
                                                }elseif ($status === 0) {
                                                    ?>
                                                
                                                        <input type="hidden" name="appointment_date" value="<?php echo $row_appointment['appointment_date']?>">
                                                        <input type="hidden" name="user_id_patient" value="<?php echo $row_appointment['user_id_patient']?>">
                                                        <input type="submit" name="accept" value="Confirm">

                                                    
                                                    <?php
                                                }
                                                ?>
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
<?php include "../../includes/scripts.php"; ?>
</body>
</html>

<?php 
if(isset($_POST['accept'])){
    echo "<script>alert('fuckwit')</script>";
}
?>