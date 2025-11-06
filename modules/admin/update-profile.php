
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/modules/queries/Users/users.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/scripts.php'); 

if(isset($_POST['update_profile'])){

    $user_id = $_POST['user_id'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $mobile_number = $_POST['mobile_number'];
    $email = $_POST['email'];
    if(!empty($_POST['date_of_birth'])){
        $date_of_birth = $_POST['date_of_birth'];
    }else{
        $date_of_birth = $_POST['birth_date'];
    }
    $run_update = updateProfile($conn, $first_name, $middle_name, $last_name, $mobile_number, $email, $date_of_birth, $user_id);
    if($run_update){
      echo "<script> success('Profile has been updated successfully.', () => window.location.href = 'my-profile.php') </script>";
    }else{
      echo "<script> error('Something went wrong!', () => window.location.href = 'my-profile.php') </script>";
    }

}

?>