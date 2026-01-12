<?php
$_SERVER['DOCUMENT_ROOT'] = 'e:/devE/fojas';
include 'connection/connection.php';
$email = 'romejayfeleofojas@gmail.com';
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
echo "OTP: " . $row['otp'] . "\n";
echo "Role: " . $row['role_id'] . "\n";
?>