<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransNotificationController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
    }

    public function handle(Request $request)
    {
        try {
            $notification = new Notification();

            $notificationArray = $notification->getResponse();
            $transaction = $notificationArray;
            $transactionStatus = $transaction['transaction_status'];
            $fraud = $transaction['fraud_status'];
            $orderId = $transaction['order_id'];
            
            // Extract booking ID from order ID (assuming format: ORDER-{bookingId}-{timestamp})
            $bookingIdParts = explode('-', $orderId);
            $bookingId = $bookingIdParts[1] ?? null;
            
            if (!$bookingId) {
                Log::error('Invalid order ID format: ' . $orderId);
                return response()->json(['status' => 'error', 'message' => 'Invalid order ID format']);
            }

            $booking = Booking::find($bookingId);
            
            if (!$booking) {
                Log::error('Booking not found: ' . $bookingId);
                return response()->json(['status' => 'error', 'message' => 'Booking not found']);
            }

            // Simpan data transaksi ke tabel payments
            $paymentData = [
                'booking_id' => $bookingId,
                'order_id' => $orderId,
                'payment_method' => $transaction['payment_type'] ?? '',
                'transaction_time' => $transaction['transaction_time'] ?? now(),
                'transaction_status' => $transactionStatus,
                'gross_amount' => $transaction['gross_amount'] ?? 0,
                'pdf_url' => $transaction['pdf_url'] ?? null
            ];

            // Jika ada virtual account, simpan informasinya
            if (isset($transaction['va_numbers'])) {
                $paymentData['va_numbers'] = json_encode($transaction['va_numbers']);
            }

            // Update atau buat payment record
            $payment = Payment::updateOrCreate(
                ['booking_id' => $bookingId],
                $paymentData
            );

            // Update status booking berdasarkan status transaksi
            if ($transactionStatus == 'capture') {
                if ($fraud == 'challenge') {
                    // Transaksi challenge - belum tentu berhasil
                    $booking->status = 'pending';
                } else if ($fraud == 'accept') {
                    // Transaksi berhasil
                    $booking->status = 'confirmed';
                }
            } else if ($transactionStatus == 'settlement') {
                // Transaksi berhasil (settlement)
                $booking->status = 'confirmed';
            } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
                // Transaksi gagal
                $booking->status = 'cancelled';
            } else if ($transactionStatus == 'pending') {
                // Transaksi pending
                $booking->status = 'pending';
            }

            $booking->save();

            Log::info('Payment notification processed: ' . $orderId . ' with status ' . $transactionStatus);
            return response()->json(['status' => 'success']);
            
        } catch (\Exception $e) {
            Log::error('Error processing Midtrans notification: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}