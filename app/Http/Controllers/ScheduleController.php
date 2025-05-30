<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Field;
use App\Models\Booking; // Pastikan model Booking sudah ada
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ScheduleController extends Controller
{
    // ... (metode index, create, store, show, edit, update, destroy yang sudah ada)

    /**
     * Memeriksa ketersediaan jadwal untuk lapangan dan tanggal tertentu.
     * Mengembalikan daftar jadwal dengan status booking.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'field_id' => 'required|exists:fields,id',
            'booking_date' => 'required|date_format:Y-m-d',
        ]);

        $fieldId = $request->input('field_id');
        $bookingDate = $request->input('booking_date');

        // Atur locale Carbon ke Bahasa Indonesia untuk mendapatkan nama hari yang sesuai
        Carbon::setLocale('id');
        // Pastikan nama hari di DB (day_of_week) menggunakan format Bahasa Indonesia (Senin, Selasa, dst.)
        $dayOfWeek = Carbon::parse($bookingDate)->dayName;

        // Log untuk debugging:
        \Log::info('checkAvailability called: field_id=' . $fieldId . ', booking_date=' . $bookingDate . ', dayOfWeek=' . $dayOfWeek);

        // Ambil semua jadwal yang telah didefinisikan untuk lapangan dan hari tersebut
        // yang ditandai sebagai 'is_available' secara umum.
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
        $currentDateTime = Carbon::now(config('app.timezone')); // Ambil waktu saat ini dengan timezone aplikasi

        foreach ($allDefinedSchedules as $schedule) {
            $isBooked = false;

            // Buat objek Carbon untuk waktu mulai jadwal pada tanggal booking yang dipilih
            $scheduleStartDateTime = Carbon::createFromFormat(
                'Y-m-d H:i', // Format harus Y-m-d H:i karena start_time di Schedule hanya H:i
                $bookingDate . ' ' . $schedule->start_time,
                config('app.timezone')
            );
            $scheduleEndDateTime = Carbon::createFromFormat(
                'Y-m-d H:i',
                $bookingDate . ' ' . $schedule->end_time,
                config('app.timezone')
            );


            // 1. Cek apakah jadwal sudah lewat pada hari yang sama (hanya untuk hari ini)
            // Ini agar user tidak bisa booking jam yang sudah lewat di hari yang sama
            if ($scheduleStartDateTime->isSameDay($currentDateTime) && $scheduleStartDateTime->lt($currentDateTime)) {
                $isBooked = true; // Tandai sebagai terisi karena sudah lewat
            }
            // 2. Jika belum lewat, cek apakah ada booking yang sudah 'pending' atau 'paid' untuk slot ini
            else {
                // Periksa apakah ada booking yang tumpang tindih dengan slot ini
                // Booking harus mengacu pada jadwal spesifik (schedule_id) dan tanggal
                $existingBooking = Booking::where('field_id', $fieldId)
                                          ->where('schedule_id', $schedule->id) // Referensi ke schedule_id
                                          ->where('tanggal_pemesanan', $bookingDate) // Tanggal booking
                                          ->whereIn('status', ['pending', 'paid']) // Hanya yang pending/paid
                                          ->exists();

                if ($existingBooking) {
                    $isBooked = true;
                }
            }

            $schedulesWithBookingStatus[] = [
                'id' => $schedule->id,
                'start_time' => $schedule->start_time, // Tetap kirim H:i untuk frontend
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

    /**
     * Menyimpan booking baru.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function storeBooking(Request $request)
    {
        $request->validate([
            'field_id' => 'required|exists:fields,id',
            'tanggal_pemesanan' => 'required|date_format:Y-m-d',
            'schedule_id' => 'required|exists:schedules,id', // Validasi schedule_id
            'total_harga' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
        ]);

        $fieldId = $request->input('field_id');
        $tanggalPemesanan = $request->input('tanggal_pemesanan');
        $scheduleId = $request->input('schedule_id');
        $totalHarga = $request->input('total_harga');

        // Ambil detail jadwal dari tabel schedules
        $schedule = Schedule::findOrFail($scheduleId);

        // Buat objek Carbon untuk waktu mulai dan berakhir booking
        $startBookingTime = Carbon::createFromFormat(
            'Y-m-d H:i',
            $tanggalPemesanan . ' ' . $schedule->start_time,
            config('app.timezone')
        );
        $endBookingTime = Carbon::createFromFormat(
            'Y-m-d H:i',
            $tanggalPemesanan . ' ' . $schedule->end_time,
            config('app.timezone')
        );

        // **PENTING: Cek ulang ketersediaan di backend untuk menghindari race condition**
        // Cek jika ada booking lain yang tumpang tindih untuk schedule_id dan tanggal yang sama
        $isBooked = Booking::where('field_id', $fieldId)
                           ->where('schedule_id', $scheduleId)
                           ->where('tanggal_pemesanan', $tanggalPemesanan)
                           ->whereIn('status', ['pending', 'paid'])
                           ->exists();

        if ($isBooked) {
            // Jika sudah terisi, kirim respons error
            return response()->json([
                'success' => false,
                'message' => 'Slot waktu ini baru saja terisi. Silakan pilih slot lain.'
            ], 409); // Conflict
        }

        // Cek juga apakah waktu sudah lewat (walaupun sudah dicek di frontend, validasi backend tetap perlu)
        $currentDateTime = Carbon::now(config('app.timezone'));
        if ($startBookingTime->lt($currentDateTime)) {
            return response()->json([
                'success' => false,
                'message' => 'Slot waktu yang Anda pilih sudah lewat.'
            ], 400); // Bad Request
        }

        // Buat booking baru dengan status 'pending'
        $booking = new Booking();
        $booking->field_id = $fieldId;
        $booking->user_id = auth()->id(); // Asumsi user sudah login
        $booking->schedule_id = $scheduleId; // Simpan schedule_id
        $booking->tanggal_pemesanan = $tanggalPemesanan;
        $booking->start_time = $startBookingTime; // Simpan datetime lengkap di booking
        $booking->end_time = $endBookingTime;     // Simpan datetime lengkap di booking
        $booking->total_harga = $totalHarga;
        $booking->payment_method = $request->input('payment_method');
        $booking->status = 'pending';
        $booking->save();

        // **Inisialisasi Midtrans Snap**
        \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
        \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $booking->id . '-' . time(), // Order ID unik untuk Midtrans
                'gross_amount' => $booking->total_harga,
            ),
            'customer_details' => array(
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
                // 'phone' => '08123456789', // Opsional
            ),
            'callbacks' => array(
                'finish' => route('booking.finish', $booking->id), // Contoh URL setelah pembayaran sukses
                'error' => route('booking.error', $booking->id),   // Contoh URL setelah pembayaran gagal
                'pending' => route('booking.pending', $booking->id), // Contoh URL setelah pembayaran pending
            ),
            // 'enabled_payments' => ['credit_card', 'gopay', 'bca_va'], // Anda bisa memfilter metode pembayaran di sini
        );

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $booking->midtrans_transaction_id = $booking->id . '-' . time(); // Simpan order_id Midtrans
            $booking->snap_token = $snapToken; // Simpan snap token jika diperlukan untuk re-rendering
            $booking->save();

            return response()->json([
                'success' => true,
                'message' => 'Booking berhasil dibuat, melanjutkan ke pembayaran.',
                'booking_id' => $booking->id,
                'snap_token' => $snapToken // Kirim snap token ke frontend
            ]);
        } catch (\Exception $e) {
            \Log::error('Midtrans Snap Error: ' . $e->getMessage(), ['booking_id' => $booking->id]);
            // Jika gagal membuat token Midtrans, batalkan booking atau tandai sebagai gagal
            $booking->status = 'failed';
            $booking->save();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menginisialisasi pembayaran: ' . $e->getMessage()
            ], 500);
        }
    }

    // Perlu tambahkan route di web.php untuk ini
    public function getPaymentToken(Booking $booking)
    {
        // Pastikan hanya user yang punya booking ini yang bisa lihat
        if (auth()->id() !== $booking->user_id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Jika snap_token sudah ada, langsung kirim
        if ($booking->snap_token) {
            return response()->json([
                'success' => true,
                'snap_token' => $booking->snap_token
            ]);
        }

        // Logika untuk membuat ulang snap token jika belum ada
        \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
        \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $booking->id . '-' . time(), // Harus unik lagi
                'gross_amount' => $booking->total_harga,
            ),
            'customer_details' => array(
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ),
            'callbacks' => array(
                'finish' => route('booking.finish', $booking->id),
                'error' => route('booking.error', $booking->id),
                'pending' => route('booking.pending', $booking->id),
            ),
        );

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $booking->snap_token = $snapToken;
            $booking->save();
            return response()->json([
                'success' => true,
                'snap_token' => $snapToken
            ]);
        } catch (\Exception $e) {
            \Log::error('Midtrans Snap Re-generate Error: ' . $e->getMessage(), ['booking_id' => $booking->id]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat token pembayaran ulang.'
            ], 500);
        }
    }
}