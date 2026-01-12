<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once 'config.php';
include_once 'connection/connection.php';
include_once 'modules/queries/DentalChart/dental_chart.php';

echo "Testing getPatientLedger...\n";

$patient_id = 202600269;

try {
    $result = getPatientLedger($conn, $patient_id);
    if ($result) {
        echo "Success! Rows: " . mysqli_num_rows($result) . "\n";
        while ($row = mysqli_fetch_assoc($result)) {
            print_r($row);
        }
    } else {
        echo "Query failed: " . mysqli_error($conn) . "\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>