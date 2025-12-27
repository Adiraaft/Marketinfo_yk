<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Commodity;
use App\Models\Market;
use App\Models\Price;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CommodityController extends Controller
{
    public function index(Request $request)
    {
        $commodities = Commodity::with(['category', 'unit'])->get();
        $units = Unit::all();
        $categories = Category::all();

        if ($request->kategori && $request->kategori != '#') {
            $commodities = $commodities->where('category_id', $request->kategori);
        }

        $latestPrices = Price::selectRaw('
            DISTINCT ON (commodity_id, market_id)
            commodity_id,
            market_id,
            price,
            date
        ')
            ->orderBy('commodity_id')
            ->orderBy('market_id')
            ->orderBy('date', 'desc')
            ->orderBy('id_price', 'desc')
            ->get()
            ->groupBy('commodity_id');

        // 3️⃣ Hitung rata-rata HANYA dari tanggal TERBARU
        $commodities = $commodities->map(function ($c) use ($latestPrices) {

            $rows = $latestPrices[$c->id_commodity] ?? collect();

            if ($rows->isEmpty()) {
                $c->latest_avg  = null;
                $c->latest_date = null;
                return $c;
            }

            // Ambil tanggal terbaru global
            $latestDate = $rows->max('date');

            // Ambil harga di tanggal terbaru saja
            $pricesAtLatestDate = $rows
                ->where('date', $latestDate)
                ->pluck('price');

            $c->latest_avg  = $pricesAtLatestDate->avg();
            $c->latest_date = $latestDate;

            return $c;
        });

        return view('dashboard.komoditas', compact('commodities', 'categories', 'units'));
    }

    public function detail($id)
    {
        $prices = Price::with('market')
            ->selectRaw('DISTINCT ON (market_id) *')
            ->where('commodity_id', $id)
            ->orderBy('market_id')
            ->orderBy('date', 'desc')
            ->get();

        return response()->json($prices);
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
            DB::table('commodity_markets')->insert([
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
            if ($commodity->image && Storage::disk('public')->exists('commodity_images/' . $commodity->image)) {
                Storage::disk('public')->delete('commodity_images/' . $commodity->image);
            }

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();

            $fileName = Str::slug($request->name_commodity) . '.' . $extension;

            $file->storeAs('commodity_images', $fileName, 'public');

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
