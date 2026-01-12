<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/connection/connection.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
header('Content-Type: application/json');

$id = $_SESSION['user_id'];
$role = $_SESSION['role_id'];


if ($role == 2) {
    $readField = 'adminHasRead';
    $conditions = "$readField = 0";
} else {
    $readField = 'hasRead';
    $conditions = "user_id = '$id' AND $readField = 0";
}

$whereClause = !empty($conditions) ? "WHERE $conditions" : "";
$groupClause = !empty($conditions) ? "GROUP BY trans_id" : "";

$countQuery = "SELECT COUNT(DISTINCT trans_id) AS total FROM notification $whereClause";
$countResult = mysqli_query($conn, $countQuery);
$totalCount = mysqli_fetch_assoc($countResult)['total'] ?? 0;

$notifItem = [];

$fetchQuery = "SELECT * FROM notification $whereClause $groupClause ORDER BY id DESC";
$run = mysqli_query($conn, $fetchQuery);

if(mysqli_num_rows($run) > 0){
    foreach($run as $row){
        $iconType = match($row['type']) {
            'Appointment' => 'fa fa-calendar',
            'Payment'     => 'fa fa-money-bill',
            default       => 'fa fa-bell'
        };
        $link = match($row['type']) {
            'Appointment' => 'requests.php',
            'Payment'     => $role != 1 ? 'payments.php' : 'history.php',
            default       => '#'
        };

        $notifItem[] = [
            'id'       => $row['id'],
            'type'     => $row['type'],
            'trans'    => $row['trans_id'],
            'message'  => $row['message'],
            'icon'     => $iconType,
            'url'      => $link,
            'datetime' => $row['createdAt'],
            'read'     => $row[$readField]
        ];
    }
}

echo json_encode([
    'total' => (int)$totalCount,
    'notifications' => $notifItem
]);
?>
