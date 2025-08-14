<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/connection/connection.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/config.php');
header('Content-Type: application/json');

$id = $_SESSION['user_id'];
$role = $_SESSION['role_id']; 


function timeAgo($datetime) {
    $time = strtotime($datetime);
    $diff = time() - $time;

    $units = [
        'year' => 31553280,
        'month' => 2629440,
        'week' => 604800,
        'day' => 86400,
        'hour' => 3600,
        'minute' => 60,
        'second' => 1
    ];

    foreach ($units as $unit => $value) {
        if ($diff >= $value) {
            $count = floor($diff / $value);
            $unitName = ($count > 1) ? $unit . 's' : $unit;
            return "$count $unitName ago";
        }
    }

    return 'Just Now';
}

$notifItem = [];

$possibleClause = $role != 2 ? "WHERE user_id = '$id'" : '';  
$fetch = "SELECT *, (SELECT COUNT(*) FROM `notification` $possibleClause) AS total FROM `notification`" . $possibleClause . " ORDER BY id DESC ";
$run = mysqli_query($conn, $fetch);
if(mysqli_num_rows($run) > 0){
	foreach($run as $row){

		$iconType = match($row['type']) {
      'Appointment' => 'fa fa-calendar',
      'Payment'     => 'fa fa-money-bill'
		};
		$link = match($row['type']) {
        'Appointment' => 'requests.php',
        'Payment'     => 'payments.php'
    };

		$notifItem[]= [
			'count' => (int)$row['total'],
			'read'  => $row['hasRead'],
			'data'  => [
				[
          'type'    => $row['type'],
					'message' => $row['message'],
					'icon'    => $iconType,
          'url'     => $link,
					'time'    => timeAgo($row['createdAt']),
          'datetime'=> $row['createdAt']
				]
			]
		];
	}
}

echo json_encode($notifItem);
