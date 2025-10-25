<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
$email = $_SESSION['email'];
$role_id = $_SESSION['role_id'];
?>
<style>
  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
  }

  /* Firefox */
  input[type=number] {
      -moz-appearance: textfield;
  }
  .otp-fake-input {
    width: 48px !important;
    height: 48px !important;
  }
</style>
<div class="container" style="height: 55em;">
        <div class="row d-flex justify-content-center align-items-center p-5" style="height: 100%;">
            <div class="col-6">
                <div class="card w-100 border-none rounded-0">
                    <div class="row" style="height: 100%;">
                        <div class="col-lg-12 p-5 d-flex flex-column justify-content-center text-center">
                            <span class="text-center">
                                <img src="../assets/img/logo.png" height="100" alt="">
                            </span>
                            <span class="mb-4 text-center">
                                <h1>OTP Verification</h1>
                                <p>A verification code has been sent to your email.</p>
                            </span>
                            <form action="" method="POST">
                                <div id="otp_target" class="mb-5"></div>
                                <input type="hidden" name="otp_number" id="otp-value">
                                <input type="submit" class="btn btn-black op-8 w-100 mb-2" name="verify" value="Verify">
                                <a href="login.php" class="text-black op-9">Go Back</a>
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/scripts.php');
?>
<script>
  $('#otp_target').otpdesigner({
    length: 5,
    onlyNumbers: true,
    typingDone: function(code) {
      $('#otp-value').val(code);
    }
  });
</script>

<?php
if(isset($_POST['verify'])){
    $otp_number = $_POST['otp_number'];
    
    $query_otp = "SELECT otp FROM users WHERE email =  '$email'";
    $run_otp = mysqli_query($conn,$query_otp);
    $row_otp = mysqli_fetch_assoc($run_otp);

    if($row_otp['otp'] == $otp_number){
       switch ($role_id){
            case '2':
                header("Location: ../modules/admin/dashboard.php");
                break;
            case '3':
                header("Location: ../modules/dentist/dashboard.php");
                break;
        }
        exit;
        
    }else{
        echo "<script>window.alert('Invalid Number')</script>";
        echo "<script>window.location.origin</script>";
    }

}


?>