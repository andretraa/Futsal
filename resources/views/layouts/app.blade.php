<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Futsal Bumi Sariwangi</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <!-- Main CSS File -->
  <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
  @stack('style')

</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top shadow-sm bg-dark">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
  
      <!-- Logo -->
      <a href="/" class="logo d-flex align-items-center">
        <h1 class="sitename m-0 fw-bold text-success">BSW</h1>
      </a>
  
      <!-- Navigation Menu -->
      <nav id="navmenu" class="navmenu d-none d-xl-block">
        <ul class="nav gap-3">
          <li class="nav-item">
            <a href="/" class="nav-link {{ Request::is('/') ? 'active fw-bold text-success' : 'text-white' }}">Home</a>
          </li>
          <li class="nav-item">
            <a href="/about" class="nav-link {{ Request::is('about') ? 'active fw-bold text-success' : 'text-white' }}">About</a>
          </li>
          <li class="nav-item">
            <a href="/field" class="nav-link {{ Request::is('field') ? 'active fw-bold text-success' : 'text-white' }}">Field</a>
          </li>
          @auth
          <li class="nav-item">
            <span class="nav-link fw-semibold text-success">{{ auth()->user()->name }}</span>
          </li>
          @endauth
        </ul>
      </nav>
  
      <!-- Mobile Toggle -->
      <i class="mobile-nav-toggle d-xl-none bi bi-list fs-3 text-white"></i>
  
      <!-- Auth Buttons -->
      <div class="d-flex align-items-center">
        @auth
        <form action="{{ route('logout') }}" method="post" class="m-0">
          @csrf
          <button type="submit" class="btn btn-outline-light rounded-pill px-4 py-2 ms-3 d-flex align-items-center gap-2">
            <i class="bi bi-box-arrow-right"></i> Logout
          </button>
        </form>
        @endauth
  
        @guest
        <a href="/login" class="btn btn-success rounded-pill px-4 py-2 ms-3 d-flex align-items-center gap-2">
          <i class="bi bi-box-arrow-in-right"></i> Login
        </a>
        @endguest
      </div>
  
    </div>
  </header>
  
  

  <main class="main">
    @yield('content')
  </main>

  <footer id="footer" class="footer dark-background">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.html" class="logo d-flex align-items-center">
            <span class="sitename">BSW</span>
          </a>
          <div class="footer-contact pt-3">
            <p>Jalan Sariwangi</p>
            <p>Komplek Bumi Sariwangi 1, Kecamatan Parongpong</p>
            <p class="mt-3"><strong>Phone:</strong> <span>+62 87789235490</span></p>
            <p><strong>Email:</strong> <span>gorbumisariwangi1@gmail.com</span></p>
          </div>
          <div class="social-links d-flex mt-4">
            <a href=""><i class="bi bi-twitter-x"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Useful Links</h4>
          <ul>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Home</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">About us</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Services</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Terms of service</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Privacy policy</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Our Services</h4>
          <ul>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Web Design</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Web Development</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Product Management</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Marketing</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Graphic Design</a></li>
          </ul>
        </div>

        <div class="col-lg-4 col-md-12 footer-newsletter">
          <h4>Our Newsletter</h4>
          <p>Subscribe to our newsletter and receive the latest news about our products and services!</p>
          <form action="forms/newsletter.php" method="post" class="php-email-form">
            <div class="newsletter-form"><input type="email" name="email"><input type="submit" value="Subscribe"></div>
            <div class="loading">Loading</div>
            <div class="error-message"></div>
            <div class="sent-message">Your subscription request has been sent. Thank you!</div>
          </form>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">

        Create by <a href="https://bootstrapmade.com/">Andre Tri Rizky</a>
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>


  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>
  @stack('scripts')

</body>

</html>