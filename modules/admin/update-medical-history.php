<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Users/users.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/scripts.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_medical_history'])) {

    $user_id = (int)$_POST['user_id'];
    $history = isset($_POST['history']) ? implode(',', $_POST['history']) : '';
    $current_medications = $_POST['current_medications'] ?? '';
    $allergies = $_POST['allergies'] ?? '';
    $past_surgeries = $_POST['past_surgeries'] ?? '';
    
    $sql_check = "SELECT user_id FROM medical_history WHERE user_id = ?";
    $stmt_check = mysqli_prepare($conn, $sql_check);
    mysqli_stmt_bind_param($stmt_check, "i", $user_id);
    mysqli_stmt_execute($stmt_check);
    $result_check = mysqli_stmt_get_result($stmt_check);

    if(mysqli_num_rows($result_check) > 0){
        $sql_update = "UPDATE medical_history 
                       SET history = ?, current_medications = ?, allergies = ?, past_surgeries = ? 
                       WHERE user_id = ?";
        $stmt = mysqli_prepare($conn, $sql_update);
        mysqli_stmt_bind_param($stmt, "ssssi", $history, $current_medications, $allergies, $past_surgeries, $user_id);
        $message = "Medical history updated successfully!";
    } else {
        $sql_insert = "INSERT INTO medical_history (user_id, history, current_medications, allergies, past_surgeries) 
                       VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql_insert);
        mysqli_stmt_bind_param($stmt, "issss", $user_id, $history, $current_medications, $allergies, $past_surgeries);
        $message = "Medical history saved successfully!";
    }

    if(mysqli_stmt_execute($stmt)){
        echo "<script>
                success('$message', () => window.location.href = 'patients.php')
              </script>";
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error saving medical history: " . mysqli_error($conn) . "</div>";
    }

} else {
    echo "<div class='alert alert-warning'>Invalid request.</div>";
}
?>
