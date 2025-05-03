<?php

include('../../connection/connection.php');


// Check if the required POST fields are set
if (isset($_POST['title'], $_POST['start'], $_POST['end'])) {
    $title = $_POST['title'];
    $start = $_POST['start'];
    $end = $_POST['end'];

    // Basic SQL insert without prepared statements
    $sql = "INSERT INTO events (title, start_event, end_event) 
            VALUES ('$title', '$start', '$end')";
    
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Return success with inserted ID
        echo json_encode([
            'status' => 'success',
            'message' => 'Event added successfully',
            'event_id' => mysqli_insert_id($conn)
        ]);
    } else {
        // Return error message
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to insert event: ' . mysqli_error($conn)
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Required fields missing'
    ]);
}
?>
