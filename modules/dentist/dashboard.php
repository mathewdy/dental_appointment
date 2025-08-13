<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/security.php');
$first_name = $_SESSION['first_name'];
?>
    <div class="wrapper">
        <?php include '../../includes/sidebar.php'; ?>

      <div class="main-panel">
        <?php include '../../includes/topbar.php'; ?>
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
<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/scripts.php'); 
?>