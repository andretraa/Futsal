<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Frontend\FieldController as FrontendFieldController;
use App\Http\Controllers\Admin\DashboardController;


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

// Route::get('/dashboard', function () {
//     return view('admin.dashboard.index');
// });

Route::prefix('admin')->middleware(['auth'])->group(function () {
Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/get-snap-token', [BookingController::class, 'getSnapToken'])->name('get.snap.token');

// Direct booking payment callbacks
Route::get('/booking/{id}/finish', [BookingController::class, 'finishPayment'])->name('booking.finish');
Route::get('/booking/{id}/error', [BookingController::class, 'errorPayment'])->name('booking.error');
Route::get('/booking/{id}/pending', [BookingController::class, 'pendingPayment'])->name('booking.pending');

// AJAX payment callbacks
Route::get('/booking/finish/ajax', [BookingController::class, 'finishPaymentAjax'])->name('booking.finish.ajax');
Route::get('/booking/error/ajax', [BookingController::class, 'errorPaymentAjax'])->name('booking.error.ajax');
Route::get('/booking/pending/ajax', [BookingController::class, 'pendingPaymentAjax'])->name('booking.pending.ajax');

Route::resource('users', UserController::class);   
Route::prefix('admin')->name('admin.')->group(function () {

    
    Route::resource('schedules', ScheduleController::class);
    
    
    Route::resource('bookings', BookingController::class);
    // Di routes/web.php
    Route::resource('fields', FieldController::class);   
    
});
Route::resource('fields', FrontendFieldController::class);
Route::get('checkAvailability', [FrontendFieldController::class, 'checkAvailability'])->name('fields.checkAvailability');

Route::get('/admin/bookings/process/{id}', [App\Http\Controllers\BookingController::class, 'processPayment'])
    ->name('admin.bookings.process');

// Get payment token route (modal approach)
Route::get('/admin/bookings/get-payment-token/{id}', [App\Http\Controllers\BookingController::class, 'getPaymentToken'])
    ->name('admin.bookings.get-payment-token');

// Payment callback routes
Route::get('/booking/finish/{id}', [App\Http\Controllers\BookingController::class, 'finishPayment'])
    ->name('booking.finish');
Route::get('/booking/error/{id}', [App\Http\Controllers\BookingController::class, 'errorPayment'])
    ->name('booking.error');
Route::get('/booking/pending/{id}', [App\Http\Controllers\BookingController::class, 'pendingPayment'])
    ->name('booking.pending');

Route::resource('schedules', ScheduleController::class);
Route::get('schedules/check-availability', [ScheduleController::class, 'checkAvailability'])->name('schedules.checkAvailability');