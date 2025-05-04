<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Field;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Midtrans\Snap;
use Midtrans\Config;

class BookingController extends Controller
{
    public function __construct()
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function index()
    {
        $bookings = Booking::with(['user', 'field'])->latest()->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $fields = Field::all();
        $schedules = Schedule::with('field')->where('is_available', true)->get();
        return view('admin.bookings.create', compact('fields', 'schedules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'field_id' => 'required|exists:fields,id',
            'schedule_id' => 'required|exists:schedules,id',
            'tanggal_pemesanan' => 'required|date',
            'total_harga' => 'required',
        ]);

        $schedule = Schedule::findOrFail($request->schedule_id);

        $start_time = Carbon::parse($request->tanggal_pemesanan . ' ' . $schedule->start_time);
        $end_time = Carbon::parse($request->tanggal_pemesanan . ' ' . $schedule->end_time);

        // Buat booking terlebih dahulu dengan status pending
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'field_id' => $request->field_id,
            'tanggal_pemesanan' => $request->tanggal_pemesanan,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'status' => 'pending',
            'total_harga' => $request->total_harga,
        ]);

        // Buat transaksi Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => 'ORDER-' . $booking->id . '-' . time(),
                'gross_amount' => $booking->total_harga,
            ],
            'customer_details' => [
                'first_name' => $booking->user->name ?? 'Guest',
                'email' => $booking->user->email ?? 'guest@example.com',
            ],
            'item_details' => [
                [
                    'id' => $booking->field->id,
                    'price' => $booking->total_harga,
                    'quantity' => 1,
                    'name' => 'Sewa Lapangan ' . $booking->field->nama
                ]
            ]
        ];

        $snapToken = Snap::getSnapToken($params);

        return view('admin.bookings.pay', compact('snapToken', 'booking'));
    }

    public function edit(Booking $booking)
    {
        $fields = Field::all();
        $schedules = Schedule::where('is_available', true)->get();
        return view('admin.bookings.edit', compact('booking', 'fields', 'schedules'));
    }

    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'field_id' => 'required|exists:fields,id',
            'schedule_id' => 'required|exists:schedules,id',
            'tanggal_pemesanan' => 'required|date',
            'status' => 'required|in:pending,confirmed,cancelled',
            'total_harga' => 'required|numeric',
        ]);

        $schedule = Schedule::findOrFail($request->schedule_id);

        $start_time = Carbon::parse($request->tanggal_pemesanan . ' ' . $schedule->start_time);
        $end_time = Carbon::parse($request->tanggal_pemesanan . ' ' . $schedule->end_time);

        $booking->update([
            'field_id' => $request->field_id,
            'tanggal_pemesanan' => $request->tanggal_pemesanan,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'status' => $request->status,
            'total_harga' => $request->total_harga,
        ]);

        return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil diperbarui.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil dihapus.');
    }
}