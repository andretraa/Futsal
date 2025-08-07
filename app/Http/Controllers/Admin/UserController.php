<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(){
        $users = User::paginate();   
        return view('admin.users.index', compact('users'));
    }

    public function destroy($id)
{
    $user = User::findOrFail($id);

    // Optional: Cegah hapus diri sendiri
    if (auth()->id() == $user->id) {
        return redirect()->back()->with('error', 'Tidak dapat menghapus akun sendiri.');
    }

    $user->delete();

    return redirect()->back()->with('success', 'User berhasil dihapus.');
}

}
