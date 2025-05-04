@extends('admin.layouts.app')
@section('title', 'Edit Booking')

@section('content')
<div class="container-fluid mt-3">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Booking</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="field_id">Pilih Lapangan</label>
                    <select name="field_id" class="form-control" required>
                        @foreach($fields as $field)
                            <option value="{{ $field->id }}" {{ $booking->field_id == $field->id ? 'selected' : '' }}>
                                {{ $field->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="schedule_id">Pilih Jadwal</label>
                    <select name="schedule_id" class="form-control" required>
                        @foreach($schedules as $schedule)
                            <option value="{{ $schedule->id }}"
                                {{ $booking->start_time == $schedule->start_time && $booking->end_time == $schedule->end_time ? 'selected' : '' }}>
                                {{ $schedule->field->nama }} - {{ ucfirst($schedule->day_of_week) }} ({{ $schedule->start_time }} - {{ $schedule->end_time }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="tanggal_pemesanan">Tanggal Pemesanan</label>
                    <input type="date" name="tanggal_pemesanan" class="form-control"
                           value="{{ \Carbon\Carbon::parse($booking->tanggal_pemesanan)->format('Y-m-d') }}" required>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="total_harga">Total Harga</label>
                    <input type="number" name="total_harga" class="form-control"
                           value="{{ $booking->total_harga }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection