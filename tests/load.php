<?php
// load_events.php

include('../../connection/connection.php');


// Tell the client we’re returning JSON
header('Content-Type: application/json');

// Prepare an array to hold the events
$data = [];

// Raw SQL query (no PDO, no prepared statements)
$sql = "SELECT * FROM events ORDER BY id";
$result = mysqli_query($conn, $sql);

// Check for query success
if ($result) {
    // Fetch each row as an associative array
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = [
            'id'    => $row['id'],
            'title' => $row['title'],
            'start' => $row['start_event'],
            'end'   => $row['end_event']
        ];
    }
} else {
    // Optionally return an error in JSON
    echo json_encode([
        'status'  => 'error',
        'message' => 'DB Error: ' . mysqli_error($conn)
    ]);
    exit;
}

// Output the events array as JSON
echo json_encode($data);
