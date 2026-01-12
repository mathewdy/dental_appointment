<?php
require 'config.php';
require 'connection/connection.php';

$patient_id = 202600269;
$sql = "SELECT * FROM patient_dental_chart WHERE patient_id = $patient_id AND tooth_number IN (1,2,3)";
$res = mysqli_query($conn, $sql);

echo "Checking teeth for patient $patient_id:\n";
while($row = mysqli_fetch_assoc($res)) {
    print_r($row);
}
?>
