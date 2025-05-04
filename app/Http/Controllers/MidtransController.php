<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Notification;
use App\Models\Payment;
use App\Models\Booking;

class MidtransController extends Controller
{
    public function callback(Request $request)
{
    $notif = new Notification();
    $transaction = $notif->transaction_status;
    $orderId = $notif->order_id;
    $bookingId = explode('-', $orderId)[1];

    $booking = Booking::findOrFail($bookingId);

    // Simpan ke tabel payments
    Payment::updateOrCreate(
        ['booking_id' => $booking->id],
        [
            'order_id' => $orderId,
            'payment_method' => $notif->payment_type,
            'transaction_time' => $notif->transaction_time,
            'transaction_status' => $transaction,
            'gross_amount' => $notif->gross_amount,
            'va_numbers' => json_encode($notif->va_numbers ?? []),
            'pdf_url' => $notif->pdf_url ?? null,
        ]
    );

    $booking->update(['status' => $transaction]);
    return response()->json(['status' => 'OK']);
}
}
