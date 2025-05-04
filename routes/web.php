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

Route::post('/get-snap-token', [BookingController::class, 'getSnapToken'])->name('get.snap.token');

// Direct booking payment callbacks
Route::get('/booking/{id}/finish', [BookingController::class, 'finishPayment'])->name('booking.finish');
Route::get('/booking/{id}/error', [BookingController::class, 'errorPayment'])->name('booking.error');
Route::get('/booking/{id}/pending', [BookingController::class, 'pendingPayment'])->name('booking.pending');

// AJAX payment callbacks
Route::get('/booking/finish/ajax', [BookingController::class, 'finishPaymentAjax'])->name('booking.finish.ajax');
Route::get('/booking/error/ajax', [BookingController::class, 'errorPaymentAjax'])->name('booking.error.ajax');
Route::get('/booking/pending/ajax', [BookingController::class, 'pendingPaymentAjax'])->name('booking.pending.ajax');

Route::prefix('admin')->name('admin.')->group(function () {

Route::resource('fields', FieldController::class);   

Route::resource('schedules', ScheduleController::class);

Route::resource('bookings', BookingController::class);
// Di routes/web.php

});
