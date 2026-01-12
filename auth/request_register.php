<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/connection/connection.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

function respondError($message)
{
    echo json_encode(['success' => false, 'message' => $message]);
    exit;
}

$response = ['success' => false, 'message' => 'Something went wrong'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $user_id = date('Y') . rand(1, 10) . substr(str_shuffle(str_repeat("0123456789", 5)), 0, 3);
    $role_id = 1;

    $first_name = $_POST['first_name'] ?? '';
    $middle_name = $_POST['middle_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $mobile_number = $_POST['mobile_number'] ?? '';
    $email = $_POST['email'] ?? '';
    $address = $_POST['address'] ?? '';
    $password = $_POST['password'] ?? '';
    $password_2 = $_POST['password_2'] ?? '';
    $history = isset($_POST['history']) ? implode(", ", $_POST['history']) : '';
    $current_medications = $_POST['current_medications'] ?? '';
    $allergies = $_POST['allergies'] ?? '';
    $past_surgeries = $_POST['past_surgeries'] ?? '';
    $date = date('Y-m-d');

    if (empty(trim($first_name)))
        respondError('First name is required.');
    if (empty(trim($last_name)))
        respondError('Last name is required.');
    if (empty($mobile_number))
        respondError('Mobile number is required.');
    if (!preg_match('/^09\d{9}$/', $mobile_number))
        respondError('Mobile number must start with 09 and contain 11 digits.');
    if (empty($email))
        respondError('Email is required.');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        respondError('Invalid email format.');
    if (empty($_POST['date_of_birth']) || !strtotime($_POST['date_of_birth']))
        respondError('Please provide a valid date of birth.');
    if (strtotime($_POST['date_of_birth']) > time())
        respondError('Date of birth cannot be in the future.');
    $date_of_birth = date('Y-m-d', strtotime($_POST['date_of_birth']));

    if ($password !== $password_2)
        respondError('Passwords do not match!');

    if (strlen($password) < 8)
        respondError('Password must be at least 8 characters long.');
    if (!preg_match('/[a-z]/', $password) || !preg_match('/[A-Z]/', $password))
        respondError('Password must contain both uppercase and lowercase letters.');

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT email FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0)
        respondError('Email already exists!');
    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO users(user_id, role_id, first_name, middle_name, last_name, mobile_number, email, password, date_of_birth, date_created, date_updated, address) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("ssssssssssss", $user_id, $role_id, $first_name, $middle_name, $last_name, $mobile_number, $email, $hashed_password, $date_of_birth, $date, $date, $address);
    if (!$stmt->execute())
        respondError("Database error: " . $stmt->error);

    $stmt2 = $conn->prepare("INSERT INTO medical_history(user_id, history, current_medications, allergies, past_surgeries, date_created, date_updated) VALUES (?,?,?,?,?,?,?)");
    $stmt2->bind_param("sssssss", $user_id, $history, $current_medications, $allergies, $past_surgeries, $date, $date);
    if (!$stmt2->execute())
        respondError("Database error: " . $stmt2->error);

    $stmt->close();
    $stmt2->close();

    $response = ['success' => true, 'message' => 'Account created successfully!'];
}

echo json_encode($response);
