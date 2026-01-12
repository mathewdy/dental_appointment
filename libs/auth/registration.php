<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');

?>

    <div class="container">
      <div class="d-flex justify-content-center align-items-center">
        <div class="card p-0 m-0">
          <div class="row w-100 p-0 m-0">
            <div class="col-md-12 col-lg-6 p-0 m-0">
              <div class="op-9 text-light p-lg-5 d-flex align-items-center justify-content-center bg-dark" style="height: 100%;">
                <div class="row p-5">
                  <div class="col-lg-12 align-items-center text-center">
                    <img src="../assets/img/logo-with-name.png" alt="logo" height="150">
                    <h1 class="display-7 fw-bold">We take care of your teeth</h1>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12 col-lg-6 p-5">
              <form action="" method="POST">
                <div class="row">
                  <div class="col-lg-12 text-center mb-5">
                      <h1>Register Here</h1>
                  </div>
                  <div class="col-lg-12 mb-4">
                      <label for="">First Name</label>
                      <input type="text" class="form-control" name="first_name">
                  </div>
                  <div class="col-lg-12 mb-4">
                      <label for="">Middle Name</label>
                      <input type="text" class="form-control" name="middle_name">
                  </div>
                  <div class="col-lg-12 mb-4">
                      <label for="">Last Name</label>
                      <input type="text" class="form-control" name="last_name">
                  </div>
                  <div class="col-lg-12 mb-4">
                      <label for="">Mobile Number </label>
                      <input type="tel" class="form-control" name="mobile_number" 
                      placeholder="09XXXXXXXXX"
                      pattern="^09[0-9]{9}$"
                      maxlength="11"
                      oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                      required>
                  </div>
                  <div class="col-lg-12 mb-4">
                      <label for="">Date of Birth</label>
                      <input type="date" class="form-control" name="date_of_birth">
                  </div>
                  <div class="col-lg-12 mb-4">
                      <label for="">Email</label>
                      <input type="email" class="form-control" name="email">
                  </div>
                  <div class="col-lg-6 mb-lg-5">
                      <label for="">Password </label>
                      <div class="input-group mb-3">
                          <input type="password" class="form-control pw" name="password" aria-describedby="basic-addon2" id="pw">
                          <span class="input-group-text pw-toggle" id="basic-addon2" style="cursor:pointer;" data-target="#pw"><i class="fas fa-eye"></i></span>
                      </div>
                  </div>
                  <div class="col-lg-6 mb-lg-5">
                      <label for="">Confirm Password </label>
                      <div class="input-group mb-3">
                          <input type="password" class="form-control pw" id="pw2" name="password_2" aria-describedby="basic-addon2" pattern="(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder="•••••••" title="Password must be at least 8 characters and contain both uppercase and lowercase letters" required>
                          <span class="input-group-text pw-toggle" id="basic-addon2" style="cursor:pointer;" data-target="#pw2"><i class="fas fa-eye"></i></span>
                      </div>
                  </div>
                  <div class="col-lg-12 mb-5">
                      <h1>History</h1> 
                      <?php
                          $array_history = array("High Blood Pressure", "Diabetes", "Heart Disease", "Asthma", "Hepatitis", "Bleeding Disorder", "Tuberculosis");
                          foreach($array_history as $history){
                              ?>
                              <input class="form-check-input" type="checkbox" name="history[]" value="<?php echo $history; ?>" id="flexCheckDefault_<?= $history ?>">
                              <label class="form-check-label" for="flexCheckDefault_<?= $history ?>">
                                      <?php echo $history; ?>
                              </label>
                              <br>
                              <?php
                          }
                      ?>
                  </div>
                  <div class="col-lg-12 mb-5">
                    <h1> Medication & Allergies</h1> 
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Current Medications</label>
                        <input type="text" name="current_medications" class="form-control" id="exampleFormControlInput1" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Allergies(Drugs/Foods/Anesthesia)</label>
                        <input type="text" name="allergies" class="form-control" id="exampleFormControlInput1" placeholder="">
                    </div>
                      <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Past Surgeries / Hospitalizations</label>
                        <input type="text" name="past_surgeries" class="form-control" id="exampleFormControlInput1" placeholder="">
                    </div>
                  </div>
                  <div class="col-lg-12 mb-4 text-center">
                      <input type="submit" class="btn btn-black op-8 w-100" name="register_patient" value="Register">
                      <a href="login.php" class="text-dark">Already have an account?</a>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/scripts.php');

if(isset($_POST['register_patient'])){

    $user_id = "2025".rand('1','10') . substr(str_shuffle(str_repeat("0123456789", 5)), 0, 3) ;
    $role_id = 1;
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $date_of_birth = date('Y-m-d',strtotime($_POST['date_of_birth']));
    $mobile_number = $_POST['mobile_number'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_2 = $_POST['password_2'];

    if ($password !== $password_2) {
      echo "<script> error('Password does not match!', () => window.location.origin) </script>";
      exit;
    }else{
        $new_password = password_hash($password,PASSWORD_DEFAULT);

        date_default_timezone_set("Asia/Manila");
        $date = date('y-m-d');
        
        //errors
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        //history
        $history_string = isset($_POST['history']) && is_array($_POST['history']) 
          ? implode(", ", $_POST['history']) 
          : "";
        $current_medications = $_POST['current_medications'] ?? "";
        $allergies = $_POST['allergies'] ?? "";  
        $past_surgeries = $_POST['past_surgeries'] ?? "";

        $query_check_user = "SELECT * FROM users WHERE email='$email'";
        $run_check_user = mysqli_query($conn,$query_check_user);
        
        if(mysqli_num_rows($run_check_user) > 0){
          echo "<script> error('User Already Exists', () => window.location.origin) </script>";
          exit;
        }else{
            $query_register = "INSERT INTO users (user_id,role_id,first_name,middle_name,last_name,mobile_number,email,password,date_of_birth,date_created,date_updated) VALUES ('$user_id','$role_id', '$first_name','$middle_name','$last_name','$mobile_number','$email','$new_password','$date_of_birth','$date','$date')";
            $run_sql = mysqli_query($conn,$query_register);

            $sql_insert_history = "INSERT INTO medical_history (user_id, history, current_medications, allergies, past_surgeries,date_created,date_updated) VALUES ('$user_id', '$history_string', '$current_medications', '$allergies', '$past_surgeries','$date','$date')";
            $run_insert_history = mysqli_query($conn, $sql_insert_history);

            if($run_sql){
              echo "<script> success('Account Created.', () => window.location.href='login.php') </script>";
            }else{
              echo "<script> error('Something went wrong!', () => window.location.origin) </script>";
            }
        }

    }


    
}
ob_end_flush();


?>