@extends('admin.layouts.app')
@section('title', 'Tambah Jadwal')

@section('content')
<div class="container-fluid mt-3">
    <div class="card">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        <div class="card-header"><h3 class="card-title">Tambah Jadwal</h3></div>
        <div class="card-body">
            @include('admin.schedules.form', ['action' => route('admin.schedules.store'), 'method' => 'POST', 'schedule' => null])
        </div>
    </div>
</div>
@endsection
