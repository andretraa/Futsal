@extends('admin.layouts.app')
@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid mt-3">
    <h1 class="mb-4">Dashboard Admin</h1>

    {{-- Statistik Booking --}}
    <div class="row">
        <!-- Laporan Booking Berdasarkan Filter -->
        <div class="col-md-6 mb-4">
            <div class="card border-info shadow-sm">
                <div class="card-header bg-info text-white d-flex align-items-center gap-2">
                    <i class="fas fa-calendar-day me-1"></i> Laporan Booking ({{ $dateFormatted ?? 'Hari Ini' }})
                </div>
                <div class="card-body">
                    <h5><i class="fas fa-receipt me-2"></i>Total Booking:</h5>
                    <p>
                        <span class="badge bg-primary fs-5">
                            {{ $filteredBookings ?? $todayBookings ?? 0 }}
                        </span>
                    </p>
                    <h5><i class="fas fa-money-bill-wave me-2"></i>Total Pemasukan:</h5>
                    <p>
                        <span class="badge bg-success fs-5">
                            Rp {{ number_format($filteredIncome ?? $todayIncome ?? 0, 0, ',', '.') }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Laporan Booking Keseluruhan -->
        <div class="col-md-6 mb-4">
            <div class="card border-success shadow-sm">
                <div class="card-header bg-success text-white d-flex align-items-center gap-2">
                    <i class="fas fa-chart-line me-1"></i> Laporan Booking Keseluruhan
                </div>
                <div class="card-body">
                    <h5><i class="fas fa-receipt me-2"></i>Total Booking:</h5>
                    <p>
                        <span class="badge bg-info fs-5">
                            {{ $allBookings ?? 0 }}
                        </span>
                    </p>
                    <h5><i class="fas fa-money-check-alt me-2"></i>Total Pemasukan:</h5>
                    <p>
                        <span class="badge bg-success fs-5">
                            Rp {{ number_format($allIncome ?? 0, 0, ',', '.') }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Statistik Pengguna -->
        <div class="col-md-6 mb-4">
            <div class="card border-secondary shadow-sm">
                <div class="card-header bg-secondary text-white d-flex align-items-center gap-2">
                    <i class="fas fa-users me-1"></i> Total Pengguna Terdaftar
                </div>
                <div class="card-body">
                    <h5><i class="fas fa-user-check me-2"></i>User Terdaftar:</h5>
                    <p>
                        <span class="badge bg-dark fs-5">{{ $totalUsers ?? 0 }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
