<?php
include('../../connection/connection.php');
ob_start();
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$first_name = $_SESSION['first_name'];
include('../../includes/security.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <a href="dashboard.php">Back</a>
    <!-- <h1>Services</h1>

    <table>

    <tr>
        <th>Service</th>
        <th>Initial Price</th>
        <th>Maximum Price</th>
    </tr>
        
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

    </table> -->

    <h2>Payments of Patient</h2>

    <table>
        <tr>
            <th>Name</th>
            <th>Actions</th>
        </tr>

        <?php

            $query_patients = " SELECT DISTINCT users.user_id, users.first_name, users.last_name
            FROM users 
            INNER JOIN appointments ON users.user_id = appointments.user_id_patient 
            WHERE appointments.confirmed = '1' AND users.role_id = '1'";
            $run_patients = mysqli_query($conn,$query_patients);

            if(mysqli_num_rows($run_patients) > 0){
                foreach($run_patients as $row_patients){
                    ?>

                        <tr>
                            <td><?php echo $row_patients['first_name']. " " . $row_patients['last_name']?></td>
                            <td>
                                <a href="view-patient-payments.php?user_id=<?php echo $row_patients['user_id']?>">View</a>
                            </td>
                        </tr>

                    <?php
                }
            }

        ?>
    </table>
</body>
</html>