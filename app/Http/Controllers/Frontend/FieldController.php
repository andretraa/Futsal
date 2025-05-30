<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Field;
use App\Models\Schedule;
use App\Models\Booking;
use Carbon\Carbon;

class FieldController extends Controller
{
    public function index() {
        $fields = Field::all();
        $schedules = Schedule::all();
        $bookings = Booking::all();
        return view('field', compact('fields', 'schedules', 'bookings'));
    }

    public function checkAvailability(Request $request)
    {
         $request->validate([
            'field_id' => 'required|exists:fields,id',
            'booking_date' => 'required|date_format:Y-m-d',
        ]);

        $fieldId = $request->input('field_id');
        $bookingDate = $request->input('booking_date');

        Carbon::setLocale('id');
        $dayOfWeek = Carbon::parse($bookingDate)->dayName;

        \Log::info('checkAvailability called: field_id=' . $fieldId . ', booking_date=' . $bookingDate . ', dayOfWeek=' . $dayOfWeek);

        $allDefinedSchedules = Schedule::where('field_id', $fieldId)
                                    ->where('day_of_week', $dayOfWeek)
                                    ->where('is_available', true)
                                    ->orderBy('start_time')
                                    ->get();

        if ($allDefinedSchedules->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada jadwal yang diatur untuk lapangan ini pada tanggal tersebut.'
            ]);
        }

        $schedulesWithBookingStatus = [];
        $currentDateTime = Carbon::now(config('app.timezone')); 

        foreach ($allDefinedSchedules as $schedule) {
            $isBooked = false;

            // Clean the time strings and handle different formats
            $startTime = trim($schedule->start_time);
            $endTime = trim($schedule->end_time);
            
            // Add debug logging
            \Log::info('Processing schedule: start_time=' . $startTime . ', end_time=' . $endTime);

            try {
                // Use Carbon::parse() which is more flexible with time formats
                $scheduleStartDateTime = Carbon::parse(
                    $bookingDate . ' ' . $startTime,
                    config('app.timezone')
                );
                $scheduleEndDateTime = Carbon::parse(
                    $bookingDate . ' ' . $endTime,
                    config('app.timezone')
                );

                // Check if the schedule time has passed (for same day bookings)
                if ($scheduleStartDateTime->isSameDay($currentDateTime) && $scheduleStartDateTime->lt($currentDateTime)) {
                    $isBooked = true; 
                } else {
                    $existingBooking = Booking::where('field_id', $fieldId)
                                            ->where('tanggal_pemesanan', $bookingDate) 
                                            ->whereIn('status', ['pending', 'paid']) 
                                            ->exists();

                    if ($existingBooking) {
                        $isBooked = true;
                    }
                }

            } catch (\Carbon\Exceptions\InvalidFormatException $e) {
                \Log::error('Carbon parsing error: ' . $e->getMessage() . ' for start_time: ' . $startTime . ', end_time: ' . $endTime);
                // Skip this schedule or mark as unavailable
                $isBooked = true;
            }

            $schedulesWithBookingStatus[] = [
                'id' => $schedule->id,
                'start_time' => $schedule->start_time, 
                'end_time' => $schedule->end_time,
                'is_booked' => $isBooked,
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Jadwal berhasil dimuat.',
            'availableSchedules' => $schedulesWithBookingStatus
        ]);
    }

    
}
