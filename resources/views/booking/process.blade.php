<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proses Pembayaran</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .payment-card {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: none;
            overflow: hidden;
        }
        .card-header {
            background: linear-gradient(to right, #0d6efd, #0dcaf0);
            color: white;
            font-weight: 600;
            font-size: 18px;
            padding: 15px;
            border-bottom: none;
        }
        .spinner-container {
            padding: 30px 0;
        }
        .spinner-border {
            width: 3rem;
            height: 3rem;
        }
        .booking-details {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
        }
        .table td {
            padding: 10px;
            vertical-align: middle;
        }
        .btn-primary {
            background: linear-gradient(to right, #0d6efd, #0b5ed7);
            border: none;
            padding: 10px 25px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(13, 110, 253, 0.4);
        }
        .logo-container {
            margin-bottom: 20px;
        }
        .logo {
            max-height: 60px;
        }
        .timer-container {
            color: #6c757d;
            font-size: 14px;
            margin-top: 10px;
        }
        .security-badge {
            margin-top: 20px;
            color: #6c757d;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <!-- Logo -->
               <div class="logo-container d-flex justify-content-center align-items-center" style="height: 60px;">
                <i class="fas fa-futbol fa-2x text-primary me-2"></i>
                <span class="fw-bold fs-5">Bumi Sariwangi</span>
                </div>              
                <div class="card payment-card">
                    <div class="card-header text-center">
                        <i class="fas fa-credit-card me-2"></i> Proses Pembayaran
                    </div>
                    
                    <div class="card-body">
                        <div class="text-center spinner-container">
                            <div class="spinner-border text-primary mb-3" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <h4 class="mb-2">Memproses Pembayaran Anda</h4>
                            <p class="text-muted">Mohon tunggu sebentar, Anda akan diarahkan ke halaman pembayaran...</p>
                            
                            <div class="timer-container">
                                <i class="fas fa-clock me-1"></i> Dialihkan dalam <span id="countdown">5</span> detik
                            </div>
                        </div>
                        
                        <div class="booking-details mt-4">
                            <h5 class="mb-3">
                                <i class="fas fa-receipt me-2"></i>
                                Detail Booking
                            </h5>
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td width="40%"><i class="fas fa-futbol me-2"></i> Lapangan</td>
                                        <td>: <strong>{{ $booking->field->nama }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-calendar-alt me-2"></i> Tanggal</td>
                                        <td>: <strong>{{ \Carbon\Carbon::parse($booking->tanggal_pemesanan)->format('d-m-Y') }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-clock me-2"></i> Waktu</td>
                                        <td>: <strong>{{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</strong></td>
                                    </tr>
                                    <tr class="table-primary">
                                        <td><i class="fas fa-tag me-2"></i> Total</td>
                                        <td>: <strong>Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="text-center mt-4">
                            <button id="pay-button" class="btn btn-primary btn-lg">
                                <i class="fas fa-wallet me-2"></i> Lanjutkan ke Pembayaran
                            </button>
                        </div>
                        
                        <div class="security-badge text-center">
                            <i class="fas fa-lock me-1"></i> Pembayaran aman menggunakan Midtrans Payment Gateway
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <a href="{{ route('fields.index') }}" class="text-decoration-none text-muted">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script>
        $(document).ready(function() {
            // Countdown timer
            let seconds = 5;
            const countdownEl = document.getElementById('countdown');
            
            const countdownTimer = setInterval(function() {
                seconds--;
                countdownEl.textContent = seconds;
                
                if (seconds <= 0) {
                    clearInterval(countdownTimer);
                    openSnap();
                }
            }, 1000);
            
            // Or user can click button to open
            $('#pay-button').on('click', function() {
                clearInterval(countdownTimer);
                openSnap();
            });
            
            function openSnap() {
                snap.pay('{{ $snapToken }}', {
                    onSuccess: function(result) {
                        window.location.href = '{{ route("booking.finish", $booking->id) }}';
                    },
                    onPending: function(result) {
                        window.location.href = '{{ route("booking.pending", $booking->id) }}';
                    },
                    onError: function(result) {
                        window.location.href = '{{ route("booking.error", $booking->id) }}';
                    },
                    onClose: function() {
                        Swal.fire({
                            title: 'Pembayaran Dibatalkan',
                            text: 'Anda menutup popup pembayaran tanpa menyelesaikan transaksi!',
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    </script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>