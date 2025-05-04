<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user', 'field'])->paginate(10);
        return view('admin.booking.index', compact('bookings'));
    }
}
