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

            <!-- card-header + button dalam 1 baris -->
              <div class="card-header d-flex justify-content-between align-items-center">
              <a href="{{ route('admin.fields.create') }}" class="btn btn-primary btn-sm rounded shadow-sm">
                  <i class="fas fa-plus"></i> Tambah Lapang
              </a>
            </div>

            <div class="card-body">
              <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                  <tr>
                    <th>#</th>
                    <th>Nama Lapangan</th>
                    <th>Harga Perjam</th>
                    <th>Gambar</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($fields as $data)
                  <tr>
                    <td>{{ $fields->firstItem() + $loop->index }}</td>
                    <td>{{ $data->nama ?? 'User tidak ditemukan' }}</td>
                    <td>{{ $data->harga_perjam ?? 'Lapangan tidak ditemukan' }}</td>
                    <td><img src="{{ asset('uploads/fields/' . $data->gambar) }}" alt="" width="100"></td>
                    <td>{{ $data->deskripsi ?? 'Lapangan tidak ditemukan' }}</td>
                    <td>
                      <a href="{{ route('admin.fields.edit', $data->id) }}" class="btn btn-sm btn-warning">
                        <i class="fa fa-edit"></i> Edit
                      </a>
                      <form action="{{ route('admin.fields.destroy', $data->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">
                          <i class="fa fa-trash"></i> Hapus
                        </button>
                      </form>
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="6" class="text-center">Tidak ada data.</td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <div class="card-footer clearfix">
              {{ $fields->links() }}
            </div>

          </div>
      </div>
    </div>
  </div>
</div>
@endsection
