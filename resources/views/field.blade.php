@extends('layouts.app')

@push('style')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    .payment-method-option {
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        cursor: pointer;
    }
    .payment-method-option.selected {
        border-color: #0d6efd;
        background-color: #f0f7ff;
    }
    .payment-method-option img {
        height: 30px;
        margin-right: 10px;
    }
</style>
@endpush

@section('content')
<section id="stats" class="stats section light-background">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
            <div class="col-lg-8">
                <section>
                    <div class="container">
                        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></button>
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></button>
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></button>
                            </div>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="{{ asset('assets/img/lapang.jpg') }}" class="d-block w-100" alt="Slide 1">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>Bumi Sariwangi</h5>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('assets/img/lapang.jpg') }}" class="d-block w-100" alt="Slide 2">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>Bumi Sariwangi</h5>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('assets/img/lapang.jpg') }}" class="d-block w-100" alt="Slide 3">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>Bumi Sariwangi</h5>
                                    </div>
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        </div>
                    </div>
                </section>
            </div>

            <div class="col-lg-4">
                <section>
                    <div class="container">
                        <div class="card">
                            <div class="card-header text-center fs-5 text-uppercase">
                                <b>JADWAL LAPANGAN BUMI SARIWANGI</b>
                            </div>
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <strong>Oops! Ada kesalahan saat mengisi form:</strong>
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
                                        <label for="booking-date" class="form-label">Tanggal Booking</label>
                                        <input type="date" class="form-control" id="booking-date" name="tanggal_pemesanan" required>
                                    </div>
                                
                                    <div class="mb-3">
                                        <label for="field-id" class="form-label">Lapang</label>
                                        <select id="field-id" class="form-control" name="field_id" required>">
                                            <option value="">Pilih Lapang</option>
                                            @foreach ($fields as $data)
                                                <option value="{{ $data->id }}" data-price="{{ $data->harga_perjam }}">{{ $data->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                
                                    <div class="mb-3">
                                        <label for="schedule-id" class="form-label">Jam</label>
                                        <select id="schedule-id" class="form-control" name="schedule_id" required>
                                            <option value="">Pilih Jam</option>
                                            @foreach ($schedules as $data)
                                                <option value="{{ $data->id }}">{{ $data->start_time }} - {{ $data->end_time }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                
                                    <div class="mb-3">
                                        <label for="total-harga" class="form-label">Harga</label>
                                        <input type="text" id="total-harga-display" class="form-control" readonly>
                                        <input type="hidden" id="total-harga" name="total_harga">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Metode Pembayaran</label>
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
                                    
                                    <button type="submit" class="btn btn-primary w-100">BOOK NOW</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
        document.getElementById('total-harga-display').value = price ? 'Rp ' + parseInt(price).toLocaleString() : '';

        // Simpan nilai angka murni ke input hidden
        document.getElementById('total-harga').value = price ? parseInt(price) : '';
    });
</script>

<script>
    $(document).ready(function() {
        // Handle form submission
        $('#booking-form').on('submit', function(e) {
            e.preventDefault();
            
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
                        alert('Terjadi kesalahan! Silakan coba lagi.');
                    }
                },
                error: function(xhr) {
                    hideLoadingOverlay();
                    
                    // Show validation errors if any
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = 'Terjadi kesalahan:\n';
                        
                        for (let field in errors) {
                            errorMessage += errors[field][0] + '\n';
                        }
                        
                        alert(errorMessage);
                    } else {
                        alert('Terjadi kesalahan sistem! Silakan coba lagi nanti.');
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
                                <h5 class="modal-title">Proses Pembayaran</h5>
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
                                    alert('Anda menutup popup pembayaran tanpa menyelesaikan transaksi!');
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