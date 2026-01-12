<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Users/users.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/scripts.php');

if (isset($_POST['update_profile'])) {
    $user_id = $_POST['user_id'];

    $first_name     = trim($_POST['first_name']);
    $middle_name    = trim($_POST['middle_name'] ?? '');
    $last_name      = trim($_POST['last_name']);
    $mobile_number  = trim($_POST['mobile_number']);
    $email          = trim($_POST['email']);
    $birth_date     = $_POST['birth_date'] ?? null;
    $address          = trim($_POST['address']);

    $history            = isset($_POST['history']) ? implode(',', $_POST['history']) : '';
    $current_medications = trim($_POST['current_medications'] ?? '');
    $allergies          = trim($_POST['allergies'] ?? '');
    $past_surgeries     = trim($_POST['past_surgeries'] ?? '');

    $check_email = checkAllUserByEmail($conn, $email);
    if (mysqli_num_rows($check_email) > 0) {
        foreach ($check_email as $row) {
            if ($row['user_id'] != $user_id) {
                echo "<script>error('Email already exists', () => history.back())</script>";
                exit;
            }
        }
    }

    mysqli_begin_transaction($conn);

    try {
        $sql_user = "UPDATE users SET
                        first_name = ?,
                        middle_name = ?,
                        last_name = ?,
                        mobile_number = ?,
                        email = ?,
                        date_of_birth = ?,
                        address = ?,
                        date_updated = NOW()
                     WHERE user_id = ?";

        $stmt_user = mysqli_prepare($conn, $sql_user);
        mysqli_stmt_bind_param($stmt_user, "sssssssi", $first_name, $middle_name, $last_name, $mobile_number, $email, $birth_date, $address, $user_id);
        
        if (!mysqli_stmt_execute($stmt_user)) {
            throw new Exception("Failed to update profile info");
        }
        mysqli_stmt_close($stmt_user);


        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name']  = $last_name;

        $sql_check = "SELECT id FROM medical_history WHERE user_id = ?";
        $stmt_check = mysqli_prepare($conn, $sql_check);
        mysqli_stmt_bind_param($stmt_check, "i", $user_id);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_store_result($stmt_check);

        if (mysqli_stmt_num_rows($stmt_check) > 0) {
            $sql_medical = "UPDATE medical_history SET
                                history = ?,
                                current_medications = ?,
                                allergies = ?,
                                past_surgeries = ?,
                                date_created = NOW()
                            WHERE user_id = ?";
            $stmt_medical = mysqli_prepare($conn, $sql_medical);
            mysqli_stmt_bind_param($stmt_medical, "ssssi", $history, $current_medications, $allergies, $past_surgeries, $user_id);
        } else {
            $sql_medical = "INSERT INTO medical_history 
                                (user_id, history, current_medications, allergies, past_surgeries, date_created) 
                            VALUES (?, ?, ?, ?, ?, NOW())";
            $stmt_medical = mysqli_prepare($conn, $sql_medical);
            mysqli_stmt_bind_param($stmt_medical, "issss", $user_id, $history, $current_medications, $allergies, $past_surgeries);
        }

        mysqli_stmt_execute($stmt_medical);
        mysqli_stmt_close($stmt_medical);
        mysqli_stmt_close($stmt_check);

        mysqli_commit($conn);

        echo "<script>
            success('Profile and medical history updated successfully!', () => {
                window.location.href = 'my-profile.php';
            });
        </script>";

    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "<script>
            error('Update failed: " . $e->getMessage() . "', () => history.back());
        </script>";
    }

    exit;
}
?>