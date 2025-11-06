<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/config.php');
$role = $_SESSION['role_id'];
$id = $_SESSION['user_id'];
$roleHandler = match($role) {
  1 => 'patients',
  2 => 'admin',
  3 => 'dentists'
};
echo '
<div class="main-header">
  <div class="main-header-logo">
    <div class="logo-header" data-background-color="dark2">
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
            class="nav-link dropdown-toggle "
            href="#"
            id="notifDropdown"
            role="button"
            data-bs-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            <i class="fa fa-bell"></i>
            <span class="notification bg-danger" id="notifCount" style="display:none;">0</span>
          </a>
          <ul
            class="dropdown-menu notif-box animated fadeIn"
            aria-labelledby="notifDropdown"
          >
            <li>
              <div class="notif-scroll scrollbar-outer">
                <div class="notif-center" id="notif">
                </div>
              </div>
            </li>
            <li>
              <a class="see-all" href="'. BASE_PATH . '/modules/' . $roleHandler . '/notification.php"
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
          <ul class="dropdown-menu w-50 dropdown-user animated fadeIn">
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