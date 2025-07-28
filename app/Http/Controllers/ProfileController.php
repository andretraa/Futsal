<?php
namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Field;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Ambil data booking user dengan relasi field
        $bookings = $user->booking()->with('field')->get();
        
        return view('profil', compact('bookings'));
    }
}