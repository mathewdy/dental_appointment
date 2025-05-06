<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/config.php');
$role = $_SESSION['role_id'];
echo '
<div class="main-header">
  <div class="main-header-logo">
    <div class="logo-header" data-background-color="dark">
      <a href="index.html" class="logo">
        <img
          src="assets/img/kaiadmin/logo_light.svg"
          alt="navbar brand"
          class="navbar-brand"
          height="20"
        />
      </a>
      <div class="nav-toggle">
        <button class="btn btn-toggle toggle-sidebar">
          <i class="gg-menu-right"></i>
        </button>
        <button class="btn btn-toggle sidenav-toggler">
          <i class="gg-menu-left"></i>
        </button>
      </div>
      <button class="topbar-toggler more">
        <i class="gg-more-vertical-alt"></i>
      </button>
    </div>
  </div>
  <nav
    class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"
  >
    <div class="container-fluid">

      <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
        <li class="nav-item topbar-icon dropdown hidden-caret ">
          <a
            class="nav-link dropdown-toggle disabled"
            href="#"
            id="notifDropdown"
            role="button"
            data-bs-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            <i class="fa fa-bell"></i>
            <!-- <span class="notification bg-danger">4</span> -->
          </a>
          <ul
            class="dropdown-menu notif-box animated fadeIn"
            aria-labelledby="notifDropdown"
          >
            <li>
              <div class="dropdown-title">
                You have 4 new notification
              </div>
            </li>
            <li>
              <div class="notif-scroll scrollbar-outer">
                <div class="notif-center">
                  <a href="#">
                    <div class="notif-icon notif-primary">
                      <i class="fa fa-user-plus"></i>
                    </div>
                    <div class="notif-content">
                      <span class="block"> New user registered </span>
                      <span class="time">5 minutes ago</span>
                    </div>
                  </a>
                  <a href="#">
                    <div class="notif-icon notif-success">
                      <i class="fa fa-comment"></i>
                    </div>
                    <div class="notif-content">
                      <span class="block">
                        Rahmad commented on Admin
                      </span>
                      <span class="time">12 minutes ago</span>
                    </div>
                  </a>
                  <a href="#">
                    <div class="notif-img">
                      <img
                        src="assets/img/profile2.jpg"
                        alt="Img Profile"
                      />
                    </div>
                    <div class="notif-content">
                      <span class="block">
                        Reza send messages to you
                      </span>
                      <span class="time">12 minutes ago</span>
                    </div>
                  </a>
                  <a href="#">
                    <div class="notif-icon notif-danger">
                      <i class="fa fa-heart"></i>
                    </div>
                    <div class="notif-content">
                      <span class="block"> Farrah liked Admin </span>
                      <span class="time">17 minutes ago</span>
                    </div>
                  </a>
                </div>
              </div>
            </li>
            <li>
              <a class="see-all" href="javascript:void(0);"
                >See all notifications<i class="fa fa-angle-right"></i>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item topbar-user dropdown hidden-caret">
          <a
            class="dropdown-toggle profile-pic"
            data-bs-toggle="dropdown"
            href="#"
            aria-expanded="false"
          >
            <div class="avatar-sm">
              <img
                src="'. BASE_PATH . '/assets/img/default.jpg"
                alt="Userimg"
                class="avatar-img rounded-circle"
              />
            </div>
            <span class="profile-username">
              <span class="op-7">Hi,</span>
              <span class="fw-bold">' . $first_name .'</span>
            </span>
            
          </a>
          <ul class="dropdown-menu dropdown-user animated fadeIn">
            <div class="dropdown-user-scroll scrollbar-outer">
              <li>';
              if($role == 1){
                echo '
                  <a class="dropdown-item" href="'. BASE_PATH . '/modules/patients/my-profile.php">My Profile</a>
                  <a class="dropdown-item" href="'. BASE_PATH . '/auth/logout.php ">Logout</a>
                ';
              }
              if($role == 2){
                echo '
                  <a class="dropdown-item" href="'. BASE_PATH . '/modules/admin/my-profile.php">My Profile</a>
                  <a class="dropdown-item" href="'. BASE_PATH . '/auth_main/logout.php ">Logout</a>
                ';
              }
              if($role == 3){
                echo '
                  <a class="dropdown-item" href="'. BASE_PATH . '/modules/dentist/my-profile.php">My Profile</a>
                  <a class="dropdown-item" href="'. BASE_PATH . '/auth_main/logout.php ">Logout</a>
                ';
              }
              echo '</li>
            </div>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</div>
';
?>