<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Field;
use App\Models\Schedule;
use App\Models\Booking;

class FieldController extends Controller
{
    public function index() {
        $fields = Field::all();
        $schedules = Schedule::all();
        $bookings = Booking::all();
        return view('field', compact('fields', 'schedules', 'bookings'));
    }

    
}
