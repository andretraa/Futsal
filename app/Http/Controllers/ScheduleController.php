<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Field;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with('field')->latest()->get();
        return view('admin.schedules.index', compact('schedules'));
    }

    public function create()
    {
        $fields = Field::all();
        return view('admin.schedules.create', compact('fields'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'field_id' => 'required|exists:fields,id',
            'day_of_week' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'is_available' => 'required|boolean',
        ]);

        Schedule::create($request->all());

        return redirect()->route('admin.schedules.index')->with('success', 'Schedule created successfully.');
    }

    public function show(Schedule $schedule)
    {
        return view('admin.schedules.show', compact('schedule'));
    }

    public function edit(Schedule $schedule)
    {
        $fields = Field::all();
        return view('admin.schedules.edit', compact('schedule', 'fields'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'field_id' => 'required|exists:fields,id',
            'day_of_week' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'is_available' => 'required|boolean',
        ]);

        $schedule->update($request->all());

        return redirect()->route('admin.schedules.index')->with('success', 'Schedule updated successfully.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('admin.schedules.index')->with('success', 'Schedule deleted successfully.');
    }

    public function checkAvailability(Request $request)
{
    $fieldId = $request->input('field_id');
    $bookingDate = $request->input('booking_date');

    // Lakukan pengecekan jadwal di database
    // Misalnya:
    $availableTimes = Schedule::where('field_id', $fieldId)
                              ->whereDate('booking_date', $bookingDate)
                              ->get();

    return response()->json($availableTimes);
}
}