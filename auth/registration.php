<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/registration.style.php');
?>


<div class="left-panel d-flex">
    <img src="../assets/img/logo-with-name.png" alt="logo" class="mb-4">
    <h1 class="fw-bold">We take care of your teeth</h1>
    <p class="mt-3 opacity-75">Quality care. Trusted service. Every smile matters.</p>
    <a href="login.php" class="btn text-white border-light btn-round">Sign In</a>
</div>

<div class="right-panel">
    <div class="form-wrapper">
        <!-- STEPPER -->
        <div class="text-center mb-4">
            <h1>Sign up</h1>
        </div>
        <div class="stepper">
            <div class="step-item active" data-step="1">
                <div class="step-number">1</div>
                <div class="step-label">Personal</div>
            </div>
            <div class="step-line"></div>
            <div class="step-item" data-step="2">
                <div class="step-number">2</div>
                <div class="step-label">Medical (optional)</div>
            </div>
            <div class="step-line"></div>
            <div class="step-item" data-step="3">
                <div class="step-number">3</div>
                <div class="step-label">Account</div>
            </div>
        </div>

        <!-- FORM -->
        <form id="multiForm" method="POST" novalidate>
            <div class="err"></div>
            
            <!-- STEP 1 -->
            <div class="step-content active" data-step="1">
                <h4>Personal Information</h4>
                <div class="mb-3">
                    <label class="form-label">First Name</label>
                    <input type="text" class="form-control text" name="first_name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Middle Name</label>
                    <input type="text" class="form-control text" name="middle_name">
                </div>
                <div class="mb-3">
                    <label class="form-label">Last Name</label>
                    <input type="text" class="form-control text" name="last_name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mobile Number</label>
                    <input type="tel" class="form-control" name="mobile_number" placeholder="09XXXXXXXXX" maxlength="11" oninput="this.value=this.value.replace(/[^0-9]/g,'')" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Date of Birth</label>
                    <input type="text" class="form-control dob" name="date_of_birth" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <input type="text" class="form-control" name="address" required>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <button type="button" class="btn btn-primary next-btn">Next</button>
                </div>
            </div>

            <!-- STEP 2 -->
            <div class="step-content" data-step="2">
                <h4>Medical History (Optional)</h4>
                <div class="row mb-3">
                    <?php
                        $array_history = ["High Blood Pressure","Diabetes","Heart Disease","Asthma","Hepatitis","Bleeding Disorder","Tuberculosis"];
                        foreach($array_history as $history){
                            ?>
                            <div class="col-lg-6 col-md-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="history[]" value="<?php echo $history; ?>" id="chk_<?php echo $history; ?>">
                                    <label class="form-check-label" for="chk_<?php echo $history; ?>"><?php echo $history; ?></label>
                                </div>
                            </div>
                            <?php
                        }
                    ?>
                </div>

                <h5 class="mt-4">Medication & Allergies (Optional)</h5>
                <div class="mb-3">
                    <label class="form-label">Current Medications</label>
                    <input type="text" class="form-control" name="current_medications">
                </div>
                <div class="mb-3">
                    <label class="form-label">Allergies (Drugs/Foods/Anesthesia)</label>
                    <input type="text" class="form-control" name="allergies">
                </div>
                <div class="mb-3">
                    <label class="form-label">Past Surgeries / Hospitalizations</label>
                    <input type="text" class="form-control" name="past_surgeries">
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-black op-5 prev-btn">Back</button>
                    <button type="button" class="btn btn-primary next-btn">Next</button>
                </div>
            </div>

            <!-- STEP 3 -->
            <div class="step-content" data-step="3">
                <h4>Account Information</h4>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control pw" name="password" aria-describedby="basic-addon2" id="pw" pattern="(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder="•••••••" title="Password must be at least 8 characters and contain both uppercase and lowercase letters" required>
                        <span class="input-group-text pw-toggle" id="basic-addon2" style="cursor:pointer;" data-target="#pw"><i class="fas fa-eye"></i></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                     <div class="input-group mb-3">
                        <input type="password" class="form-control pw" id="pw2" name="password_2" aria-describedby="basic-addon2" pattern="(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder="•••••••" title="Password must be at least 8 characters and contain both uppercase and lowercase letters" required>
                        <span class="input-group-text pw-toggle" id="basic-addon2" style="cursor:pointer;" data-target="#pw2"><i class="fas fa-eye"></i></span>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-black op-5 prev-btn">Back</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>

        </form>
    </div>
</div>

<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/scripts.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/registration.script.php');
?>
<script>
    $(document).ready(function() {
        nameOnly('.text')
    })
</script>

