@extends('admin.layouts.app')
@section('title', 'Tambah Booking')

@section('content')
<div class="container-fluid mt-3">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tambah Booking</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.bookings.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="field_id">Pilih Lapangan</label>
                    <select name="field_id" class="form-control" required>
                        <option value="">-- Pilih Lapangan --</option>
                        @foreach($fields as $field)
                            <option value="{{ $field->id }}">{{ $field->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="schedule_id">Pilih Jadwal</label>
                    <select name="schedule_id" class="form-control" required>
                        <option value="">-- Pilih Jadwal --</option>
                        @foreach($schedules as $schedule)
                            <option value="{{ $schedule->id }}">
                                {{ $schedule->field->nama }} - {{ ucfirst($schedule->day_of_week) }} ({{ $schedule->start_time }} - {{ $schedule->end_time }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="tanggal_pemesanan">Tanggal Pemesanan</label>
                    <input type="date" name="tanggal_pemesanan" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="total_harga">Total Harga</label>
                    <input type="number" name="total_harga" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
