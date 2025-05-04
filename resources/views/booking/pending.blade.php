{{-- resources/views/booking/pending.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning text-dark">Pembayaran Tertunda</div>

                <div class="card-body">
                    <div class="alert alert-warning">
                        <h4>Pembayaran Anda sedang diproses!</h4>
                        <p>Silakan selesaikan pembayaran sesuai instruksi yang diberikan. Status booking akan diperbarui secara otomatis setelah pembayaran berhasil.</p>
                    </div>

                    @if($booking->payments && $booking->payments->va_numbers)
                        <div class="alert alert-info">
                            <h5>Informasi Pembayaran:</h5>
                            @php
                                $vaNumbers = json_decode($booking->payments->va_numbers, true);
                            @endphp
                            @if(is_array($vaNumbers) && count($vaNumbers) > 0)
                                @foreach($vaNumbers as $va)
                                    <p><strong>Bank:</strong> {{ strtoupper($va['bank'] ?? '') }}</p>
                                    <p><strong>Nomor VA:</strong> {{ $va['va_number'] ?? '' }}</p>
                                @endforeach
                            @endif
                        </div>
                    @endif

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
                                <span class="badge bg-warning text-dark">Menunggu Pembayaran</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Total Harga</th>
                            <td>Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                        </tr>
                    </table>

                    @if($booking->payments && $booking->payments->pdf_url)
                        <div class="text-center mt-3 mb-3">
                            <a href="{{ $booking->payments->pdf_url }}" target="_blank" class="btn btn-info">Lihat Instruksi Pembayaran</a>
                        </div>
                    @endif

                    <div class="text-center mt-4">
                        <a href="{{ route('home') }}" class="btn btn-primary">Kembali ke Beranda</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection