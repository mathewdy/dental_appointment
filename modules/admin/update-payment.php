<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/security.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$first_name = $_SESSION['first_name'];
include('../../includes/security.php');

if(isset($_GET['payment_id'])&isset($_GET['user_id'])&isset($_GET['service'])){
  $user_id = $_GET['user_id'];
  $concern = $_GET['service'];

  ?>
          
  <?php

  $payment_id = $_GET['payment_id'];
  $user_id = $_GET['user_id'];
  $concern = $_GET['service'];

  $query_payment = "SELECT * FROM payments WHERE user_id = '$user_id' AND services = '$concern' AND payment_id = '$payment_id'";
  $run_payment = mysqli_query($conn,$query_payment);

  if(mysqli_num_rows($run_payment) > 0){
      foreach($run_payment as $row_payment){
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
                                <h4 class="page-title">Payments</h4>
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
                                        <a href="#">Payments</a>
                                    </li>
                                    <li class="separator">
                                        <i class="icon-arrow-right"></i>
                                    </li>
                                    <li class="nav-item">
                                        <a href="view-patient-payments.php?user_id=<?php echo $user_id?>&concern=<?php echo $concern?>">View</a>
                                    </li>
                                    <li class="separator">
                                        <i class="icon-arrow-right"></i>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#">New Payment</a>
                                    </li>
                                </ul>
                            </span>    
                        </span>
                    </div>
                    <div class="page-category">
                        <div class="row">
                            <div class="col-lg-12 mb-4">
                            <?php
                                if(isset($_GET['user_id'])){
                                    $user_id = $_GET['user_id'];
                                    $query_patient_name = "SELECT * FROM users WHERE user_id = '$user_id'";
                                    $run_patient_name = mysqli_query($conn,$query_patient_name);
                                    if(mysqli_num_rows($run_patient_name) > 0){
                                        foreach($run_patient_name as $row_patient_name){
                                            ?>
                                                <span>
                                                    <label for="">Patient Name:</label>
                                                    <h1 class="m-0 p-0"><?php echo $row_patient_name['first_name'] . " " . $row_patient_name['last_name']?></h1>
                                                </span>		
                                                
                                            <?php
                                        }
                                    }
                                    
                                }

                            ?>
                                    <form action="" method="POST">
                                      <div class="card p-4 shadow-none form-card rounded-1">
                                        <div class="card-header">
                                            <h3>Make a payment</h3>
                                        </div>
                                        <div class="card-body">
                                          <div class="row gap-4">
                                            <div class="col-lg-12">
                                              <div class="row d-flex align-items-center w-100">
                                                <div class="col-lg-2">
                                                  <label for="">Remaining Balance</label>
                                                </div>
                                                <div class="col-lg-10">
                                                  <input type="text" class="form-control" name="remaining_balance" value="<?php echo $row_payment['remaining_balance']?>" readonly>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="col-lg-12">
                                              <div class="row d-flex align-items-center w-100">
                                                <div class="col-lg-2">
                                                  <label for="">Add Payment</label>
                                                </div>
                                                <div class="col-lg-10">
                                                  <input type="number" class="form-control" name="payment" required>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="col-lg-12 text-end">
                                              <a href="view-patient-payments.php?user_id=<?php echo $user_id?>&concern=<?php echo $concern?>" class="btn btn-sm btn-danger">Cancel</a>
                                              <?php
                                                if($row_payment['remaining_balance'] <= 0) {
                                                  ?>
                                                  <input type="submit" class="btn btn-sm btn-primary disabled" name="add_payment" value="Add Cash Payment">
                                                  <input type="submit" class="btn btn-sm btn-success disabled" name="add_payment_paymogo" value="Add Paymogo Payment">
                                                  <?php
                                                }else{
                                                  ?>
                                                  <input type="submit" class="btn btn-sm btn-primary" name="add_payment" value="Add Cash Payment">
                                                  <input type="submit" class="btn btn-sm btn-success" name="add_payment_paymogo" value="Add Paymogo Payment">
                                                  <?php
                                                }
                                              ?>

                                            </div>
                                    </form>

                                    <?php
                                                }
                                            }
                                        }

                                    ?>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    

    <h1>Make a payment</h1>

 
<?php 
include "../../includes/scripts.php"; 

date_default_timezone_set("Asia/Manila");
$date = date('Y-m-d');

// --------------------
// CASH PAYMENT
// --------------------
if (isset($_POST['add_payment'])) {
    $remaining_balance = floatval($_POST['remaining_balance']);
    $payment = floatval($_POST['payment']);
    $payment_id = $_GET['payment_id'];
    $user_id = $_GET['user_id'];
    $concern = $_GET['service'];

    // Validate: Don't allow payment more than remaining balance
    if ($payment > $remaining_balance) {
        echo "<script>alert('Payment exceeds remaining balance.'); window.history.back();</script>";
        exit();
    }

    $updated_balance = $remaining_balance - $payment;

    $query_update_balance = "UPDATE payments 
        SET remaining_balance = '$updated_balance', 
            is_deducted = '1', 
            date_updated = '$date' 
        WHERE payment_id = '$payment_id'";
    $run_update_balance = mysqli_query($conn, $query_update_balance);

    if ($run_update_balance) {
        $query_insert_payment = "INSERT INTO payment_history 
            (payment_id, payment_received, payment_method, date_created, date_updated) 
            VALUES ('$payment_id', '$payment', 'Cash', '$date', '$date')";
        $run_insert_payment = mysqli_query($conn, $query_insert_payment);

        if ($run_insert_payment) {
            echo "<script>
                alert('Payment Successful');
                window.location.href='view-all-patients-payments.php?payment_id=$payment_id&user_id=$user_id&service=$concern';
            </script>";
        } else {
            echo "❌ Error inserting payment: " . mysqli_error($conn);
        }
    } else {
        echo "❌ Error updating balance: " . mysqli_error($conn);
    }
}


// --------------------
// PAYMONGO PAYMENT
// --------------------
if (isset($_POST['add_payment_paymogo'])) {
    // Replace with your PayMongo Secret Key
    $secretKey = "sk_test_r8kyhfXQVLSNGMYfNtZQHVp3";

    $user_id = $_GET['user_id'];
    $default_device = "Phone";
    $description = "Paid via PayMongo";

    $remaining_balance = floatval($_POST['remaining_balance']);
    $payment = floatval($_POST['payment']);
    $payment_id = $_GET['payment_id'];
    $concern = $_GET['service'];

    // Validate
    if ($payment > $remaining_balance) {
        echo "<script>alert('Payment exceeds remaining balance.'); window.history.back();</script>";
        exit();
    }

    $updated_balance = $remaining_balance - $payment;

    $query_update_balance = "UPDATE payments 
        SET remaining_balance = '$updated_balance', 
            is_deducted = '1', 
            date_updated = '$date' 
        WHERE payment_id = '$payment_id'";
    $run_update_balance = mysqli_query($conn, $query_update_balance);

    if ($run_update_balance) {
        $query_insert_payment = "INSERT INTO payment_history 
            (payment_id, payment_received, payment_method, date_created, date_updated) 
            VALUES ('$payment_id', '$payment', '$description', '$date', '$date')";
        $run_insert_payment = mysqli_query($conn, $query_insert_payment);

        if (!$run_insert_payment) {
            echo "❌ Error inserting payment history: " . mysqli_error($conn);
            exit();
        }
    } else {
        echo "❌ Error updating balance: " . mysqli_error($conn);
        exit();
    }

    // Setup PayMongo Payment Link
    $data = [
        "data" => [
            "attributes" => [
                "amount" => intval($payment * 100), // centavos
                "user_id" => $user_id,
                "currency" => "PHP",
                "description" => $description,
                "checkout_url" => "https://pm.link/org-sBNv7gWdxikVStjWLa5zEfBt/test/Yxj6GJs"
            ]
        ]
    ];

    // CURL to PayMongo
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.paymongo.com/v1/links");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Basic " . base64_encode($secretKey . ":")
    ]);

    $result = curl_exec($ch);
    curl_close($ch);

    $response = json_decode($result, true);

    if (isset($response['data']['attributes']['checkout_url'])) {
        header("Location: " . $response['data']['attributes']['checkout_url']);
        exit();
    } else {
        echo "❌ Error creating PayMongo payment link: " . print_r($response, true);
    }
}
?>
