@extends('admin.layouts.app')

@section('content')
<!-- Header -->
<div class="app-content-header py-3 mb-4 border-bottom">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="mb-0"><i class="bi bi-people me-2"></i>Manajemen User</h3>
            <!-- Optional: Tombol Tambah User -->
        </div>
    </div>
</div>

<!-- Content -->
<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-table me-2"></i>Data User</h5>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%;">No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th style="width: 15%;">Role</th>
                                        <th style="width: 10%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td>{{ $data->email }}</td>
                                        <td>
                                            <span class="badge 
                                                @if($data->role == 'admin') bg-success
                                                @elseif($data->role == 'user') bg-secondary
                                                @else bg-warning
                                                @endif">
                                                {{ ucfirst($data->role) }}
                                            </span>
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.users.destroy', $data->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="card-footer bg-white d-flex justify-content-end">
                        {{-- Pagination jika diperlukan --}}
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
