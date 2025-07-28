<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Profil Saya - Futsal Bumi Sariwangi</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

  <!-- Main CSS File -->
  <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

  <style> 
    /* Import Google Fonts untuk font yang lebih menarik */
    @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700;800;900&family=Roboto:wght@300;400;500;700;900&family=Open+Sans:wght@300;400;500;600;700;800&display=swap');

    :root {
      --primary-color: #1e40af;
      --secondary-color: #3b82f6;
      --accent-color: #60a5fa;
      --light-bg: #f8faff;
      --card-bg: #ffffff;
      --text-primary: #ffffff;
      --text-secondary: #4a4a4a;
      --border-color: #e2e8f0;
      --success-light: #f0f9ff;
      --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
      --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    body {
      font-family: 'Nunito', 'Open Sans', sans-serif;
      background: linear-gradient(135deg, #f8faff 0%, #e0f2fe 100%);
      color: var(--text-primary);
      line-height: 1.7;
      padding: 2rem 0;
      font-weight: 400;
    }

    .main-container {
      max-width: 1200px;
      margin: 0 auto;
    }

    .page-header {
      text-align: center;
      margin-bottom: 3rem;
      padding: 2rem 0;
    }

    .page-title {
      font-family: 'Roboto', sans-serif;
      font-size: 2.8rem;
      font-weight: 800;
      color: #000000;
      margin-bottom: 0.5rem;
      position: relative;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      letter-spacing: -0.5px;
    }

    .page-title::after {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
      width: 80px;
      height: 4px;
      background: linear-gradient(90deg, var(--accent-color), var(--secondary-color));
      border-radius: 2px;
    }

    .page-subtitle {
      color: var(--text-secondary);
      font-size: 1.2rem;
      margin-top: 1rem;
      font-weight: 500;
      font-family: 'Open Sans', sans-serif;
    }

    .profile-card, .booking-card-main {
      background: var(--card-bg);
      border: none;
      border-radius: 20px;
      box-shadow: var(--shadow-lg);
      overflow: hidden;
      transition: all 0.3s ease;
      position: relative;
    }

    .profile-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 6px;
      background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
    }

    .card-header-custom {
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
      color: white;
      padding: 1.5rem;
      border: none;
      position: relative;
      overflow: hidden;
    }

    .card-header-custom::before {
      content: '';
      position: absolute;
      top: -50%;
      right: -50%;
      width: 100%;
      height: 200%;
      background: rgba(255, 255, 255, 0.1);
      transform: rotate(45deg);
      transition: all 0.3s ease;
    }

    .card-header-custom:hover::before {
      right: -45%;
    }

    .card-header-title {
      font-family: 'Roboto', sans-serif;
      font-size: 1.4rem;
      font-weight: 700;
      margin: 0;
      color: var(--text-primary);
      position: relative;
      z-index: 1;
      letter-spacing: 0.3px;
    }

    .profile-info {
      padding: 2rem;
    }

    .info-item {
      margin-bottom: 1.5rem;
      padding: 1.2rem;
      background: var(--light-bg);
      border-radius: 12px;
      border-left: 4px solid var(--accent-color);
      transition: all 0.2s ease;
    }

    .info-item:hover {
      transform: translateX(5px);
      box-shadow: var(--shadow-sm);
    }

    .info-label {
      font-weight: 700;
      color: var(--text-secondary);
      font-size: 0.9rem;
      text-transform: uppercase;
      letter-spacing: 1px;
      margin-bottom: 0.5rem;
      font-family: 'Roboto', sans-serif;
    }

    .info-value {
      font-size: 1.2rem;
      color: #000000;
      font-weight: 600;
      margin: 0;
      font-family: 'Nunito', sans-serif;
    }

    .status-badge {
      font-size: 0.8rem;
      padding: 0.6rem 1.2rem;
      border-radius: 20px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.8px;
      font-family: 'Roboto', sans-serif;
    }

    .status-active {
      background: linear-gradient(135deg, #48bb78, #38a169);
      color: white;
      box-shadow: 0 2px 4px rgba(72, 187, 120, 0.3);
    }

    .booking-card {
      background: var(--card-bg);
      border: none;
      border-radius: 16px;
      box-shadow: var(--shadow-md);
      transition: all 0.3s ease;
      overflow: hidden;
      position: relative;
      height: 100%;
    }

    .booking-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, var(--accent-color), var(--secondary-color));
    }

    .booking-card:hover {
      transform: translateY(-8px);
      box-shadow: var(--shadow-lg);
    }

    .booking-card-body {
      padding: 1.5rem;
    }

    .booking-title {
      font-family: 'Roboto', sans-serif;
      font-size: 1.3rem;
      font-weight: 700;
      color: #000000;
      margin-bottom: 1rem;
      letter-spacing: 0.2px;
    }

    .booking-status {
      font-size: 0.75rem;
      padding: 0.4rem 1rem;
      border-radius: 15px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      font-family: 'Roboto', sans-serif;
    }

    .status-confirmed {
      background: linear-gradient(135deg, #c6f6d5, #9ae6b4);
      color: #22543d;
    }

    .status-pending {
      background: linear-gradient(135deg, #fef5e7, #fbd38d);
      color: #744210;
    }

    .status-cancelled {
      background: linear-gradient(135deg, #fed7d7, #fc8181);
      color: #742a2a;
    }

    .booking-detail {
      display: flex;
      align-items: center;
      margin-bottom: 0.8rem;
      color: var(--text-secondary);
      font-size: 1rem;
      font-weight: 500;
      font-family: 'Open Sans', sans-serif;
    }

    .booking-detail i {
      width: 20px;
      color: var(--accent-color);
      margin-right: 0.5rem;
    }

    .invoice-btn {
      background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
      border: none;
      color: white;
      padding: 0.8rem 1.6rem;
      border-radius: 25px;
      font-weight: 700;
      font-size: 0.9rem;
      text-transform: uppercase;
      letter-spacing: 0.8px;
      transition: all 0.3s ease;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      display: inline-block;
      text-align: center;
      font-family: 'Roboto', sans-serif;
    }

    .invoice-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      color: white;
    }

    .booking-now-btn {
      background: linear-gradient(135deg, var(--accent-color), var(--secondary-color));
      border: none;
      color: white;
      padding: 1.2rem 2.4rem;
      border-radius: 30px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 1px;
      transition: all 0.3s ease;
      margin-top: 1rem;
      display: inline-block;
      font-family: 'Roboto', sans-serif;
      font-size: 1rem;
    }

    .booking-now-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
      color: white;
    }

    .empty-state {
      text-align: center;
      padding: 4rem 2rem;
      color: var(--text-secondary);
    }

    .empty-state i {
      font-size: 4rem;
      color: var(--accent-color);
      margin-bottom: 1.5rem;
      opacity: 0.7;
    }

    .empty-state h5 {
      font-family: 'Roboto', sans-serif;
      font-weight: 700;
      color: #000000;
      margin-bottom: 1rem;
      font-size: 1.4rem;
    }

    .total-booking-badge {
      background: rgba(255, 255, 255, 0.2);
      color: white;
      padding: 0.6rem 1.2rem;
      border-radius: 20px;
      font-size: 0.9rem;
      font-weight: 700;
      font-family: 'Roboto', sans-serif;
      letter-spacing: 0.5px;
    }

    .stats-row {
      margin-bottom: 2rem;
    }

    .stat-card {
      background: linear-gradient(135deg, var(--card-bg), var(--light-bg));
      padding: 1.8rem;
      border-radius: 16px;
      box-shadow: var(--shadow-sm);
      text-align: center;
      border: 1px solid var(--border-color);
      transition: all 0.3s ease;
    }

    .stat-card:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-md);
    }

    .stat-number {
      font-size: 2.4rem;
      font-weight: 900;
      color: #000000;
      font-family: 'Roboto', sans-serif;
      letter-spacing: -1px;
    }

    .stat-label {
      color: var(--text-secondary);
      font-size: 1rem;
      margin-top: 0.5rem;
      font-weight: 600;
      font-family: 'Open Sans', sans-serif;
    }

    .profile-avatar {
      width: 80px;
      height: 80px;
      background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1.5rem;
      color: white;
      font-size: 2rem;
      font-weight: 700;
      font-family: 'Roboto', sans-serif;
    }

    /* Styling untuk semua heading */
    h1, h2, h3, h4, h5, h6 {
      font-family: 'Roboto', sans-serif;
      color: #000000;
      font-weight: 700;
    }

    /* Styling untuk semua paragraph */
    p {
      font-family: 'Open Sans', sans-serif;
      color: #000000;
      font-weight: 500;
    }

    /* Styling untuk semua span */
    span {
      font-family: 'Nunito', sans-serif;
      color: #000000;
    }

    @media (max-width: 768px) {
      .page-title {
        font-size: 2.2rem;
      }
      
      .profile-info, .booking-card-body {
        padding: 1.25rem;
      }
      
      .main-container {
        padding: 0 1rem;
      }
    }
    /* Payment Button Styles */
