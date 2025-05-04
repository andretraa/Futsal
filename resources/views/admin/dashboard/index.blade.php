@extends('admin.layouts.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Data Booking Lapangan</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Booking</li>
          </ol>
        </div>
      </div>
    </div>
</div>

<div class="app-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card mb-4">
            <div class="card-header"><h3 class="card-title">Data Booking Lapangan</h3></div>
            <div class="card-body">
              <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                  <tr>
                    <th>#</th>
                    <th>Nama User</th>
                    <th>Nama Lapangan</th>
                    <th>Waktu Mulai</th>
                    <th>Waktu Selesai</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($bookings as $booking)
  <tr>
    <td>{{ $bookings->firstItem() + $loop->index }}</td>
    <td>{{ $booking->user->name ?? 'User tidak ditemukan' }}</td>
    <td>{{ $booking->field->name ?? 'Lapangan tidak ditemukan' }}</td>
    <td>{{ \Carbon\Carbon::parse($booking->booking_start)->format('d-m-Y H:i') }}</td>
    <td>{{ \Carbon\Carbon::parse($booking->booking_end)->format('d-m-Y H:i') }}</td>
    <td>
      <span @class([
        'badge',
        'bg-success' => $booking->status === 'confirmed',
        'bg-warning' => $booking->status === 'pending',
        'bg-danger' => !in_array($booking->status, ['confirmed', 'pending']),
      ])>
        {{ ucfirst($booking->status) }}
      </span>
    </td>
  </tr>
@empty
  <tr>
    <td colspan="6" class="text-center">Tidak ada data booking.</td>
  </tr>
@endforelse

                </tbody>
              </table>
            </div>
            <div class="card-footer clearfix">
              {{ $bookings->links() }}
            </div>
          </div>
      </div>
    </div>
  </div>
</div>
@endsection