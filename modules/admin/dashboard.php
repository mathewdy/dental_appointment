<?php
session_start();
ob_start();
<<<<<<< Updated upstream
$first_name = $_SESSION['first_name'];
=======
>>>>>>> Stashed changes

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

<<<<<<< Updated upstream
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
    <?php include "../includes/scripts.php"; ?>
=======
    <a href="add-dentist.php">Add Dentist</a>
    <a href="view-dentists.php">View Dentists</a>
    <a href="/dental_appointment/auth/logout.php">Logout</a>
>>>>>>> Stashed changes
</body>
</html>