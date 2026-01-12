<?php
define('DB_HOST', '82.197.82.91');
define('DB_USER', 'u147900499_fojas');
define('DB_PASS', 'Fojasdental4321');
define('DB_NAME', 'u147900499_fojas_dental');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create dentist_schedules table
$sql1 = "CREATE TABLE IF NOT EXISTS `dentist_schedules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `day_of_week` varchar(20) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `dentist_schedules_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

if ($conn->query($sql1) === TRUE) {
    echo "Table 'dentist_schedules' created successfully\n";
} else {
    echo "Error creating table 'dentist_schedules': " . $conn->error . "\n";
}

// Create patient_dental_chart table
$sql2 = "CREATE TABLE IF NOT EXISTS `patient_dental_chart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) NOT NULL,
  `tooth_number` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `notes` text DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `patient_id` (`patient_id`),
  CONSTRAINT `patient_dental_chart_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

if ($conn->query($sql2) === TRUE) {
    echo "Table 'patient_dental_chart' created successfully\n";
} else {
    echo "Error creating table 'patient_dental_chart': " . $conn->error . "\n";
}

$conn->close();
?>