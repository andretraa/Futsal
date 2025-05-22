<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User; // ✅ tambahkan ini
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Jika ada filter tanggal (format: YYYY-MM-DD)
        if ($request->has('tanggal')) {
            $date = Carbon::parse($request->tanggal);
            $filteredBookings = Booking::whereDate('tanggal_pemesanan', $date)->count();
            $filteredIncome = Booking::whereDate('tanggal_pemesanan', $date)->sum('total_harga');
            $dateFormatted = $date->translatedFormat('d F Y');
        } 
        // Jika ada filter bulan (format: YYYY-MM)
        elseif ($request->has('bulan')) {
            $month = Carbon::parse($request->bulan);
            $filteredBookings = Booking::whereMonth('tanggal_pemesanan', $month->month)
                                        ->whereYear('tanggal_pemesanan', $month->year)
                                        ->count();
            $filteredIncome = Booking::whereMonth('tanggal_pemesanan', $month->month)
                                      ->whereYear('tanggal_pemesanan', $month->year)
                                      ->sum('total_harga');
            $dateFormatted = $month->translatedFormat('F Y');
        } 
        // Jika tidak ada filter, default hari ini
        else {
            $date = Carbon::today();
            $filteredBookings = Booking::whereDate('tanggal_pemesanan', $date)->count();
            $filteredIncome = Booking::whereDate('tanggal_pemesanan', $date)->sum('total_harga');
            $dateFormatted = $date->translatedFormat('d F Y');
        }

        // Statistik keseluruhan
        $allBookings = Booking::count();
        $allIncome = Booking::sum('total_harga');

        // ✅ Tambahkan statistik pengguna
        $totalUsers = User::count();

        return view('admin.dashboard.index', compact(
            'filteredBookings',
            'filteredIncome',
            'allBookings',
            'allIncome',
            'dateFormatted',
            'totalUsers' // ✅ kirim ke view
        ));
    }
}
