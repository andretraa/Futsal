@extends('layouts.app')

@push('style')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    
    
    .card {
        border: none;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        border-radius: 12px;
        overflow: hidden;
    }
    
    .card-header {
        background-color: var(--primary);
        color: white;
        padding: 16px;
        font-weight: 600;
        border-bottom: none;
    }
 
    
    .price-badge {
        background-color: var(--primary);
        color: white;
        font-size: 1.25rem;
        padding: 8px 16px;
        border-radius: 8px;
        display: inline-block;
        margin-bottom: 20px;
    }
    
    .carousel {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }
    
    .carousel-item img {
        height: 400px;
        object-fit: cover;
        width: 100%;
    }
    
    .carousel-caption {
        background: rgba(0, 0, 0, 0.6);
        border-radius: 8px;
        padding: 15px;
    }
    
    .form-label {
        font-weight: 500;
        color: #475569;
    }
    
    .form-control, .form-select {
        padding: 12px;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        font-size: 1rem;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
    }
    
    .payment-method-option {
        padding: 16px;
        margin-bottom: 15px;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .payment-method-option:hover {
        background-color: #f0f7ff;
    }
    
    .payment-method-option.selected {
        border-color: var(--primary);
        background-color: #eff6ff;
    }
    
    .payment-method-option img {
        height: 35px;
        margin-right: 15px;
    }
    
    .btn-primary {
        background-color: var(--primary);
        border-color: var(--primary);
        padding: 12px 24px;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        background-color: var(--primary-hover);
        border-color: var(--primary-hover);
        transform: translateY(-2px);
    }
    
    .facility-badge {
        background-color: #e2e8f0;
        color: #475569;
        font-size: 0.875rem;
        padding: 5px 10px;
        border-radius: 20px;
        margin-right: 8px;
        margin-bottom: 8px;
        display: inline-block;
    }
    
    .field-info {
        background-color: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
    }
    
    .field-description {
        margin: 20px 0;
        line-height: 1.7;
    }
    
    .alert {
        border-radius: 8px;
    }
    
    /* Loading Overlay */
    #loading-overlay {
        background: rgba(15, 23, 42, 0.8) !important;
    }
    
    #loading-overlay > div {
        padding: 25px 40px !important;
        border-radius: 12px !important;
    }
</style>
@endpush

