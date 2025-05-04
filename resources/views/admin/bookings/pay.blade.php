@extends('admin.layouts.app')
@section('title', 'Pembayaran Booking')

@section('content')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

<div class="container mt-5">
    <h4>Bayar Booking</h4>
    <p>Total: <strong>Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</strong></p>
    <button id="pay-button" class="btn btn-success">Bayar Sekarang</button>
</div>

<script type="text/javascript">
    document.getElementById('pay-button').onclick = function () {
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                window.location.href = "{{ route('admin.bookings.index') }}";
            },
            onPending: function(result) {
                alert("Silakan selesaikan pembayaran!");
            },
            onError: function(result) {
                alert("Terjadi kesalahan");
            }
        });
    };
</script>
@endsection