<?php
session_start();
ob_start();
$first_name = $_SESSION['first_name'];
include('../../connection/connection.php');

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include '../includes/styles.php' ?>
    <title>Document</title>
</head>
<body>

<a href="/dental_appointment/auth/logout.php">Logout</a>
    <div class="wrapper">
        <?php include '../includes/sidebar.php'; ?>

      <div class="main-panel">
        <?php include '../includes/topbar.php'; ?>
        <div class="container">
          <div class="page-inner">
            <div class="page-header">
              <h4 class="page-title">Home</h4>
            </div>
            <div class="page-category">
                <h1>Welcome <?= $first_name; ?></h1>
            </div>
          </div>
        </div>
      </div>
    </div>
    <a href="appointments.php">Appointment</a>
    <?php include "../includes/scripts.php"; ?>
</body>
</html>