<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/connection/connection.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/DentalChart/dental_chart.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_id = $_POST['patient_id'] ?? 0;
    $tooth_number = $_POST['tooth_number'] ?? 0;
    $status = $_POST['status'] ?? 'Normal';
    $tooth_surface = $_POST['tooth_surface'] ?? 'whole'; // Capture surface from form
    $notes = $_POST['notes'] ?? '';
    // Handle appointment_id: IN NEW REQ, Force NULL (Global Chart)
    $appointment_id = null; 
    // $appointment_id = !empty($_POST['appointment_id']) ? $_POST['appointment_id'] : null;
    $modifier_id = $_SESSION['user_id'];

    if ($patient_id && $tooth_number) {
        // Fix: Pass dynamic $tooth_surface instead of hardcoded 'whole'
        $result = updateToothStatus($conn, $patient_id, $tooth_number, $tooth_surface, $status, $notes, $modifier_id, $appointment_id);
        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid data']);
    }
}
?>