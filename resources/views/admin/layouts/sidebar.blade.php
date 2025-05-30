<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
  <!--begin::Sidebar Brand-->
  <div class="sidebar-brand">
    <a href="../index.html" class="brand-link">
      <img
        src="{{ asset('admin/dist/assets/img/AdminLTELogo.png') }}"
        alt="AdminLTE Logo"
        class="brand-image opacity-75 shadow"
      />
      <span class="brand-text fw-light">Admin</span>
    </a>
  </div>
  <!--end::Sidebar Brand-->

  <!--begin::Sidebar Wrapper-->
  <div class="sidebar-wrapper">
    <nav class="mt-2">
      <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
        
        <!-- Dashboard -->
        <li class="nav-item">
          <a href="/admin/dashboard" class="nav-link">
            <i class="nav-icon bi bi-speedometer2"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <!-- User -->
        <li class="nav-item">
          <a href="/users" class="nav-link">
            <i class="nav-icon bi bi-people-fill"></i>
            <p>User</p>
          </a>
        </li>

        <!-- Field -->
        <li class="nav-item">
          <a href="{{ route('admin.fields.index') }}" class="nav-link">
            <i class="nav-icon bi bi-map-fill"></i>
            <p>Field</p>
          </a>
        </li>

        <!-- Schedule -->
        <li class="nav-item">
          <a href="{{ route('admin.schedules.index') }}" class="nav-link">
            <i class="nav-icon bi bi-calendar-event-fill"></i>
            <p>Schedule</p>
          </a>
        </li>

        <!-- Booking -->
        <li class="nav-item">
          <a href="{{ route('admin.bookings.index') }}" class="nav-link">
            <i class="nav-icon bi bi-journal-bookmark-fill"></i>
            <p>Booking</p>
          </a>
        </li>

      </ul>
    </nav>
  </div>
  <!--end::Sidebar Wrapper-->
</aside>
