<?php
session_start();
ob_start();
include('../../connection/connection.php');

$first_name = $_SESSION['first_name'];
$email = $_SESSION['email'];


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
              <h4 class="page-title">My Profile</h4>
            </div>
            <div class="page-category">
                <h1>My profile</h1>
                <?php


                $query_profile = "SELECT * FROM users WHERE email =  '$email'";
                $run_profile = mysqli_query($conn,$query_profile);

                if(mysqli_num_rows($run_profile) > 0){
                    foreach($run_profile as $row_profile){
                        ?>

                        <label for="">Name</label>
                        <p><?php echo $row_profille['first_name']. " " . $row_profile['middle_name']. " " . $row_profile['last_name']?></p>
                        <label for="">Mobile Number</label>
                        <p><?php echo $row_profile['mobile_number']?></p>
                        <label for="">Email</label>
                        <p><?php echo $row_profile['email']?></p>
                        <label for="">Date of Birth</label>
                        <p><?php echo $row_profile['date_of_birth']?></p>
                        <a href="edit-profile.php?user_id=<?php echo $row_profile['user_id']?>">Edit</a>

                        <?php
                    }
                }

                ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include "../../includes/scripts.php"; ?>
</body>
</html>