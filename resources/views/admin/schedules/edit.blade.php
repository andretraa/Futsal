@extends('admin.layouts.app')
@section('title', 'Edit Jadwal')

@section('content')
<div class="container-fluid mt-3">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="card">
        <div class="card-header"><h3 class="card-title">Edit Jadwal</h3></div>
        <div class="card-body">
            @include('admin.schedules.form', ['action' => route('admin.schedules.update', $schedule->id), 'method' => 'PUT', 'schedule' => $schedule])
        </div>
    </div>
</div>
@endsection
