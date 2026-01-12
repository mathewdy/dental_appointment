
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Users/users.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/scripts.php'); 

if (isset($_POST['update_profile'])) {

    $user_id       = $_POST['user_id'];
    $first_name    = trim($_POST['first_name']);
    $middle_name   = trim($_POST['middle_name'] ?? '');
    $last_name     = trim($_POST['last_name']);
    $mobile_number = trim($_POST['mobile_number']);
    $email         = trim($_POST['email']);
    $date_of_birth = $_POST['birth_date'] ?? null;

    $check_email = checkAllUserByEmail($conn, $email);
    if (mysqli_num_rows($check_email) > 0) {
        foreach ($check_email as $row) {
            if ($row['user_id'] != $user_id) {
                echo "<script>error('Email already exists', () => history.back())</script>";
                exit;
            }
        }
    }

    $sql = "UPDATE users SET 
                first_name = ?, 
                middle_name = ?, 
                last_name = ?, 
                mobile_number = ?, 
                email = ?, 
                date_of_birth = ?, 
                date_updated = NOW() 
            WHERE user_id = ?"; 

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssssssi", $first_name, $middle_name, $last_name, $mobile_number, $email, $date_of_birth, $user_id);

        if (mysqli_stmt_execute($stmt)) {
          $_SESSION['first_name'] = $first_name;
          $_SESSION['last_name'] = $last_name;
            $rows = mysqli_stmt_affected_rows($stmt);
            echo "<script>
                success('Profile updated successfully!', () => {
                    window.location.href = 'my-profile.php';
                });
            </script>";
        } else {
            echo "<script>error('Update failed', () => history.back())</script>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>error('Query error')</script>";
    }
    exit;
}
?>