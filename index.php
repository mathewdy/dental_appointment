<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/header.php');
?>
  <style>
    .owl-carousel {
      display: flex !important;
      justify-content: center !important;
      position: relative !important;
    }

    .owl-stage {
      display: flex !important;
      justify-content: center !important;
    }

    .item .card {
      height: 100%;
    }

    .owl-nav {
      position: absolute !important;
      top: 41% !important;
      width: 100% !important;
      transform: translateY(-50%) !important;
      display: flex !important;
      justify-content: space-between !important;
      pointer-events: none !important;
    }

    .owl-nav button {
      pointer-events: all !important;
      color: black !important;
      border-radius: 50%;
      width: 40px !important;
      height: 40px !important;
      font-size: 5rem !important;
      display: flex !important;
      align-items: center !important;
      justify-content: center !important;
    }

    .owl-nav button:hover {
      background: none !important;
    }
  </style>
  <nav class="navbar navbar-expand-lg navbar-light bg-dark shadow-sm py-3">
    <div class="container">
      <a href="#" class="navbar-brand fw-bold text-light logo">
            <img
            src="assets/img/banner-2.png"
            alt="navbar brand"
            class="navbar-brand"
            height="40"
            /> 
        </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
        data-bs-target="#navbarNav" aria-controls="navbarNav"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link active" href="#home">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
          <li class="nav-item"><a class="nav-link" href="#about">About Us</a></li>
          <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
          <li class="nav-item ms-2">
            <a href="auth/login.php" class="btn btn-primary">Log In</a>
            <a href="auth/registration.php" class="btn btn-light op-5">Sign Up</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <section id="home" class="py-5 bg-dark text-white text-center h-50">
    <div class="container d-flex justify-content-center align-items-center" style="height: 100%;">
      <span>
        <h1 class="display-4 fw-bold">We take care of your teeth</h1>
        <p class="lead">Quality dental care with a gentle touch</p>
        <a href="#about" class="btn btn-light btn-lg rounded-pill mt-3">About Us</a>
      </span>
    </div>
  </section>

  <section id="services" class="py-5 my-5">
    <div class="container text-center">
      <h2 class="fw-bold mb-4">Our Services</h2>
      <div class="owl-carousel owl-theme px-5">
        <div class="item">
          <div class="card shadow-sm">
            <div class="card-body">
              <i class="fas fa-tooth fa-3x text-primary mb-3"></i>
              <h5 class="card-title">General Dentistry</h5>
              <p class="card-text">Routine checkups, cleaning, and preventive care for all ages.</p>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="card shadow-sm">
            <div class="card-body">
              <i class="fas fa-smile fa-3x text-primary mb-3"></i>
              <h5 class="card-title">Cosmetic Dentistry</h5>
              <p class="card-text">Teeth whitening, veneers, and aesthetic smile transformations.</p>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="card shadow-sm">
            <div class="card-body">
              <i class="fas fa-syringe fa-3x text-primary mb-3"></i>
              <h5 class="card-title">Oral Surgery</h5>
              <p class="card-text">Extractions, implants, and advanced dental procedures.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="about" class="py-5 my-5 bg-light">
    <div class="container text-center">
      <h2 class="fw-bold mb-4">About Us</h2>
      <p class="lead">
        At <strong>Fojas Dental</strong>, we are committed to providing top-notch
        dental care in a comfortable environment. Our experienced team uses the
        latest technology to ensure every patient leaves with a confident smile.
      </p>
    </div>
  </section>


  <section id="contact" class="py-5 bg-dark text-white">
    <div class="container text-center">
      <h2 class="fw-bold mb-4">Contact Us</h2>
      <p class="lead"><i class="icon-location-pin"></i>
        123 Smile Street, Quezon City, Philippines</p>
      <p><i class="icon-phone"></i> (02) 1234-5678 | 📧 fojasdentalclinic@gmail.com</p>
    </div>
  </section>

  <footer class="bg-dark text-white text-center py-3">
    <small>&copy; 2025 Fojas Dental Clinic. All Rights Reserved.</small>
  </footer>

<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/includes/scripts.php');
?>
<script>
  $('.owl-carousel').owlCarousel({
    loop: true,
    margin: 10,
    nav: true,
    dots: true,
    center: true
})
</script>

