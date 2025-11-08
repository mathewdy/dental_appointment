<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/connection/connection.php');

$id = $_POST['id'];
$role = $_SESSION['role_id']; 

if ($role == 2) {
    $readField = 'adminHasRead';
} else {
    $readField = 'hasRead';
}

mysqli_query($conn, "UPDATE notification SET $readField = 1 WHERE id = '$id'");

if ($role == 2) {
    $countQuery = "SELECT COUNT(*) AS total FROM notification WHERE adminHasRead = 0";
} else {
    $userId = $_SESSION['user_id'];
    $countQuery = "SELECT COUNT(*) AS total FROM notification WHERE user_id = '$userId' AND hasRead = 0";
}

$result = mysqli_query($conn, $countQuery);
$total = mysqli_fetch_assoc($result)['total'];

echo json_encode(['success' => true, 'total' => (int)$total]);
?>
