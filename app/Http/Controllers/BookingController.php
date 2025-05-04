<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Field;
use App\Models\Schedule;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
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
        $bookings = Booking::with(['user', 'field', 'payments'])->latest()->get();
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
            'payment_method' => 'required|in:credit_card,bank_transfer,e_wallet,retail',
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
            'payment_method' => $request->payment_method,
        ]);

        // Generate order ID yang unik
        $orderId = 'ORDER-' . $booking->id . '-' . time();

        // Set enabled payment methods based on selection
        $enabledPayments = $this->getEnabledPaymentMethods($request->payment_method);

        // Buat transaksi Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int)$booking->total_harga,
            ],
            'customer_details' => [
                'first_name' => $booking->user->name ?? 'Guest',
                'email' => $booking->user->email ?? 'guest@example.com',
            ],
            'item_details' => [
                [
                    'id' => $booking->field->id,
                    'price' => (int)$booking->total_harga,
                    'quantity' => 1,
                    'name' => 'Sewa Lapangan ' . $booking->field->nama
                ]
            ],
            'enabled_payments' => $enabledPayments
        ];
        
        // Add callbacks if routes are defined
        if (Route::has('booking.finish') && Route::has('booking.error') && Route::has('booking.pending')) {
            $params['callbacks'] = [
                'finish' => route('booking.finish', $booking->id),
                'error' => route('booking.error', $booking->id),
                'pending' => route('booking.pending', $booking->id)
            ];
        }

        // Simpan order_id di tabel payments
        Payment::create([
            'booking_id' => $booking->id,
            'order_id' => $orderId,
            'transaction_status' => 'pending',
            'transaction_time' => now(),
            'gross_amount' => $booking->total_harga,
            'payment_method' => $request->payment_method
        ]);

        $snapToken = Snap::getSnapToken($params);

        return view('admin.bookings.pay', compact('snapToken', 'booking'));
    }

    // Helper function to get enabled payment methods based on user selection
    private function getEnabledPaymentMethods($paymentMethod)
    {
        switch ($paymentMethod) {
            case 'credit_card':
                return ['credit_card'];
            case 'bank_transfer':
                return ['bca_va', 'bni_va', 'bri_va', 'mandiri_va', 'permata_va'];
            case 'e_wallet':
                return ['gopay', 'shopeepay', 'qris'];
            case 'retail':
                return ['alfamart', 'indomaret'];
            default:
                return []; 
        }
    }

    // New endpoint for snap token generation via AJAX
    public function getSnapToken(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'waktu' => 'required|exists:schedules,id',
            'payment_method' => 'required|in:credit_card,bank_transfer,e_wallet,retail',
        ]);

        $schedule = Schedule::findOrFail($request->waktu);
        $field = $schedule->field;

        // Generate order ID yang unik
        $orderId = 'ORDER-TEMP-' . Auth::id() . '-' . time();

        // Set enabled payment methods based on selection
        $enabledPayments = $this->getEnabledPaymentMethods($request->payment_method);

        // Buat transaksi Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int)$field->harga_perjam,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name ?? 'Guest',
                'email' => Auth::user()->email ?? 'guest@example.com',
            ],
            'item_details' => [
                [
                    'id' => $field->id,
                    'price' => (int)$field->harga_perjam,
                    'quantity' => 1,
                    'name' => 'Sewa Lapangan ' . $field->nama
                ]
            ],
            'enabled_payments' => $enabledPayments
        ];
        
        // Add callbacks if routes are defined
        if (Route::has('booking.finish.ajax') && Route::has('booking.error.ajax') && Route::has('booking.pending.ajax')) {
            $params['callbacks'] = [
                'finish' => route('booking.finish.ajax'),
                'error' => route('booking.error.ajax'),
                'pending' => route('booking.pending.ajax')
            ];
        }

        try {
            $snapToken = Snap::getSnapToken($params);
            return response()->json(['snapToken' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    // Fungsi callback untuk halaman setelah pembayaran
    public function finishPayment($id)
    {
        $booking = Booking::with(['field', 'payments'])->findOrFail($id);
        return view('booking.finish', compact('booking'));
    }

    public function errorPayment($id)
    {
        $booking = Booking::with(['field', 'payments'])->findOrFail($id);
        return view('booking.error', compact('booking'));
    }

    public function pendingPayment($id)
    {
        $booking = Booking::with(['field', 'payments'])->findOrFail($id);
        return view('booking.pending', compact('booking'));
    }

    // AJAX callback handlers
    public function finishPaymentAjax(Request $request)
    {
        // Handle success via AJAX
        return response()->json(['status' => 'success']);
    }

    public function errorPaymentAjax(Request $request)
    {
        // Handle error via AJAX
        return response()->json(['status' => 'error']);
    }

    public function pendingPaymentAjax(Request $request)
    {
        // Handle pending via AJAX
        return response()->json(['status' => 'pending']);
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
            'payment_method' => 'nullable|in:credit_card,bank_transfer,e_wallet,retail',
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
            'payment_method' => $request->payment_method ?? $booking->payment_method,
        ]);

        return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil diperbarui.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil dihapus.');
    }
}