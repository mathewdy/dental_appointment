<?php
session_start();
ob_start();
include('../../connection/connection.php');

$first_name = $_SESSION['first_name'];
$email = $_SESSION['email'];
$roleId = $_SESSION['role_id'];

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
                        <h4 class="page-title">My Profile</h4>
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
                                <a href="my-profile.php">Profile</a>
                            </li>
                        </ul>
                    </span>    
                </span>
            </div>
            <div class="page-category">
                <?php


                $query_profile = "SELECT * FROM users WHERE email =  '$email' AND role_id = '$roleId'";
                $run_profile = mysqli_query($conn,$query_profile);

                if(mysqli_num_rows($run_profile) > 0){
                    foreach($run_profile as $row_profile){
                        $name = $row_profile['first_name'] . " " . $row_profile['last_name'];
                        ?>
                        <div class="row p-5">
                            <div class="col-lg-12">
                                <div class="row ">
                                    <div class="col-lg-4">
                                        <img src="../../assets/img/default.jpg" alt="img" height="250">
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <span class="d-flex justify-content-between align-items-center">
                                                    <p class="h1"><?= $name; ?></p>
                                                    <a class="btn btn-black op-8" href="edit-profile.php?user_id=<?php echo $row_profile['user_id']?>">Edit</a>
                                                    <!-- <a class="btn btn-black op-8" href="edit-profile.php?user_id=<?= $_SESSION['user_id']?>">Edit</a> -->
                                                </span>
                                                <p class="h5"><?= "ID" . $row_profile['user_id'];?></p>
                                                <br>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 mt-5">
                                                <h1 style="text-decoration: underline;">About</h1>
                                                <br>
                                                <br>
                                                <p class="text-muted">CONTACT INFORMATION</p>
                                                <div class="row align-items-center">
                                                    <div class="col-lg-2">
                                                        <p class="h5">Phone: </p>
                                                    </div>
                                                    <div class="col-lg-10 ">
                                                        <p class="h6"><?= $row_profile['mobile_number']?></p>
                                                    </div>
                                                </div>
                                                <div class="row align-items-center">
                                                    <div class="col-lg-2">
                                                        <p class="h5">Email: </p>
                                                    </div>
                                                    <div class="col-lg-10 ">
                                                        <p class="h6"><?= $row_profile['email']?></p>
                                                    </div>
                                                </div>
                                                <br>
                                                <br>
                                                <p class="text-muted">BASIC INFORMATION</p>
                                                <div class="row align-items-center">
                                                    <div class="col-lg-2">
                                                        <p class="h5">Birthday: </p>
                                                    </div>
                                                    <div class="col-lg-10 ">
                                                        <p class="h6"><?= $row_profile['date_of_birth']?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

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