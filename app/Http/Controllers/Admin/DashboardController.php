<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Variabel awal
        $filteredBookings = 0;
        $filteredIncome = 0;
        $dateFormatted = '';

        // Jika ada filter tanggal (format: YYYY-MM-DD)
        if ($request->has('tanggal')) {
            $date = Carbon::parse($request->tanggal);

            $filteredBookings = Booking::whereDate('tanggal_pemesanan', $date)
                ->whereHas('payments', function ($q) {
                    $q->where('transaction_status', 'success');
                })
                ->count();

            $filteredIncome = Booking::whereDate('tanggal_pemesanan', $date)
                ->whereHas('payments', function ($q) {
                    $q->where('transaction_status', 'success');
                })
                ->sum('total_harga');

            $dateFormatted = $date->translatedFormat('d F Y');
        }

        // Jika ada filter bulan (format: YYYY-MM)
        elseif ($request->has('bulan')) {
            $month = Carbon::parse($request->bulan);

            $filteredBookings = Booking::whereMonth('tanggal_pemesanan', $month->month)
                ->whereYear('tanggal_pemesanan', $month->year)
                ->whereHas('payments', function ($q) {
                    $q->where('transaction_status', 'success');
                })
                ->count();

            $filteredIncome = Booking::whereMonth('tanggal_pemesanan', $month->month)
                ->whereYear('tanggal_pemesanan', $month->year)
                ->whereHas('payments', function ($q) {
                    $q->where('transaction_status', 'success');
                })
                ->sum('total_harga');

            $dateFormatted = $month->translatedFormat('F Y');
        }

        // Jika tidak ada filter, gunakan hari ini
        else {
            $date = Carbon::today();

            $filteredBookings = Booking::whereDate('tanggal_pemesanan', $date)
                ->whereHas('payments', function ($q) {
                    $q->where('transaction_status', 'success');
                })
                ->count();

            $filteredIncome = Booking::whereDate('tanggal_pemesanan', $date)
                ->whereHas('payments', function ($q) {
                    $q->where('transaction_status', 'success');
                })
                ->sum('total_harga');

            $dateFormatted = $date->translatedFormat('d F Y');
        }

        // Statistik keseluruhan (hanya yang berhasil bayar)
        $allBookings = Booking::whereHas('payments', function ($q) {
            $q->where('transaction_status', 'success');
        })->count();

        $allIncome = Booking::whereHas('payments', function ($q) {
            $q->where('transaction_status', 'success');
        })->sum('total_harga');

        $totalUsers = User::count();

        return view('admin.dashboard.index', compact(
            'filteredBookings',
            'filteredIncome',
            'allBookings',
            'allIncome',
            'dateFormatted',
            'totalUsers'
        ));
    }
}