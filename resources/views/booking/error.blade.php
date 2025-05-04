{{-- resources/views/booking/error.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-danger text-white">Pembayaran Gagal</div>

                <div class="card-body">
                    <div class="alert alert-danger">
                        <h4>Oops! Terjadi kesalahan dalam proses pembayaran.</h4>
                        <p>Silakan coba lagi atau hubungi kami jika Anda terus mengalami masalah.</p>
                    </div>

                    <h5>Detail Pemesanan:</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th>ID Pemesanan</th>
                            <td>{{ $booking->id }}</td>
                        </tr>
                        <tr>
                            <th>Lapangan</th>
                            <td>{{ $booking->field->nama }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <td>{{ $booking->tanggal_pemesanan }}</td>
                        </tr>
                        <tr>
                            <th>Waktu</th>
                            <td>{{ Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - {{ Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Status Pemesanan</th>
                            <td>
                                <span class="badge bg-danger">Gagal</span>
                            </td>
                        </tr>
                    </table>

                    <div class="text-center mt-4">
                        <a href="{{ route('home') }}" class="btn btn-secondary mr-2">Kembali ke Beranda</a>
                        <a href="{{ route('booking.create') }}" class="btn btn-primary">Coba Lagi</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection