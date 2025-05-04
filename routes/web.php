<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\ScheduleController;


Route::get('/', function () {
    return view('home');

});

Route::get('/about', function () {
    return view('about');
    
});

Route::get('/field', [App\Http\Controllers\Frontend\FieldController::class, 'index']);

Route::get('/fasilitas', function () {
    return view('fasilitas');
    
});
Route::get('/users', function () {
    return view('admin.users.index');
});

Route::get('/dashboard', function () {
    return view('admin.dashboard.index');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::post('/get-snap-token', [PaymentController::class, 'getSnapToken']);

Route::prefix('admin')->name('admin.')->group(function () {

Route::resource('fields', FieldController::class);   

Route::resource('schedules', ScheduleController::class);

Route::resource('bookings', BookingController::class);

});
