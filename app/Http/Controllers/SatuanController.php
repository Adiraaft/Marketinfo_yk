<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
    public function index()
    {
        $satuans = Unit::latest()->get();
        return view('dashboard.setting-satuan', compact('satuans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_unit' => 'required|string|max:255',
        ]);

        Unit::create([
            'name_unit' => $request->name_unit,
        ]);

        return redirect()
            ->route('superadmin.satuan')
            ->with('success', 'Data satuan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name_unit' => 'required|string|max:255',
        ]);

        $satuan = Unit::findOrFail($id);

        $satuan->update([
            'name_unit' => $request->name_unit,
        ]);

        return redirect()
            ->route('superadmin.satuan')
            ->with('success', 'Data satuan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $satuan = Unit::findOrFail($id);
        $satuan->delete();

        return redirect()
            ->route('superadmin.satuan')
            ->with('success', 'Data satuan berhasil dihapus.');
    }
}
