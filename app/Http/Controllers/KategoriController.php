<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    // Tampilkan kategori
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
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        // Upload gambar
        $filename = null;
        if ($request->hasFile('image')) {
            $filename = time() . '_' . uniqid() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $filename);
        }

        DB::table('categories')->insert([
            'name_category' => $request->nama_kategori,
            'image' => $filename,
        ]);

        return redirect()->route('superadmin.kategori')->with('success', 'Kategori berhasil ditambahkan.');
    }

    // Update kategori
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        // Ambil data lama
        $old = DB::table('categories')->where('id_category', $id)->first();

        $filename = $old->image;

        // Jika upload gambar baru
        if ($request->hasFile('image')) {

            // Hapus file lama jika ada
            if ($old->image && file_exists(public_path('images/' . $old->image))) {
                unlink(public_path('images/' . $old->image));
            }

            // Upload baru
            $filename = time() . '_' . uniqid() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $filename);
        }

        DB::table('categories')
            ->where('id_category', $id)
            ->update([
                'name_category' => $request->nama_kategori,
                'image' => $filename,
            ]);

        return redirect()->route('superadmin.kategori')->with('success', 'Kategori berhasil diperbarui.');
    }

    // Hapus kategori
    public function destroy($id)
    {
        $old = DB::table('categories')->where('id_category', $id)->first();

        // Hapus gambar jika ada
        if ($old && $old->image && file_exists(public_path('images/' . $old->image))) {
            unlink(public_path('images/' . $old->image));
        }

        DB::table('categories')->where('id_category', $id)->delete();

        return redirect()->route('superadmin.kategori')->with('success', 'Kategori berhasil dihapus.');
    }
}
