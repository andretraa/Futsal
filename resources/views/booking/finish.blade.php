{{-- resources/views/booking/finish.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">Pembayaran Berhasil</div>

                <div class="card-body">
                    <div class="alert alert-success">
                        <h4>Terima kasih!</h4>
                        <p>Pembayaran Anda sedang diproses. Anda akan menerima konfirmasi segera setelah pembayaran diverifikasi.</p>
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
                                @if($booking->status == 'pending')
                                    <span class="badge bg-warning">Menunggu Pembayaran</span>
                                @elseif($booking->status == 'confirmed')
                                    <span class="badge bg-success">Terkonfirmasi</span>
                                @else
                                    <span class="badge bg-danger">{{ ucfirst($booking->status) }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Total Harga</th>
                            <td>Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                        </tr>
                    </table>

                    <div class="text-center mt-4">
                        <a href="{{ route('home') }}" class="btn btn-primary">Kembali ke Beranda</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection