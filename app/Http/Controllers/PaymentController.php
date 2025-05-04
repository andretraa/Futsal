<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;

class PaymentController extends Controller
{
    public function getSnapToken(Request $request)
    {
        // Konfigurasi Midtrans
        Config::$serverKey = 'SB-Mid-server-QBN0TeV3PkRJgQUDsdSsoT9N';
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Detail transaksi
        $transactionDetails = [
            'order_id' => uniqid(),
            'gross_amount' => 1000
        ];

        // Detail customer (dummy, bisa dari form)
        $customerDetails = [
            'first_name' => 'Booking',
            'email' => 'user@example.com',
        ];

        // Gabungkan semua parameter
        $params = [
            'transaction_details' => $transactionDetails,
            'customer_details' => $customerDetails
        ];

        // Dapatkan Snap Token
        $snapToken = Snap::getSnapToken($params);

        return response()->json(['snapToken' => $snapToken]);
    }
}