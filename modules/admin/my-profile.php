<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modules/queries/Users/users.php');

$first_name = $_SESSION['first_name'];
$user_id = $_SESSION['user_id'];
$roleId = $_SESSION['role_id'];
include('../../includes/security.php');

?>
<div class="wrapper">
        <?php include '../../includes/sidebar.php'; ?>

      <div class="main-panel">
        <?php include '../../includes/topbar.php'; ?>
        <div class="container">
          <div class="page-inner">
            <div class="page-header">
              <div class="d-flex align-items-center gap-4">
                <h4 class="page-title text-truncate">My Profile</h4>
                <div class="d-flex align-items-center gap-2">
                  <div class="nav-home">
                    <a href="dashboard.php" class="text-decoration-none text-muted">
                      <i class="icon-home"></i>
                    </a>
                  </div>
                  <div class="separator">
                    <i class="icon-arrow-right fs-bold"></i>
                  </div>
                  <div class="nav-item">
                    <a href="#" class="text-decoration-none text-truncate text-muted">Profile</a>
                  </div>
                </div>
              </div>
            </div>

            <div class="page-category">
                <?php
                $run_profile = getProfile($conn, $user_id, $roleId);
                if(mysqli_num_rows($run_profile) > 0){
                    foreach($run_profile as $row_profile){
                        $name = $row_profile['first_name'] . " " . $row_profile['last_name'];
                        ?>
                        <div class="p-2 p-lg-5">
                          <div class="d-flex flex-column flex-xl-row gap-2 gap-lg-5">
                            <div class="image w-lg-auto">
                              <img src="../../assets/img/default.jpg" alt="img" class="card-img h-md-auto w-md-auto h-auto w-fit">
                            </div>
                            <div class="info w-100">
                              <div class="row">
                                <div class="col-lg-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                    <p class="h1 m-0 p-0 text-truncate"><?= $name; ?></p>
                                    <div class="d-flex align-items-center">
                                      <p class="h5 m-0 p-0 text-truncate"><?= "ID" . $row_profile['user_id'];?></p>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-lg-12 my-4">
                                  <h1 style="text-decoration: underline;">About</h1>
                                  <p class="text-muted">CONTACT INFORMATION</p>
                                  <div class="row align-items-center w-100">
                                      <div class="col-4">
                                          <p class="h5 text-truncate">Phone: </p>
                                      </div>
                                      <div class="col-8">
                                          <p class="h6"><?= $row_profile['mobile_number']?></p>
                                      </div>
                                  </div>
                                  <div class="row align-items-center w-100">
                                      <div class="col-4">
                                          <p class="h5">Email: </p>
                                      </div>
                                      <div class="col-8 ">
                                          <p class="h6 text-truncate"><?= $row_profile['email']?></p>
                                      </div>
                                  </div>
                                  <br>
                                  <br>
                                  <p class="text-muted">BASIC INFORMATION</p>
                                  <div class="row align-items-center w-100">
                                      <div class="col-lg-4">
                                          <p class="h5 text-truncate">Birthday: </p>
                                      </div>
                                      <div class="col-lg-8 ">
                                          <p class="h6"><?= $row_profile['date_of_birth']?></p>
                                      </div>
                                  </div>
                                  <div class="editBtn my-5">
                                    <a class="btn btn-black op-8" href="edit-profile.php?user_id=<?php echo $row_profile['user_id']?>">Edit</a>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                  <?php
                  }
                }
                ?>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/scripts.php'); 
?>