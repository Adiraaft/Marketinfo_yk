<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)
                    ->where('status', 'aktif')
                    ->where('role',  'admin')
                    ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah'
            ], 400);
        }

        // bikin token API
        $token = $user->createToken('mobile_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'token'   => $token,
            'user' => [
                'id'  => $user->id_user,
                'name'     => $user->name,
                'email'    => $user->email,
                'image'    => $user->image,
                'role'     => $user->role,
                'market_id'=> $user->market_id
            ]
        ]);
    }
    public function changePassword(Request $request)
    {
        // Ambil user dari token Sanctum
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Token tidak valid atau user tidak ditemukan'
            ], 401);
        }

        // Validasi input
        $request->validate([
            'oldPassword' => 'required|string',
            'newPassword' => 'required|string|min:6'
        ]);

        $oldPassword = $request->oldPassword;
        $newPassword = $request->newPassword;

        // Cek password lama
        if (!Hash::check($oldPassword, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password lama salah'
            ], 400);
        }

        // Update password baru
        $user->password = Hash::make($newPassword);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diperbarui'
        ]);
    }
}
