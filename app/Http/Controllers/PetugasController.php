<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Market;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;




class PetugasController extends Controller
{
    public function index()
    {
        // Ambil semua users dengan role admin dan relasi pasar
        $petugas = User::with('market')
            ->where('role', 'admin')
            ->get();

        return view('dashboard.petugas', compact('petugas'));
    }
    public function create()
    {
        $markets = Market::all(); // ambil semua pasar
        return view('dashboard.petugas-create', compact('markets'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'date_of_birth' => 'required|date',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'market_id' => 'required|exists:markets,id_market',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $name = $request->first_name . ' ' . $request->last_name;

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('petugas_images', 'public');
        }

        User::create([
            'name' => $name,
            'date_of_birth' => $request->date_of_birth,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'market_id' => $request->market_id,
            'status' => $request->status ?? 'aktif',
            'role' => 'admin',
            'image' => $imagePath,
        ]);

        return redirect()->route('superadmin.petugas')->with('success', 'Petugas berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $petugas = User::findOrFail($id);
        $markets = Market::all();
        return view('dashboard.petugas-create', compact('petugas', 'markets'));
    }

    public function update(Request $request, $id)
    {
        $petugas = User::findOrFail($id);

        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'date_of_birth' => 'required|date',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email,' . $petugas->id_user . ',id_user',
            'market_id' => 'required|exists:markets,id_market',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $petugas->name = $request->first_name . ' ' . $request->last_name;
        $petugas->date_of_birth = $request->date_of_birth;
        $petugas->phone = $request->phone;
        $petugas->email = $request->email;
        if ($request->password) {
            $petugas->password = Hash::make($request->password);
        }
        $petugas->market_id = $request->market_id;
        $petugas->status = $request->status;

        if ($request->hasFile('image')) {
            $petugas->image = $request->file('image')->store('petugas_images', 'public');
        }

        $petugas->save();

        return redirect()->route('superadmin.petugas')->with('success', 'Petugas berhasil diupdate!');
    }


    public function destroy($id)
    {
        $petugas = User::findOrFail($id);

        // Jika ada gambar, hapus dari storage
        if ($petugas->image) {
            Storage::disk('public')->delete($petugas->image);
        }

        $petugas->delete();

        return redirect()->route('superadmin.petugas')->with('success', 'Petugas berhasil dihapus!');
    }
}
