@extends('admin.layouts.app') {{-- pastikan ini mengarah ke layout AdminLTE kamu --}}

@section('title', 'Tambah Lapangan')

@section('content')
<div class="container-fluid mt-3">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tambah Lapangan</h3>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.fields.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="nama">Nama Lapangan</label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
                </div>

                <div class="form-group">
                    <label for="harga_perjam">Harga per Jam</label>
                    <input type="number" name="harga_perjam" class="form-control" value="{{ old('harga_perjam') }}" required>
                </div>

                <div class="form-group">
                    <label for="gambar">Gambar</label>
                    <input type="file" name="gambar" class="form-control-file" required>
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.fields.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
