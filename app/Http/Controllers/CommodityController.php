<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Commodity;
use App\Models\Market;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CommodityController extends Controller
{
    public function index()
    {
        $commodities = Commodity::with(['category', 'unit'])->get();
        $units = Unit::all();
        $categories = Category::all();

        return view('dashboard.komoditas', compact('commodities', 'categories', 'units'));
    }

    public function create()
    {
        $categories = Category::all();
        $units = Unit::all();

        return view('dashboard.komoditas', compact('categories', 'units'));
    }

    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'name_commodity' => 'required|string|max:255',
            'category_id'    => 'required|integer',
            'unit_id'        => 'required|integer',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileName = Str::slug($request->name_commodity) . '.' . $extension;

            $file->storeAs('commodity_images', $fileName, 'public');

            $imagePath = $fileName; // hanya nama file
        }


        // 1. Simpan komoditas
        $commodity = Commodity::create([
            'name_commodity' => $request->name_commodity,
            'category_id'    => $request->category_id,
            'unit_id'        => $request->unit_id,
            'status'         => 'aktif', // aktif default
            'image' => $imagePath,
        ]);

        // 2. Ambil semua pasar
        $markets = Market::all();

        // 3. Insert otomatis ke tabel pivot
        foreach ($markets as $market) {
            DB::table('commodity_market')->insert([
                'commodity_id' => $commodity->id_commodity,
                'market_id'    => $market->id_market,
                'status'       => 'aktif', // default aktif
                'created_at'   => now(),
                'updated_at'   => now()
            ]);
        }

        return redirect()->back()->with('success_create', 'Komoditas berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $commodity = Commodity::findOrFail($id);

        // hapus gambar
        if ($commodity->image) {
            Storage::disk('public')->delete($commodity->image);
        }

        $commodity->delete();

        return redirect()->back()->with('success', 'Komoditas berhasil dihapus.');
    }
    public function edit($id)
    {
        $commodity = Commodity::with(['category', 'unit'])->findOrFail($id);
        $categories = Category::all();
        $units = Unit::all();

        return response()->json([
            'commodity' => $commodity,
            'categories' => $categories,
            'units' => $units
        ]);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name_commodity' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'unit_id' => 'required|integer',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $commodity = Commodity::findOrFail($id);

        // update gambar
        if ($request->hasFile('image')) {
            // 1️⃣ Hapus gambar lama jika ada
            if ($commodity->image && Storage::disk('public')->exists('commodity_images/' . $commodity->image)) {
                Storage::disk('public')->delete('commodity_images/' . $commodity->image);
            }

            // 2️⃣ Ambil file baru
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();

            // 3️⃣ Buat nama file rapi dan unik
            $fileName = Str::slug($request->name_commodity) . '.' . $extension;

            // 4️⃣ Simpan file baru di folder commodity_images
            $file->storeAs('commodity_images', $fileName, 'public');

            // 5️⃣ Update kolom image di database
            $commodity->image = $fileName;
        }



        // update data lain
        $commodity->update([
            'name_commodity' => $request->name_commodity,
            'category_id' => $request->category_id,
            'unit_id' => $request->unit_id,
        ]);

        return redirect()->back()->with('success', 'Data komoditas berhasil diperbarui.');
    }
}
