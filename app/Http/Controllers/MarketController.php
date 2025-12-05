<?php

namespace App\Http\Controllers;

use App\Models\Commodity;
use App\Models\CommodityMarket;
use App\Models\Market;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MarketController extends Controller
{
    public function index()
    {
        $markets = Market::all();
        return view('dashboard.market', compact('markets'));
    }

    public function create()
    {
        return view('dashboard.market-create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name_market'   => 'required|string|max:255',
            'address'       => 'required|string|max:255',
            'description'   => 'required|string',
            'opening_hours' => 'required|string|max:100',
            'maps_link'     => 'nullable|string|max:255',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('market_images', 'public');
        }

        $market = Market::create([
            'name_market' => $request->name_market,
            'address' => $request->address,
            'description' => $request->description,
            'opening_hours' => $request->opening_hours,
            'maps_link' => $request->maps_link,
            'status' => $request->status ?? 'aktif',
            'image' => $imagePath,

        ]);

        $commodities = Commodity::all();

        // 3. Insert otomatis ke tabel commodity_market
        foreach ($commodities as $commodity) {
            CommodityMarket::create([
                'commodity_id' => $commodity->id_commodity,
                'market_id'    => $market->id_market,
                'status'       => 'aktif',
            ]);
        }

        return redirect()->route('superadmin.market')->with('success', 'Data pasar berhasil ditambahkan!');
    }
    public function destroy($id)
    {
        CommodityMarket::where('market_id', $id)->delete();

        $market = Market::findOrFail($id);

        // Hapus gambar jika ada
        if ($market->image) {
            Storage::disk('public')->delete($market->image);
        }

        $market->delete();

        return redirect()->route('superadmin.market')->with('success', 'Data pasar berhasil dihapus!');
    }
    public function edit($id)
    {
        $market = Market::findOrFail($id);

        return view('dashboard.market-create', compact('market'));
    }
    public function update(Request $request, $id)
    {
        $market = Market::findOrFail($id);

        $request->validate([
            'name_market'   => 'required|string|max:255',
            'address'       => 'required|string|max:255',
            'description'   => 'required|string',
            'opening_hours' => 'required|string|max:100',
            'maps_link'     => 'nullable|string|max:255',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $market->image = $request->file('image')->store('market_images', 'public');
        }
        $market->update([
            'name_market'   => $request->name_market,
            'address'       => $request->address,
            'description'   => $request->description,
            'opening_hours' => $request->opening_hours,
            'maps_link'     => $request->maps_link,
            'status'        => $request->status ?? 'aktif',
            'image'         => $market->image,
        ]);

        CommodityMarket::where('market_id', $id)
            ->update(['status' => $request->status]);

        return redirect()->route('superadmin.market')->with('success', 'Data pasar berhasil diupdate!');
    }

    public function publicIndex()
    {
        $markets = Market::where('status', 'aktif')->get();

        return view('pasar.pasar', compact('markets'));
    }

    public function detail($id)
    {
        $market = Market::findOrFail($id);

        return view('pasar.detailpasar', compact('market'));
    }

    public function home()
    {
        $markets = Market::where('status', 'aktif')->get();
        return view('home.index', compact('markets'));
    }

}
