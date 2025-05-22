<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .success-card {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: none;
            overflow: hidden;
            margin-top: 20px;
        }
        .card-header {
            background: linear-gradient(to right, #10b981, #34d399);
            color: white;
            font-weight: 600;
            font-size: 20px;
            padding: 20px;
            border-bottom: none;
        }
        .success-icon {
            font-size: 60px;
            color: #10b981;
            margin-bottom: 20px;
        }
        .invoice-section {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .status-success {
            background-color: #d1fae5;
            color: #065f46;
        }
        .detail-list {
            list-style-type: none;
            padding-left: 0;
        }
        .detail-list li {
            padding: 10px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .detail-list li:last-child {
            border-bottom: none;
        }
        .btn-back {
            background: linear-gradient(to right, #2563eb, #3b82f6);
            border: none;
            padding: 12px 30px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
            transition: all 0.3s ease;
        }
        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(37, 99, 235, 0.4);
        }
        .receipt-container {
            position: relative;
        }
        .receipt-container::before {
            content: '';
            position: absolute;
            top: -5px;
            left: 20px;
            right: 20px;
            height: 10px;
            background-image: linear-gradient(90deg, #ffffff 0px, #ffffff 12px, transparent 12px), linear-gradient(90deg, #dddddd 0px, #dddddd 12px, transparent 12px);
            background-size: 24px 5px;
            background-repeat: repeat-x;
        }
        .logo-container {
            margin-bottom: 10px;
            text-align: center;
        }
        .logo {
            max-height: 60px;
        }
        .qr-code {
            width: 120px;
            height: 120px;
            border: 1px solid #dee2e6;
            padding: 5px;
            margin: 0 auto;
        }
        .thank-you-section {
            background-color: #f0fdf4;
            border-radius: 10px;
            padding: 15px;
            margin-top: 20px;
            text-align: center;
        }
        .print-button {
            color: #6c757d;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            margin-top: 20px;
        }
        .print-button i {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Logo -->
                <div class="logo-container d-flex justify-content-center align-items-center" style="height: 60px;">
                <i class="fas fa-futbol fa-2x text-primary me-2"></i>
                <span class="fw-bold fs-5">Bumi Sariwangi</span>
                </div>      
                <div class="card success-card">
                    <div class="card-header text-center">
                        <i class="fas fa-check-circle me-2"></i> Pembayaran Berhasil
                    </div>
                    
                    <div class="card-body">
                        <div class="text-center">
                            <div class="success-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <h3 class="mb-4">Terima Kasih! 🎉</h3>
                            <p class="lead">Pembayaran Anda telah berhasil dan booking telah dikonfirmasi.</p>
                        </div>
                        
                        <div class="receipt-container mt-5">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="mb-3">
                                        <i class="fas fa-file-invoice me-2"></i>
                                        Detail Invoice
                                    </h4>
                                    
                                    <div class="invoice-section">
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <small class="text-muted">Kode Booking</small>
                                                <div class="fw-bold">{{ $booking->id }}</div>
                                            </div>
                                            <div class="col-6 text-end">
                                                <small class="text-muted">Status</small>
                                                <div>
                                                    <span class="status-badge status-success">
                                                        <i class="fas fa-check-circle me-1"></i> {{ ucfirst($booking->status) }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <ul class="detail-list">
                                            <li class="row">
                                                <div class="col-5">
                                                    <i class="fas fa-futbol me-2 text-secondary"></i> Lapangan
                                                </div>
                                                <div class="col-7 fw-bold">
                                                    {{ $booking->field->nama ?? '-' }}
                                                </div>
                                            </li>
                                            <li class="row">
                                                <div class="col-5">
                                                    <i class="fas fa-calendar-alt me-2 text-secondary"></i> Tanggal
                                                </div>
                                                <div class="col-7 fw-bold">
                                                    {{ $booking->tanggal_pemesanan }}
                                                </div>
                                            </li>
                                            <li class="row">
                                                <div class="col-5">
                                                    <i class="fas fa-clock me-2 text-secondary"></i> Waktu
                                                </div>
                                                <div class="col-7 fw-bold">
                                                    {{ $booking->start_time }} - {{ $booking->end_time }}
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            
                            </div>
                            
                            <h4 class="mt-4 mb-3">
                                <i class="fas fa-credit-card me-2"></i>
                                Detail Pembayaran
                            </h4>
                            
                            <div class="invoice-section">
                                <ul class="detail-list">
                                    <li class="row">
                                        <div class="col-5">
                                            <i class="fas fa-hashtag me-2 text-secondary"></i> Order ID
                                        </div>
                                        <div class="col-7 fw-bold">
                                            {{ $payment->order_id }}
                                        </div>
                                    </li>
                                    <li class="row">
                                        <div class="col-5">
                                            <i class="fas fa-money-bill-wave me-2 text-secondary"></i> Total
                                        </div>
                                        <div class="col-7 fw-bold">
                                            Rp{{ number_format($payment->gross_amount, 0, ',', '.') }}
                                        </div>
                                    </li>
                                    <li class="row">
                                        <div class="col-5">
                                            <i class="fas fa-info-circle me-2 text-secondary"></i> Status
                                        </div>
                                        <div class="col-7">
                                            <span class="status-badge status-success">
                                                <i class="fas fa-check-circle me-1"></i> {{ ucfirst($payment->transaction_status) }}
                                            </span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            
                            <div class="thank-you-section">
                                <i class="fas fa-heart text-danger me-1"></i>
                                Terima kasih telah melakukan pemesanan. Semoga Anda menikmati pengalaman bermain!
                            </div>
                            
                            <div class="text-center mt-4">
                                <a href="{{ route('fields.index') }}" class="btn btn-back text-white">
                                    <i class="fas fa-arrow-left me-2 text-white"></i> Kembali ke Daftar Lapangan
                                </a>
                                
                                <a href="#" class="print-button d-block">
                                    <i class="fas fa-print"></i> Cetak Invoice
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Print functionality
            $('.print-button').on('click', function(e) {
                e.preventDefault();
                window.print();
            });
        });
    </script>
</body>
</html>