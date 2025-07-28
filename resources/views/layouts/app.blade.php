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
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

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
        </ul>
      </nav>
  
      <!-- Mobile Toggle -->
      <i class="mobile-nav-toggle d-xl-none bi bi-list fs-3 text-white"></i>
  
      <!-- Auth Buttons -->
      <div class="d-flex align-items-center">
        @auth
        <!-- My Account Dropdown -->
        <div class="dropdown">
          <button class="btn btn-outline-light rounded-pill px-4 py-2 ms-3 d-flex align-items-center gap-2 dropdown-toggle" 
                  type="button" 
                  id="accountDropdown" 
                  data-bs-toggle="dropdown" 
                  aria-expanded="false">
            <i class="bi bi-person-circle"></i> My Account
          </button>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown">
            <li>
              <span class="dropdown-item-text fw-semibold text-success">
                <i class="bi bi-person"></i> {{ auth()->user()->name }}
              </span>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <a class="dropdown-item" href="{{ route('profile') }}">
                    <i class="bi bi-person-gear"></i> Profile
                </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form action="{{ route('logout') }}" method="post" class="m-0">
                @csrf
                <button type="submit" class="dropdown-item text-danger">
                  <i class="bi bi-box-arrow-right"></i> Logout
                </button>
              </form>
            </li>
          </ul>
        </div>
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
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
document.addEventListener('DOMContentLoaded', function() {
    // Manual dropdown toggle
    const dropdownToggle = document.getElementById('accountDropdown');
    const dropdownMenu = dropdownToggle.nextElementSibling;
    
    dropdownToggle.addEventListener('click', function(e) {
        e.preventDefault();
        dropdownMenu.classList.toggle('show');
    });
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!dropdownToggle.contains(e.target) && !dropdownMenu.contains(e.target)) {
            dropdownMenu.classList.remove('show');
        }
    });
});
</script>
</body>

</html>