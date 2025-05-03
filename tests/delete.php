<?php
// delete.php
include('../../connection/connection.php');


// Check if the required POST variable is set
if (isset($_POST["id"])) {
    $id = $_POST["id"];

    // Delete query (no prepared statements)
    $sql = "DELETE FROM events WHERE id = '$id'";
    $run = mysqli_query($conn, $sql);

    if ($run) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Missing event ID.']);
}
?>