.payment-btn {
  background: linear-gradient(135deg, #f59e0b, #d97706);
  border: none;
  color: white;
  padding: 0.8rem 1.6rem;
  border-radius: 25px;
  font-weight: 700;
  font-size: 0.9rem;
  text-transform: uppercase;
  letter-spacing: 0.8px;
  transition: all 0.3s ease;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  display: inline-block;
  text-align: center;
  font-family: 'Roboto', sans-serif;
}

.payment-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(245, 158, 11, 0.3);
  color: white;
  background: linear-gradient(135deg, #d97706, #b45309);
}

/* Cancelled Button Styles */
.cancelled-btn {
  background: linear-gradient(135deg, #6b7280, #4b5563);
  border: none;
  color: white;
  padding: 0.8rem 1.6rem;
  border-radius: 25px;
  font-weight: 700;
  font-size: 0.9rem;
  text-transform: uppercase;
  letter-spacing: 0.8px;
  font-family: 'Roboto', sans-serif;
  cursor: not-allowed;
  opacity: 0.7;
}
.transition-all {
  transition: all 0.3s ease;
}
.transition-all:hover {
  transform: translateX(-3px);
  background-color: #e7f1ff;
}


</style>


</head>
<body>
  <!-- Back to Home Button -->
 <div class="container mt-4 mb-4">
  <a href="/" class="btn btn-outline-primary d-inline-flex align-items-center gap-2 shadow-sm" style="border-radius: 10px; padding: 10px 16px;">
    <i class="bi bi-arrow-left"></i>
    <span>Kembali ke Home</span>
  </a>
</div>
  <div class="main-container">
    <!-- Page Header -->

    <div class="container-fluid">
      <div class="row">
        <!-- Profile Information -->
        <div class="col-lg-4 mb-4">
          <div class="profile-card">
            <div class="card-header-custom">
              <h5 class="card-header-title">
                <i class="bi bi-person-circle me-2"></i>Informasi Profil
              </h5>
            </div>
            <div class="profile-info">
              <!-- Profile Avatar -->
              <div class="profile-avatar">
                <i class="bi bi-person-fill"></i>
              </div>
              
              <div class="info-item">
                <div class="info-label">
                  <i class="bi bi-person me-1"></i>Nama Lengkap
                </div>
                <p class="info-value">{{ auth()->user()->name }}</p>
              </div>
              
              <div class="info-item">
                <div class="info-label">
                  <i class="bi bi-envelope me-1"></i>Email
                </div>
                <p class="info-value">{{ auth()->user()->email }}</p>
              </div>
              
              <div class="info-item">
                <div class="info-label">
                  <i class="bi bi-calendar-plus me-1"></i>Tanggal Bergabung
                </div>
                <p class="info-value">{{ auth()->user()->created_at->format('d F Y') }}</p>
              </div>
              
              <div class="info-item">
                <div class="info-label">
                  <i class="bi bi-shield-check me-1"></i>Status Akun
                </div>
                <p class="info-value">
                  <span class="status-badge status-active">Aktif</span>
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Booking History -->
        <div class="col-lg-8">
          <!-- Stats Row -->
          <div class="row stats-row">
            <div class="col-md-4 mb-3">
              <div class="stat-card">
                <div class="stat-number">{{ isset($bookings) ? $bookings->count() : 0 }}</div>
                <div class="stat-label">Total Booking</div>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <div class="stat-card">
                <div class="stat-number">{{ isset($bookings) ? $bookings->where('status', 'confirmed')->count() : 0 }}</div>
                <div class="stat-label">Booking Selesai</div>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <div class="stat-card">
                <div class="stat-number">{{ isset($bookings) ? $bookings->where('status', 'pending')->count() : 0 }}</div>
                <div class="stat-label">Booking Aktif</div>
              </div>
            </div>
          </div>

          <div class="booking-card-main">
            <div class="card-header-custom d-flex justify-content-between align-items-center">
              <h5 class="card-header-title">
                <i class="bi bi-clock-history me-2"></i>Riwayat Booking
              </h5>
              <span class="total-booking-badge">
                {{ isset($bookings) ? $bookings->count() : 0 }} Total Booking
              </span>
            </div>
            <div class="card-body" style="padding: 2rem;">
              @if(isset($bookings) && $bookings->count() > 0)
              <div class="row">
                @foreach($bookings as $booking)
                <div class="col-md-6 mb-4">
                  <div class="booking-card">
                    <div class="booking-card-body">
                      <div class="d-flex justify-content-between align-items-start mb-3">
                        <h6 class="booking-title">{{ $booking->field->nama ?? 'Lapangan A' }}</h6>
                        <span class="booking-status 
                          @if(($booking->status ?? 'confirmed') == 'confirmed') status-confirmed
                          @elseif(($booking->status ?? 'pending') == 'pending') status-pending
                          @else status-cancelled
                          @endif">
                          {{ ucfirst($booking->status ?? 'Confirmed') }}
                        </span>
                      </div>
                      
                      <div class="booking-detail">
                        <i class="bi bi-calendar3"></i>
                        <span>{{ isset($booking->tanggal_pemesanan) ? \Carbon\Carbon::parse($booking->tanggal_pemesanan)->format('d M Y') : '15 Des 2024' }}</span>
                      </div>
                      
                      <div class="booking-detail">
                        <i class="bi bi-clock"></i>
                        <span>{{ $booking->start_time ?? '08:00' }} - {{ $booking->end_time ?? '10:00' }}</span>
                      </div>
                      
                      <div class="booking-detail">
                        <i class="bi bi-currency-dollar"></i>
                        <span>Rp {{ number_format($booking->total_harga ?? 150000, 0, ',', '.') }}</span>
                      </div>
                      
                      <div class="booking-detail mb-3">
                        <i class="bi bi-receipt"></i>
                        <span>ID: #{{ $booking->id ?? 'BSW001' }}</span>
                      </div>
                      
                      <!-- Conditional Button Based on Status -->
                      @if(($booking->status ?? 'confirmed') == 'pending')
                       <a href="{{ route('admin.bookings.process', $booking->id) }}" class="payment-btn w-100 text-decoration-none">
                        <i class="bi bi-credit-card me-2"></i>Lakukan Pembayaran
                      </a>
                      @elseif(($booking->status ?? 'confirmed') == 'confirmed')
                        <a href="{{ route('booking.finish', $booking->id) }}" class="invoice-btn w-100 text-decoration-none">
                          <i class="bi bi-file-earmark-text me-2"></i>Lihat Invoice
                        </a>
                      @else
                        <button class="cancelled-btn w-100" disabled>
                          <i class="bi bi-x-circle me-2"></i>Booking Dibatalkan
                        </button>
                      @endif
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
              
              <!-- Pagination jika diperlukan -->
              @if(method_exists($bookings, 'links'))
                <div class="d-flex justify-content-center mt-4">
                  {{ $bookings->links() }}
                </div>
              @endif
              @else
              <div class="empty-state">
                <i class="bi bi-calendar-x"></i>
                <h5>Belum Ada Booking</h5>
                <p>Anda belum melakukan booking lapangan futsal.</p>
                <a href="/field" class="booking-now-btn text-decoration-none">
                  <i class="bi bi-plus-circle me-2"></i>Booking Sekarang
                </a>
              </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  
  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  <!-- Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>
  
  <script>
    // Add smooth scroll and animation effects
    document.addEventListener('DOMContentLoaded', function() {
      // Animate cards on scroll
      const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
      };

      const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
          }
        });
      }, observerOptions);

      // Apply animation to cards
      document.querySelectorAll('.booking-card, .profile-card, .stat-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
      });
    });
  </script>
  <script src="{{ asset('assets/js/main.js') }}"></script>
  
  <script>
    // Add smooth scroll and animation effects
    document.addEventListener('DOMContentLoaded', function() {
      // Animate cards on scroll
      const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
      };
      const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
          }
        });
      }, observerOptions);
      // Apply animation to cards
      document.querySelectorAll('.booking-card, .profile-card, .stat-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
      });
    });
  </script>
</body>
</html>