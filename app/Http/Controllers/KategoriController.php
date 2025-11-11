<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    // Tampilkan semua kategori
    public function index()
    {
        $kategori = DB::table('categories')->get();
        return view('dashboard.setting-kategori', compact('kategori'));
    }

    // Simpan kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100',
        ]);

        DB::table('categories')->insert([
            'name_category' => $request->nama_kategori,
        ]);

        return redirect()->route('superadmin.kategori')->with('success', 'Kategori berhasil ditambahkan.');
    }

    // Update kategori
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100',
        ]);

        DB::table('categories')
            ->where('id_category', $id)
            ->update([
                'name_category' => $request->nama_kategori,
            ]);

        return redirect()->route('superadmin.kategori')->with('success', 'Kategori berhasil diperbarui.');
    }

    // Hapus kategori
    public function destroy($id)
    {
        DB::table('categories')->where('id_category', $id)->delete();
        return redirect()->route('superadmin.kategori')->with('success', 'Kategori berhasil dihapus.');
    }
}
