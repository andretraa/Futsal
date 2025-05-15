@extends('admin.layouts.app')
@section('title', 'Daftar Booking')

@section('content')
<div class="container-fluid mt-3">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title mb-0">Daftar Booking</h3>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="mb-3 text-right">
                <a href="{{ route('admin.bookings.create') }}" class="btn btn-primary rounded shadow-sm">
                    <i class="fas fa-plus"></i> Tambah Booking
                </a>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Pengguna</th>
                        <th>Lapangan</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Status</th>
                        <th>Total Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookings as $booking)
                        <tr>
                            <td>{{ $booking->user->name ?? '-' }}</td>
                            <td>{{ $booking->field->nama ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($booking->tanggal_pemesanan)->translatedFormat('d F Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</td>
                            <td>
                                @php
                                    $status = ucfirst($booking->status);
                                    $styles = [
                                        'Pending' => 'background-color: #fef9c3; color: #92400e;',   // kuning muda
                                        'Confirmed' => 'background-color: #bbf7d0; color: #166534;', // hijau muda
                                        'Failed' => 'background-color: #fecaca; color: #991b1b;', // merah muda
                                    ];
                                    $style = $styles[$status] ?? 'background-color: #e5e7eb; color: #374151;'; // abu
                                @endphp

                                <span style="padding: 4px 8px; font-size: 0.875rem; font-weight: 500; border-radius: 0.375rem; {{ $style }}">
                                    {{ $status }}
                                </span>
                            </td>

                            <td>Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus booking ini?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data booking.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
