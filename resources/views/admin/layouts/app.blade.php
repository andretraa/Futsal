<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta charset="utf-8" />
    <title>Dashboard Admin - Andre Tri Rizky</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="title" content="Dashboard Admin - Andre Tri Rizky" />
    <meta name="author" content="ColorlibHQ" />
    <meta name="description" content="AdminLTE is a Free Bootstrap 5 Admin Dashboard" />
    <meta name="keywords" content="admin dashboard, adminlte 4, bootstrap 5 admin" />

    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" />
    <!--end::Fonts-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <!--begin::Plugins-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <!--end::Plugins-->

    <!--begin::AdminLTE -->
    <link rel="stylesheet" href="{{ asset('admin/dist/css/adminlte.css')}}" />
    <!--end::AdminLTE-->

    <!--begin::Custom Style-->
    <style>
      .app-header.navbar {
        background: linear-gradient(45deg, #0d6efd, #6610f2);
        color: #fff;
      }
      .app-footer {
        background-color: #f8f9fa;
        border-top: 1px solid #dee2e6;
        padding: 15px;
        font-size: 14px;
      }
      .user-header {
        background: #343a40;
      }
      .navbar-nav .nav-link {
        color: white !important;
      }
    </style>
    <!--end::Custom Style-->
  </head>
  <!--end::Head-->

  <!--begin::Body-->
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
      <!--begin::Navbar-->
      <nav class="app-header navbar navbar-expand">
        <div class="container-fluid">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-lte-toggle="sidebar" href="#"><i class="bi bi-list"></i></a>
            </li>
          </ul>

          <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-search"></i></a></li>
            <li class="nav-item dropdown">
              <a class="nav-link" data-bs-toggle="dropdown" href="#"><i class="bi bi-bell-fill"></i><span class="badge text-bg-warning">15</span></a>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <span class="dropdown-item dropdown-header">15 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item"><i class="bi bi-envelope me-2"></i> 4 new messages</a>
                <a href="#" class="dropdown-item"><i class="bi bi-people-fill me-2"></i> 8 friend requests</a>
                <a href="#" class="dropdown-item"><i class="bi bi-file-earmark-fill me-2"></i> 3 new reports</a>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
              </div>
            </li>

            <li class="nav-item dropdown user-menu">
              <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <img src="{{asset('admin/dist/assets/img/user2-160x160.jpg')}}" class="user-image rounded-circle shadow" alt="User Image" />
                <span class="d-none d-md-inline">Andre Tri Rizky</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <li class="user-header text-bg-primary">
                  <img src="{{asset('admin/dist/assets/img/user2-160x160.jpg')}}" class="rounded-circle shadow" alt="User Image" />
                  <p>Andre Tri Rizky - Admin Futsal<br /><small>Member since Nov. 2023</small></p>
                </li>
                <li class="user-footer d-flex justify-content-between px-3">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                  <form action="{{ route('logout') }}" method="POST" id="logout-form">
                    @csrf
                    <button type="submit" class="btn btn-default btn-flat">Sign out</button>
                  </form>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
      <!--end::Navbar-->

      <!--begin::Sidebar-->
      @include('admin.layouts.sidebar')
      <!--end::Sidebar-->

      <!--begin::Main-->
      <main class="app-main">
        @yield('content')
      </main>
      <!--end::Main-->

      <!--begin::Footer-->
      <footer class="app-footer">
        <div class="float-end d-none d-sm-inline">Siap Main Bola!</div>
        <strong>Copyright &copy; 2014–2024 <a href="https://adminlte.io" class="text-decoration-none">AdminLTE.io</a>.</strong> All rights reserved.
      </footer>
      <!--end::Footer-->
    </div>

    <!--begin::Scripts-->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="{{asset('admin/dist/js/adminlte.js')}}"></script>

    <!-- Scrollbar Init -->
    <script>
      const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
      const Default = {
        scrollbarTheme: 'os-theme-light',
        scrollbarAutoHide: 'leave',
        scrollbarClickScroll: true,
      };
      document.addEventListener('DOMContentLoaded', function () {
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
        if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
          OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
            scrollbars: {
              theme: Default.scrollbarTheme,
              autoHide: Default.scrollbarAutoHide,
              clickScroll: Default.scrollbarClickScroll,
            },
          });
        }
      });
    </script>
    <!--end::Scripts-->
  </body>
  <!--end::Body-->
</html>