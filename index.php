<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dental_appointment/config.php');
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

  <section id="home" class="py-5 bg-dark text-white text-center h-75 px-5">
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
              <i class="fas fa-smile-beam fa-3x text-primary mb-3"></i>
              <h5 class="card-title">
                Oral Prophylaxis
              </h5>
              <p class="card-text">
                A professional cleaning that removes plaque, tartar, and stains from your teeth. It helps prevent cavities, gum disease, and keeps your mouth feeling fresh and healthy.
              </p>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="card shadow-sm">
            <div class="card-body">
              <i class="fas fa-smile fa-3x text-primary mb-3"></i>
              <h5 class="card-title">
                Composite Restoration
              </h5>
              <p class="card-text">
                A tooth-colored filling used to repair decayed or damaged teeth. It restores your tooth’s
                natural look and function while blending perfectly with your smile.
              </p>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="card shadow-sm">
            <div class="card-body">
              <i class="fas fa-teeth fa-3x text-primary mb-3"></i>
              <h5 class="card-title">
                Cosmetic Dentistry
              </h5>
              <p class="card-text">
                A cosmetic procedure that enhances the shape, color, and overall appearance of your teeth
                using a special composite material — perfect for improving your smile instantly.
              </p>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="card shadow-sm">
            <div class="card-body">
              <i class="fas fa-syringe fa-3x text-primary mb-3"></i>
              <h5 class="card-title">
                Dental Extraction / Surgery
              </h5>
              <p class="card-text">
                The removal of a damaged or decayed tooth that can no longer be saved. This helps prevent
                pain, infection, or damage to nearby teeth.
              </p>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="card shadow-sm">
            <div class="card-body">
              <i class="fas fa-tooth fa-3x text-primary mb-3"></i>
              <h5 class="card-title">
                Wisdom Tooth Removal
              </h5>
              <p class="card-text">
                A surgical procedure to remove impacted or painful wisdom teeth. It relieves discomfort and
                prevents future dental problems caused by overcrowding or infection.
              </p>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="card shadow-sm">
            <div class="card-body">
              <i class="fas fa-teeth fa-3x text-primary mb-3"></i>
              <h5 class="card-title">
                Prosthodontics (Dentures)
              </h5>
              <p class="card-text">
                Replace missing teeth with dentures that can be taken out for cleaning, available in US
                Plastic for an affordable and durable option, Porcelain for a natural and strong appearance,
                and Flexible for a lightweight, comfortable, and perfect fit.
              </p>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="card shadow-sm">
            <div class="card-body">
              <i class="fas fa-syringe fa-3x text-primary mb-3"></i>
              <h5 class="card-title">
                Orthodontics (Braces)
              </h5>
              <p class="card-text">
                A treatment that straightens crooked or crowded teeth using metal brackets and wires. It
                improves both your bite and smile for long-term dental health.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="about" class="py-5 my-5 px-5">
    <div class="container d-flex justify-content-center">
      <div class="row justify-content-center gap-5">
        <div class="col-lg-4">
          <div class="card" style=" border-radius: 25px;">
            <img src="<?= BASE_PATH . '/assets/img/Dentistandpat.png';?>" class="w-100 h-100"  style="border-radius: 25px;" alt="">
          </div>
        </div>
        <div class="col-lg-4">
          <h2 class="fw-bold mb-3 fs-1">About Us</h2>
          <p class="fs-5 text-wrap" style="text-align: justify;">
            At Fojas Dental, we care about your smile. Our friendly team provides quality dental
            services using reliable approaches in a clean and comfortable environment, making sure
            every visit helps you smile with confidence.
          </p>
        </div>
      </div>
    </div>
  </section>


  <section id="contact" class="py-5 bg-dark text-white">
    <div class="container text-center">
      <h2 class="fw-bold mb-4">Contact Us</h2>
      <p><i class="icon-location-pin"></i>
        121 Sta. Cruz St. Poblacion 1 Tanza, Cavite</p>
      <p><i class="icon-phone"></i>   09178668636 | 09177089099</p>
      <p>📧 fojasdentalclinic@gmail.com</p>
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
    dots: false,
    center: true,
    responsive: {
    0: {
      items: 1
    },
    576: {
      items: 2
    },
    992: {
      items: 3
    }
  }
})
</script>

