@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Pembayaran') }}</div>

                <div class="card-body">
                    <div class="text-center mb-4">
                        <h4>Detail Pemesanan</h4>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 text-md-right">Lapangan:</div>
                            <div class="col-md-6 text-md-left">{{ $booking->field->nama }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 text-md-right">Tanggal:</div>
                            <div class="col-md-6 text-md-left">{{ \Carbon\Carbon::parse($booking->tanggal_pemesanan)->format('d-m-Y') }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 text-md-right">Waktu:</div>
                            <div class="col-md-6 text-md-left">
                                {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - 
                                {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 text-md-right">Total Harga:</div>
                            <div class="col-md-6 text-md-left">Rp{{ number_format($booking->total_harga, 0, ',', '.') }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 text-md-right">Metode Pembayaran:</div>
                            <div class="col-md-6 text-md-left">
                                @switch($booking->payment_method)
                                    @case('credit_card')
                                        Kartu Kredit
                                        @break
                                    @case('bank_transfer')
                                        Virtual Account Bank
                                        @break
                                    @case('e_wallet')
                                        E-Wallet (Gopay, ShopeePay, QRIS)
                                        @break
                                    @case('retail')
                                        Gerai Retail (Alfamart, Indomaret)
                                        @break
                                    @default
                                        {{ $booking->payment_method }}
                                @endswitch
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button id="pay-button" class="btn btn-primary">Bayar Sekarang</button>
                        <a href="{{ route('booking.create') }}" class="btn btn-secondary ml-2">Batal</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Load Midtrans Snap.js -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const payButton = document.getElementById('pay-button');
        
        payButton.addEventListener('click', function() {
            // Show Snap payment page
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    /* Handle success payment, redirect to success page */
                    window.location.href = '{{ route("booking.finish", $booking->id) }}';
                },
                onPending: function(result) {
                    /* Handle pending payment, redirect to pending page */
                    window.location.href = '{{ route("booking.pending", $booking->id) }}';
                },
                onError: function(result) {
                    /* Handle error payment, redirect to error page */
                    window.location.href = '{{ route("booking.error", $booking->id) }}';
                },
                onClose: function() {
                    /* Customer closed the popup without finishing payment */
                    alert('Anda menutup jendela pembayaran sebelum menyelesaikan transaksi');
                }
            });
        });
    });
</script>
@endsection