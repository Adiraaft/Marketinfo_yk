<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    public function index()
    {
        $superadmin = User::where('role', 'superadmin')->first();

        return view('dashboard.dashboard', [
            'totalPasar'      => \App\Models\Market::count(),
            'totalPetugas'    => \App\Models\User::where('role', 'admin')->count(),
            'totalKomoditas'  => \App\Models\Commodity::count(),
        ], compact('superadmin'));
    }
    public function edit()
    {
        $user = Auth::user(); // ambil data user yang sedang login

        return view('dashboard.setting-account', compact('user'));
    }

    // 🔹 Update data profil superadmin
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'date_of_birth' => 'required|date',
            'email' => 'required|email|unique:users,email,' . $user->id_user . ',id_user',
            'password' => 'nullable|min:8',
        ]);

        // Gabungkan nama depan dan belakang
        $user->name = $request->first_name . ' ' . $request->last_name;
        $user->date_of_birth = $request->date_of_birth;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();


        // Redirect kembali ke halaman account
        return redirect()
            ->route('superadmin.account')
            ->with('success', 'Data akun berhasil diperbarui!');
    }
}
