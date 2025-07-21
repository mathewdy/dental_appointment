<?php
session_start();
require_once('../connection/connection.php');
header('Content-Type: application/json');

$id = $_SESSION['user_id'];
$role = $_SESSION['role_id']; 


function timeAgo($datetime) {
    $time = strtotime($datetime);
    $diff = time() - $time;
    
    if ($diff < 60) return 'Just Now';
    if ($diff < 3600) return round($diff / 60) . ' minutes ago';
    if ($diff < 86400) return round($diff / 3600) . ' hours ago';
    if ($diff < 604800) return round($diff / 86400) . ' days ago';
    if ($diff < 2629440) return round($diff / 604800) . ' weeks ago';
    if ($diff < 31553280) return round($diff / 2629440) . ' months ago';
    return round($diff / 31553280) . ' years ago';
}

$notifItem = [];

$possibleClause = $role != 2 ? "WHERE user_id = '$id'" : '';  
$fetch = "SELECT *, (SELECT COUNT(*) FROM `notification` $possibleClause) AS total FROM `notification`" . $possibleClause;
$run = mysqli_query($conn, $fetch);
if(mysqli_num_rows($run) > 0){
	foreach($run as $row){
		$handleIconType = match($row['type']) {
				'Appointment' => 'fa fa-calendar'
		};
		
		$notifItem[]= [
			'count' => (int)$row['total'],
			'read'  => $row['hasRead'],
			'data'  => [
				[
					'message' => $row['message'],
					'icon'    => $handleIconType,
					'time'    => timeAgo($row['createdAt'])
				]
			]
		];
	}
}

echo json_encode($notifItem);
