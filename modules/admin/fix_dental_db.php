<?php
$_SERVER['DOCUMENT_ROOT'] = 'e:/devE/fojas';
include_once 'connection/connection.php';

echo "Checking database tables...\n";

// Check if patient_dental_chart exists
$sql = "SHOW TABLES LIKE 'patient_dental_chart'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    echo "Table 'patient_dental_chart' MISSING. Creating...\n";
    $sql_create = "CREATE TABLE `patient_dental_chart` (
      `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `patient_id` int(11) NOT NULL,
      `tooth_number` int(11) NOT NULL,
      `tooth_surface` varchar(20) DEFAULT 'whole',
      `status` varchar(50) NOT NULL,
      `notes` text DEFAULT NULL,
      `modified_by` int(11) DEFAULT NULL,
      `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      INDEX (`patient_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

    if (mysqli_query($conn, $sql_create)) {
        echo "Table created successfully.\n";
    } else {
        echo "Error creating table: " . mysqli_error($conn) . "\n";
    }
} else {
    echo "Table 'patient_dental_chart' EXISTS.\n";
    // Check columns
    $sql_cols = "SHOW COLUMNS FROM patient_dental_chart";
    $res_cols = mysqli_query($conn, $sql_cols);
    while ($row = mysqli_fetch_assoc($res_cols)) {
        echo "- " . $row['Field'] . " (" . $row['Type'] . ")\n";
    }
}
?>