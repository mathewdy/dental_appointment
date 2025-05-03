<?php
// update.php

// Include your database connection file
require_once 'db-connect.php';

// Check if required POST variables are set
if (isset($_POST['id'], $_POST['title'], $_POST['start'], $_POST['end'])) {
    // Sanitize the input (minimal)
    $id = $_POST['id'];
    $title = $_POST['title'];
    $start = $_POST['start'];
    $end = $_POST['end'];

    // Update query (no prepared statements)
    $sql = "UPDATE events 
            SET title = '$title', start_event = '$start', end_event = '$end' 
            WHERE id = '$id'";

    $run = mysqli_query($conn, $sql);

    if ($run) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Missing required fields.']);
}
?>
