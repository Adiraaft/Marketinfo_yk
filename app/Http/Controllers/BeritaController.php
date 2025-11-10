<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    // ✅ Tampilkan daftar berita
    public function index()
    {
        $berita = Berita::latest()->get();
        return view('dashboard.berita', compact('berita'));
    }

    // ✅ Tampilkan form tambah berita
    public function create()
    {
        return view('dashboard.berita-create');
    }

    // ✅ Simpan berita baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image1' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'image2' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'image3' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'image4' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'source' => 'nullable|string|max:255',
        ]);

        // Simpan semua gambar (kalau ada)
        for ($i = 1; $i <= 4; $i++) {
            $imageKey = 'image' . $i;
            if ($request->hasFile($imageKey)) {
                $validated[$imageKey] = $request->file($imageKey)->store('berita', 'public');
            }
        }

        Berita::create($validated);

        return redirect()->route('superadmin.berita.index')
                         ->with('success', 'Berita berhasil ditambahkan!');
    }

    // ✅ Edit berita
    public function edit(Berita $berita)
    {
        return view('dashboard.berita-create', compact('berita'));
    }

    // ✅ Update berita
    public function update(Request $request, Berita $berita)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image1' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'image2' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'image3' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'image4' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'source' => 'nullable|string|max:255',
        ]);

        // Ganti gambar jika upload baru
        for ($i = 1; $i <= 4; $i++) {
            $imageKey = 'image' . $i;
            if ($request->hasFile($imageKey)) {
                // Hapus file lama kalau ada
                if ($berita->$imageKey) {
                    Storage::disk('public')->delete($berita->$imageKey);
                }
                $validated[$imageKey] = $request->file($imageKey)->store('berita', 'public');
            }
        }

        $berita->update($validated);

        return redirect()->route('superadmin.berita.index')
                         ->with('success', 'Berita berhasil diperbarui!');
    }

    // ✅ Hapus berita
    public function destroy(Berita $berita)
    {
        // Hapus semua file gambar
        for ($i = 1; $i <= 4; $i++) {
            $imageKey = 'image' . $i;
            if ($berita->$imageKey) {
                Storage::disk('public')->delete($berita->$imageKey);
            }
        }

        $berita->delete();

        return redirect()->route('superadmin.berita.index')
                         ->with('success', 'Berita berhasil dihapus!');
    }
}
