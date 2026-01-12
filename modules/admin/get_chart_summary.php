<?php
header('Content-Type: application/json');

include_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/connection/connection.php');
// We need getDentalChart function. It is in modules/queries/DentalChart/dental_chart.php
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/DentalChart/dental_chart.php');

if (!isset($conn)) {
    die(json_encode(['error' => 'Database connection failed']));
}
if (!function_exists('getDentalChart')) {
    die(json_encode(['error' => 'Function getDentalChart not found']));
}

$patient_id = isset($_GET['patient_id']) ? intval($_GET['patient_id']) : 0;
$appointment_id = isset($_GET['appointment_id']) ? intval($_GET['appointment_id']) : 0;

// Validate patient_id only. appointment_id=0 means Global Chart.
if ($patient_id <= 0) {
    echo json_encode(['error' => 'Invalid patient_id', 'data' => []]);
    exit;
}

$chart_data = getDentalChart($conn, $patient_id, $appointment_id);
$summary = [];

// Iterate 1-32
for ($i = 1; $i <= 32; $i++) {
    if (isset($chart_data[$i])) {
        $tooth = $chart_data[$i];
        
        // Check Whole
        if (isset($tooth['whole']) && $tooth['whole']['status'] !== 'Normal') {
            $summary[] = [
                'tooth' => $i,
                'surface' => 'Whole',
                'status' => $tooth['whole']['status'],
                'notes' => $tooth['whole']['notes'] ?? ''
            ];
        }

        // Check Surfaces
        $surfaces = ['Mesial', 'Distal', 'Buccal', 'Lingual', 'Occlusal'];
        foreach ($surfaces as $surf) {
            if (isset($tooth[$surf]) && $tooth[$surf]['status'] !== 'Normal') {
                $summary[] = [
                    'tooth' => $i,
                    'surface' => $surf,
                    'status' => $tooth[$surf]['status'],
                    'notes' => $tooth[$surf]['notes'] ?? ''
                ];
            }
        }
    }
}

echo json_encode(['success' => true, 'data' => $summary]);
?>
