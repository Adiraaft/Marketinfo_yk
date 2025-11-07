<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Tampilkan form login
    public function index()
    {
        return view('login.form');
    }

    // Proses login
    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'email wajib diisi',
            'password.required' => 'password wajib diisi',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect berdasarkan role
            $user = Auth::user();
            if ($user->role === 'superadmin') {
                return redirect()->route('superadmin.dashboard')->with('success', 'Login berhasil!'); // atau superadmin.dashboard jika ada prefix
            } elseif ($user->role === 'admin') {
                return 'sukses'; // bisa dibedakan route khusus admin jika ada
            }

        }

        // Jika login gagal
        return back()->withErrors([
            'loginError' => 'Username dan password yang dimasukkan tidak valid'
        ])->withInput();
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect('login')->with('success', 'Logout berhasil!');
    }
}
