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
        // $schedules = Schedule::with('field')->where('is_available', true)->get(); // No longer needed here as schedules will be loaded via AJAX
        return view('admin.bookings.create', compact('fields'));
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

        if (!$schedule->is_available) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jadwal ini tidak tersedia untuk booking.'
                ], 422);
            }
            return redirect()->back()->with('error', 'Jadwal ini tidak tersedia untuk booking.');
        }

        $start_time = Carbon::parse($request->tanggal_pemesanan . ' ' . $schedule->start_time);
        $end_time = Carbon::parse($request->tanggal_pemesanan . ' ' . $schedule->end_time);

        // Periksa apakah jadwal sudah dibooking pada tanggal yang sama dan statusnya bukan 'cancelled'
        $existingBooking = Booking::where('field_id', $request->field_id)
            ->where('tanggal_pemesanan', $request->tanggal_pemesanan)
            ->where(function($query) use ($start_time, $end_time) {
                $query->where('start_time', '<', $end_time)
                      ->where('end_time', '>', $start_time);
            })
            ->whereIn('status', ['pending', 'confirmed']) // Periksa booking yang masih aktif
            ->exists();

        if ($existingBooking) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jadwal ini sudah dibooking pada tanggal dan waktu yang dipilih.'
                ], 422);
            }
            return redirect()->back()->with('error', 'Jadwal ini sudah dibooking pada tanggal dan waktu yang dipilih.');
        }

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

        // Simpan order_id di tabel payments
        Payment::create([
            'booking_id' => $booking->id,
            'order_id' => $orderId,
            'transaction_status' => 'pending',
            'transaction_time' => now(),
            'gross_amount' => $booking->total_harga,
            'payment_method' => $request->payment_method
        ]);

        // Return booking ID for the next step
        return response()->json([
            'success' => true,
            'booking_id' => $booking->id
        ]);
    }
    // Step 2: Create a new function to process payment
    public function processPayment($id)
    {
        $booking = Booking::findOrFail($id);
        $payment = Payment::where('booking_id', $booking->id)->firstOrFail();
        
        // Set enabled payment methods based on selection
        $enabledPayments = $this->getEnabledPaymentMethods($booking->payment_method);

        // Buat transaksi Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $payment->order_id,
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
        
        // Add callbacks
        $params['callbacks'] = [
            'finish' => route('booking.finish', $booking->id),
            'error' => route('booking.error', $booking->id),
            'pending' => route('booking.pending', $booking->id)
        ];

        // Get Snap Token
        $snapToken = Snap::getSnapToken($params);
        
        // Return view with snapToken
        return view('booking.process', compact('snapToken', 'booking'));
    }

    // Step 3: Create callback functions for payment status updates
    public function finishPayment($id)
    {
        $booking = Booking::findOrFail($id);
        $payment = Payment::where('booking_id', $booking->id)->firstOrFail();
        
        // Get transaction status from Midtrans
        $status = $this->getTransactionStatus($payment->order_id);
        
        if ($status == 'settlement' || $status == 'capture') {
            // Update booking status
            $booking->status = 'confirmed';
            $booking->save();
            
            // Update payment status
            $payment->transaction_status = 'success';
            $payment->save();
            
            return view('booking.finish', compact('booking', 'payment'));
        }
        
        return redirect()->route('admin.bookings.index')
            ->with('info', 'Status pembayaran: ' . $status);
    }

    public function errorPayment($id)
    {
        $booking = Booking::findOrFail($id);
        $payment = Payment::where('booking_id', $booking->id)->firstOrFail();
        
        // Update payment status
        $payment->transaction_status = 'failed';
        $payment->save();
        
        return redirect()->route('fields.index')
            ->with('error', 'Pembayaran gagal! Silakan coba lagi.');
    }

    public function pendingPayment($id)
    {
        $booking = Booking::findOrFail($id);
        $payment = Payment::where('booking_id', $booking->id)->firstOrFail();
        
        // Update payment status if needed
        $payment->transaction_status = 'pending';
        $payment->save();
        
        return redirect()->route('fields.index')
            ->with('info', 'Pembayaran dalam proses. Silakan selesaikan pembayaran.');
    }

    // Helper function to get transaction status from Midtrans
    private function getTransactionStatus($orderId)
    {
        try {
            $transaction = \Midtrans\Transaction::status($orderId);

            if (is_object($transaction) && property_exists($transaction, 'transaction_status')) {
                return $transaction->transaction_status;
            }

            return 'unknown'; // fallback jika status tidak ditemukan
        } catch (\Exception $e) {
            return 'error';
        }
    }

    // Helper function to map payment method to Midtrans enabled_payments
    private function getEnabledPaymentMethods($method)
    {
        switch ($method) {
            case 'credit_card':
                return ['credit_card'];
            
            case 'bank_transfer':
                return ['bank_transfer', 'bca_va', 'bni_va', 'bri_va', 'mandiri_va'];
                
            case 'e_wallet':
                return ['gopay', 'shopeepay', 'qris', 'Dana', 'ovo']; // Note: 'Dana' and 'ovo' might need specific Midtrans identifiers or only work via QRIS/specific integrations
                
            case 'retail':
                return ['alfamart', 'indomaret'];
                
            default:
                return ['credit_card', 'bank_transfer', 'gopay', 'shopeepay'];
        }
    }

    public function getPaymentToken($id)
    {
        $booking = Booking::findOrFail($id);
        $payment = Payment::where('booking_id', $booking->id)->firstOrFail();
        
        // Set enabled payment methods based on selection
        $enabledPayments = $this->getEnabledPaymentMethods($booking->payment_method);

        // Buat transaksi Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $payment->order_id,
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
        
        // Add callbacks
        $params['callbacks'] = [
            'finish' => route('booking.finish', $booking->id),
            'error' => route('booking.error', $booking->id),
            'pending' => route('booking.pending', $booking->id)
        ];

        // Get Snap Token
        $snapToken = Snap::getSnapToken($params);
        
        return response()->json(['snap_token' => $snapToken]);
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