@section('content')
<section class="section light-background">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="field-info">
                    @foreach ($fields as $data)
                        <h1 class="main-heading">{{ $data->nama }}</h1>
                        <div class="price-badge">
                            <i class="fas fa-tag me-2"></i>Rp. {{ number_format($data->harga, 0, ',', '.') }}
                        </div>
                        
                        <div id="fieldCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#fieldCarousel" data-bs-slide-to="0" class="active"></button>
                                <button type="button" data-bs-target="#fieldCarousel" data-bs-slide-to="1"></button>
                                <button type="button" data-bs-target="#fieldCarousel" data-bs-slide-to="2"></button>
                            </div>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="{{ asset('uploads/fields/' . $data->gambar) }}" class="d-block w-100" alt="{{ $data->nama }}">
                                    <div class="carousel-caption">
                                        <h5>{{ $data->nama }}</h5>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('assets/img/lapang.jpg') }}" class="d-block w-100" alt="Bumi Sariwangi">
                                    <div class="carousel-caption">
                                        <h5>Bumi Sariwangi</h5>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('assets/img/lapang.jpg') }}" class="d-block w-100" alt="Bumi Sariwangi">
                                    <div class="carousel-caption">
                                        <h5>Bumi Sariwangi</h5>
                                    </div>
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#fieldCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#fieldCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        </div>
                        
                        <div class="field-description">
                            <h4><i class="fas fa-info-circle me-2"></i>Deskripsi</h4>
                            <p>{{ $data->deskripsi }}</p>
                        </div>
                        
                        <div class="mb-4">
                            <h4><i class="fas fa-star me-2"></i>Fasilitas</h4>
                            <div class="mt-2">
                                <span class="facility-badge"><i class="fas fa-parking me-1"></i> Parkir Luas</span>
                                <span class="facility-badge"><i class="fas fa-shower me-1"></i> Kamar Ganti</span>
                                <span class="facility-badge"><i class="fas fa-restroom me-1"></i> Toilet</span>
                                <span class="facility-badge"><i class="fas fa-store me-1"></i> Kantin</span>
                                <span class="facility-badge"><i class="fas fa-wifi me-1"></i> WiFi</span>
                                <span class="facility-badge"><i class="fas fa-lightbulb me-1"></i> Lampu Sorot</span>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <h4><i class="fas fa-map-marker-alt me-2"></i>Lokasi</h4>
                            <p class="mb-2"><i class="fas fa-location-dot me-2"></i>Jl. Sariwangi No. 123, Bandung</p>
                            <div class="ratio ratio-16x9">
                                <!-- placeholder for map -->
                                <div class="bg-light d-flex align-items-center justify-content-center">
                                    <p class="text-muted">Peta lokasi lapangan</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card sticky-top" style="top: 20px; z-index: 100;">
                    <div class="card-header text-center fs-5 text-uppercase">
                        <i class="fas fa-calendar-check me-2"></i>BOOKING LAPANGAN BUMI SARIWANGI
                    </div>
                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong><i class="fas fa-exclamation-circle me-2"></i>Oops! Ada kesalahan saat mengisi form:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form id="booking-form" action="{{ route('admin.bookings.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="booking-date" class="form-label"><i class="fas fa-calendar me-2"></i>Tanggal Booking</label>
                                <input type="date" class="form-control" id="booking-date" name="tanggal_pemesanan" required>
                            </div>
                        
                            <div class="mb-3">
                                <label for="field-id" class="form-label"><i class="fas fa-futbol me-2"></i>Pilih Lapang</label>
                                <select id="field-id" class="form-select" name="field_id" required>
                                    <option value="">-- Pilih Lapang --</option>
                                    @foreach ($fields as $data)
                                        <option value="{{ $data->id }}" data-price="{{ $data->harga_perjam }}">{{ $data->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <div class="mb-3">
                                <label for="schedule-id" class="form-label"><i class="fas fa-clock me-2"></i>Pilih Jam</label>
                                <select id="schedule-id" class="form-select" name="schedule_id" required>
                                    <option value="">-- Pilih Jam --</option>
                                    @foreach ($schedules as $data)
                                        <option value="{{ $data->id }}">{{ $data->start_time }} - {{ $data->end_time }}</option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <div class="mb-4">
                                <label for="total-harga" class="form-label"><i class="fas fa-money-bill me-2"></i>Total Harga</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" id="total-harga-display" class="form-control" readonly>
                                    <input type="hidden" id="total-harga" name="total_harga">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label"><i class="fas fa-credit-card me-2"></i>Metode Pembayaran</label>
                                <input type="hidden" id="payment-method" name="payment_method" value="">
                                
                                <div class="payment-method-option" data-method="credit_card">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('assets/icons/credit-card.png') }}" alt="Credit Card">
                                        <div>
                                            <strong>Kartu Kredit/Debit</strong>
                                            <div class="small text-muted">Visa, Mastercard, JCB</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="payment-method-option" data-method="bank_transfer">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('assets/icons/bank.png') }}" alt="Bank Transfer">
                                        <div>
                                            <strong>Transfer Bank</strong>
                                            <div class="small text-muted">BCA, Mandiri, BNI, BRI</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="payment-method-option" data-method="e_wallet">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('assets/icons/e-wallet.png') }}" alt="E-Wallet">
                                        <div>
                                            <strong>E-Wallet</strong>
                                            <div class="small text-muted">GoPay, OVO, DANA, LinkAja</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="payment-method-option" data-method="retail">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('assets/icons/retail.png') }}" alt="Retail">
                                        <div>
                                            <strong>Minimarket</strong>
                                            <div class="small text-muted">Alfamart, Indomaret</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-check-circle me-2"></i>PESAN SEKARANG
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript"
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

<script>
    // Payment method selection
    document.querySelectorAll('.payment-method-option').forEach(option => {
        option.addEventListener('click', function() {
            // Remove selected class from all options
            document.querySelectorAll('.payment-method-option').forEach(el => {
                el.classList.remove('selected');
            });
            
            // Add selected class to clicked option
            this.classList.add('selected');
            
            // Update hidden input with selected payment method
            document.getElementById('payment-method').value = this.getAttribute('data-method');
        });
    });

    
    // Update harga otomatis saat lapang dipilih
    document.getElementById('field-id').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const price = selectedOption.getAttribute('data-price');

        // Tampilkan versi "Rp xxx.xxx" ke user
        document.getElementById('total-harga-display').value = price ? parseInt(price).toLocaleString('id-ID') : '';

        // Simpan nilai angka murni ke input hidden
        document.getElementById('total-harga').value = price ? parseInt(price) : '';
    });
</script>

<script>
    $(document).ready(function() {
        // Add datepicker minimum date (today)
        var today = new Date().toISOString().split('T')[0];
        document.getElementById('booking-date').setAttribute('min', today);
        
        // Handle form submission
        $('#booking-form').on('submit', function(e) {
            e.preventDefault();
            
            // Validate payment method selection
            if (!$('#payment-method').val()) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Metode Pembayaran',
                    text: 'Silakan pilih metode pembayaran untuk melanjutkan'
                });
                return;
            }
            
            // Show loading spinner
            showLoadingOverlay('Memproses booking Anda...');
            
            // Submit form via AJAX
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Option 1: Redirect to payment process page
                        window.location.href = "{{ route('admin.bookings.process', '') }}/" + response.booking_id;
                        
                        // OR Option 2: Show Modal (uncomment if you prefer modal instead of redirect)
                        // showPaymentModal(response.booking_id);
                    } else {
                        hideLoadingOverlay();
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            text: 'Terjadi kesalahan! Silakan coba lagi.'
                        });
                    }
                },
                error: function(xhr) {
                    hideLoadingOverlay();
                    
                    // Show validation errors if any
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = '';
                        
                        for (let field in errors) {
                            errorMessage += errors[field][0] + '<br>';
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Validasi Gagal',
                            html: errorMessage
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'System Error',
                            text: 'Terjadi kesalahan sistem! Silakan coba lagi nanti.'
                        });
                    }
                }
            });
        });
        
        // Optional: if you want to use modal instead of redirect
        function showPaymentModal(bookingId) {
            // Create and show modal
            let modal = `
                <div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><i class="fas fa-money-check-alt me-2"></i>Proses Pembayaran</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <div class="spinner-border text-primary mb-3" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <h4>Mempersiapkan Gateway Pembayaran</h4>
                                <p>Mohon tunggu sebentar...</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            $('body').append(modal);
            let paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
            paymentModal.show();
            
            // Load payment data
            $.ajax({
                url: "{{ route('admin.bookings.get-payment-token', '') }}/" + bookingId,
                method: 'GET',
                success: function(response) {
                    if (response.snap_token) {
                        // Hide spinner
                        $('.modal-body .spinner-border').hide();
                        $('.modal-body h4').text('Lanjutkan ke Pembayaran');
                        $('.modal-body p').text('Klik tombol di bawah untuk melanjutkan ke pembayaran');
                        
                        // Add pay button
                        $('.modal-body').append('<button id="modal-pay-button" class="btn btn-primary mt-3">Bayar Sekarang</button>');
                        
                        // Open Snap when button clicked
                        $('#modal-pay-button').on('click', function() {
                            snap.pay(response.snap_token, {
                                onSuccess: function(result) {
                                    window.location.href = '{{ route("booking.finish", "") }}/' + bookingId;
                                },
                                onPending: function(result) {
                                    window.location.href = '{{ route("booking.pending", "") }}/' + bookingId;
                                },
                                onError: function(result) {
                                    window.location.href = '{{ route("booking.error", "") }}/' + bookingId;
                                },
                                onClose: function() {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Pembayaran Dibatalkan',
                                        text: 'Anda menutup popup pembayaran tanpa menyelesaikan transaksi!'
                                    });
                                }
                            });
                        });
                    } else {
                        $('.modal-body').html('<div class="alert alert-danger">Gagal memuat token pembayaran. Silakan coba lagi.</div>');
                    }
                },
                error: function() {
                    $('.modal-body').html('<div class="alert alert-danger">Terjadi kesalahan! Silakan coba lagi.</div>');
                }
            });
        }
        
        // Helper functions for loading overlay
        function showLoadingOverlay(message) {
            let overlay = `
                <div id="loading-overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 9999; display: flex; justify-content: center; align-items: center;">
                    <div class="bg-white p-4 rounded text-center">
                        <div class="spinner-border text-primary mb-3" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <div>${message || 'Loading...'}</div>
                    </div>
                </div>
            `;
            $('body').append(overlay);
        }
        
        function hideLoadingOverlay() {
            $('#loading-overlay').remove();
        }
    });
</script>
@endpush