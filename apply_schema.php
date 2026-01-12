<?php
require 'config.php';
require 'connection/connection.php';

$sqls = [
    "ALTER TABLE patient_dental_chart ADD COLUMN appointment_id INT NULL DEFAULT NULL AFTER patient_id",
    "ALTER TABLE patient_dental_chart ADD INDEX idx_appointment (appointment_id)"
];

foreach ($sqls as $sql) {
    if (mysqli_query($conn, $sql)) {
        echo "Executed: $sql\n";
    } else {
        echo "Error or already exists: " . mysqli_error($conn) . "\n";
    }
}
?>
