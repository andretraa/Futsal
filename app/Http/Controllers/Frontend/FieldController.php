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

        // Ambil semua booking yang sudah ada untuk field dan tanggal ini
        $existingBookings = Booking::where('field_id', $fieldId)
                                ->where('tanggal_pemesanan', $bookingDate)
                                ->whereIn('status', ['pending', 'paid', 'confirmed']) // tambahkan status lain jika perlu
                                ->get(['start_time', 'end_time']); // ambil kolom start_time dan end_time

        \Log::info('Existing bookings found: ' . $existingBookings->count());
        foreach ($existingBookings as $booking) {
            \Log::info('Booking: start=' . $booking->start_time . ', end=' . $booking->end_time);
        }

        $schedulesWithBookingStatus = [];
        $currentDateTime = Carbon::now(config('app.timezone'));
        
        foreach ($allDefinedSchedules as $schedule) {
            $isBooked = false;

            // Clean the time strings and handle different formats
            $startTime = trim($schedule->start_time);
            $endTime = trim($schedule->end_time);
            
            \Log::info('Processing schedule: start_time=' . $startTime . ', end_time=' . $endTime);

            try {
                // Parse waktu schedule
                $scheduleStartDateTime = Carbon::parse(
                    $bookingDate . ' ' . $startTime,
                    config('app.timezone')
                );
                $scheduleEndDateTime = Carbon::parse(
                    $bookingDate . ' ' . $endTime,
                    config('app.timezone')
                );

                // Cek apakah jadwal sudah lewat (untuk hari ini)
                if ($scheduleStartDateTime->isSameDay($currentDateTime) && $scheduleStartDateTime->lt($currentDateTime)) {
                    $isBooked = true;
                } else {
                    // Cek apakah ada konflik dengan booking yang sudah ada
                    foreach ($existingBookings as $booking) {
                        try {
                            $bookingStart = Carbon::parse($bookingDate . ' ' . $booking->start_time, config('app.timezone'));
                            $bookingEnd = Carbon::parse($bookingDate . ' ' . $booking->end_time, config('app.timezone'));

                            // Cek overlap/konflik waktu
                            // Ada konflik jika:
                            // 1. Schedule start berada di antara booking start dan end
                            // 2. Schedule end berada di antara booking start dan end  
                            // 3. Schedule mencakup seluruh booking
                            // 4. Booking mencakup seluruh schedule
                            if (
                                ($scheduleStartDateTime->gte($bookingStart) && $scheduleStartDateTime->lt($bookingEnd)) ||
                                ($scheduleEndDateTime->gt($bookingStart) && $scheduleEndDateTime->lte($bookingEnd)) ||
                                ($scheduleStartDateTime->lte($bookingStart) && $scheduleEndDateTime->gte($bookingEnd)) ||
                                ($bookingStart->lte($scheduleStartDateTime) && $bookingEnd->gte($scheduleEndDateTime))
                            ) {
                                $isBooked = true;
                                \Log::info('Schedule conflict found: schedule(' . $startTime . '-' . $endTime . ') overlaps with booking(' . $booking->start_time . '-' . $booking->end_time . ')');
                                break; // keluar dari loop jika sudah menemukan konflik
                            }
                        } catch (\Exception $e) {
                            \Log::error('Error parsing booking time: ' . $e->getMessage());
                        }
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
