<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
    /**
     * Tampilkan semua data satuan.
     */
    public function index()
    {
        $satuans = Satuan::latest()->get();
        return view('dashboard.setting-satuan', compact('satuans'));
    }

    /**
     * Simpan data satuan baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_satuan' => 'required|string|max:255',
        ]);

        Satuan::create([
            'nama_satuan' => $request->nama_satuan,
        ]);

        return redirect()
            ->route('superadmin.satuan')
            ->with('success', 'Data satuan berhasil ditambahkan.');
    }

    /**
     * Perbarui data satuan yang sudah ada.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_satuan' => 'required|string|max:255',
        ]);

        $satuan = Satuan::findOrFail($id);
        $satuan->update([
            'nama_satuan' => $request->nama_satuan,
        ]);

        return redirect()
            ->route('superadmin.satuan')
            ->with('success', 'Data satuan berhasil diperbarui.');
    }

    /**
     * Hapus data satuan.
     */
    public function destroy($id)
    {
        $satuan = Satuan::findOrFail($id);
        $satuan->delete();

        return redirect()
            ->route('superadmin.satuan')
            ->with('success', 'Data satuan berhasil dihapus.');
    }
}
