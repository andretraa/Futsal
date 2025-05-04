@extends('admin.layouts.app')
@section('title', 'Jadwal Lapangan')

@section('content')
<div class="container-fluid mt-3">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Jadwal</h3>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="mb-3 text-right">
                <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary rounded shadow-sm">
                    <i class="fas fa-plus"></i>Tambah Jadwal
                </a>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Lapangan</th>
                        <th>Hari</th>
                        <th>Jam Mulai</th>
                        <th>Jam Selesai</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($schedules as $schedule)
                        <tr>
                            <td>{{ $schedule->field->nama }}</td>
                            <td>{{ $schedule->day_of_week }}</td>
                            <td>{{ $schedule->start_time }}</td>
                            <td>{{ $schedule->end_time }}</td>
                            <td>{{ $schedule->is_available ? 'Tersedia' : 'Tidak Tersedia' }}</td>
                            <td>
                                <a href="{{ route('admin.schedules.edit', $schedule->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus jadwal ini?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @if($schedules->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center">Belum ada jadwal</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
