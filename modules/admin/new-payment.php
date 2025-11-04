<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/Payments/payments.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/notification.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/Mailer/mail.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/scripts.php'); 

$date = date('Y-m-d');
$dateTime = date('Y-m-d H:i:s');
$id = $_SESSION['user_id'];
// --------------------
// CASH PAYMENT
// --------------------
if (isset($_POST['add_payment'])) {
    $remaining_balance = floatval($_POST['remaining_balance']);
    $payment = floatval($_POST['payment']);
    $payment_id = $_POST['payment_id'];
    $method = $_POST['payment_method'];
    $user_id = $_POST['user_id'];
    $services = $_POST['service'];
    $email = $_POST['email'];
    $subject = "Payment";
    $mail = "
      <h3>Dear Customer,</h3>
      <br>
      <p>We are pleased to inform you that your recent payment has been successfully processed.</p>
      <br>
      <br>
      <h3>Payment Details:</h3>
      <br>
      Amount: $payment
      <br>
      Date: $date
      <br>
      Transaction ID: $payment_id
      <br>
      <br>
      <br>
      Thank you for your prompt payment.
    ";
    // Validate: Don't allow payment more than remaining balance
    if ($payment > $remaining_balance) {
				echo "<script> error('Payment exceeds remaining balance.', () => window.history.back()') </script>";
    }

    $updated_balance = $remaining_balance - $payment;

    $run_update_balance = updateRemainingBalance($conn, $updated_balance, $payment_id);
    if ($run_update_balance) {
			$run_insert_payment = createPaymentHistory($conn, $payment_id, $payment, $method);
			if ($run_insert_payment) {
				createNotification($conn, $user_id, "New Payment Transaction", "Payment", $dateTime, $id);
        $sendMail = sendEmail($mail, $subject, $email);
        if ($sendMail) {
          echo "<script>
            success('Payment Successful.', () => {
              setTimeout(() => {
                window.location.href = 'view-patient-payments.php?user_id=$user_id&concern=$services';
              }, 1500);
            });
          </script>";
        } else {
          echo "<script>
            error('Failed to send email. Please try again.');
          </script>";
        }
				
			} else {
				echo "<script> error('Error inserting payment history!', () => window.location.href='view-patient-payments.php?user_id=$user_id&concern=$services') </script>";
			}
    } else {
			echo "<script> error('Error updating balance!', () => window.location.href='view-patient-payments.php?user_id=$user_id&concern=$services') </script>";
    }
}
// add gcash payment

// if (isset($_POST['add_payment_gcash'])) {
//     $remaining_balance = floatval($_POST['remaining_balance']);
//     $payment = floatval($_POST['payment']);
//     $payment_id = $_POST['payment_id'];
//     $user_id = $_POST['user_id'];
//     $services = $_POST['service'];
//     $email = $_POST['email'];
//     $subject = "Payment";
//     $mail = "
//       <h3>Dear Customer,</h3>
//       <br>
//       <p>We are pleased to inform you that your recent payment has been successfully processed.</p>
//       <br>
//       <br>
//       <h3>Payment Details:</h3>
//       <br>
//       Amount: $payment
//       <br>
//       Date: $date
//       <br>
//       Transaction ID: $payment_id
//       <br>
//       <br>
//       <br>
//       Thank you for your prompt payment.
//     ";
//     // Validate: Don't allow payment more than remaining balance
//     if ($payment > $remaining_balance) {
// 				echo "<script> error('Payment exceeds remaining balance.', () => window.history.back()') </script>";
//     }

//     $updated_balance = $remaining_balance - $payment;

//     $run_update_balance = updateRemainingBalance($conn, $updated_balance, $payment_id);
//     if ($run_update_balance) {
// 			$run_insert_payment = createPaymentHistory($conn, $payment_id, $payment, 'GCash');
// 			if ($run_insert_payment) {
// 				createNotification($conn, $user_id, "New Payment Transaction", "Payment", $dateTime, $id);
//         $sendMail = sendEmail($mail, $subject, $email);
//         if ($sendMail) {
//           echo "<script>
//             success('Payment Successful.', () => {
//               setTimeout(() => {
//                 window.location.href = 'view-patient-payments.php?user_id=$user_id&concern=$services';
//               }, 1500);
//             });
//           </script>";
//         } else {
//           echo "<script>
//             error('Failed to send email. Please try again.');
//           </script>";
//         }
				
// 			} else {
// 				echo "<script> error('Error inserting payment history!', () => window.location.href='view-patient-payments.php?user_id=$user_id&concern=$services') </script>";
// 			}
//     } else {
// 			echo "<script> error('Error updating balance!', () => window.location.href='view-patient-payments.php?user_id=$user_id&concern=$services') </script>";
//     }
// }



// --------------------
// PAYMONGO PAYMENT
// --------------------
if (isset($_POST['add_payment_paymogo'])) {
    // Replace with your PayMongo Secret Key
    $secretKey = "sk_test_r8kyhfXQVLSNGMYfNtZQHVp3";

    $user_id = $_POST['user_id'];
    $default_device = "Phone";
    $description = "Paid via PayMongo";

    $remaining_balance = floatval($_POST['remaining_balance']);
    $payment = floatval($_POST['payment']);
    $payment_id = $_POST['payment_id'];
    $services = $_POST['service'];

    // Validate
    if ($payment > $remaining_balance) {
				echo "<script> error('Payment exceeds remaining balance.', () => window.history.back()') </script>";
    }

    $updated_balance = $remaining_balance - $payment;

		$run_update_balance = updateRemainingBalance($conn, $updated_balance, $payment_id);
    if ($run_update_balance) {
			$run_insert_payment = createPaymentHistory($conn, $payment_id, $payment, $description);
			if (!$run_insert_payment) {
				echo "<script> error('Error inserting payment history!', () => window.location.href='view-patient-payments.php?user_id=$user_id&concern=$services') </script>";
			}
    } else {
			echo "<script> error('Error updating balance!', () => window.location.href='view-patient-payments.php?user_id=$user_id&concern=$services') </script>";
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
			echo "<script> error('Error creating PayMongo payment link.') </script>";

        echo "❌ Error creating PayMongo payment link: " . print_r($response, true);
    }
}
?>