<?php

namespace App\Http\Controllers;

use App\Models\Commodity;
use App\Models\CommodityMarket;
use App\Models\Market;
use App\Models\Price;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $marketId = auth()->user()->market_id;

        $commodities = Commodity::whereHas('commodityMarkets', function ($q) use ($marketId) {
            $q->where('market_id', $marketId);
        })
            ->with(['commodityMarkets' => function ($q) use ($marketId) {
                $q->where('market_id', $marketId);
            }, 'category', 'unit'])
            ->get();

        return view('dashboardAdmin.manajemen', compact('commodities'));
    }

    public function updateStatus(Request $request, $id)
    {
        $pivot = CommodityMarket::findOrFail($id);

        $pivot->status = $request->status;
        $pivot->save();

        return response()->json(['success' => true]);
    }

    public function komoditas($filter = 'all')
    {
        $marketId = auth()->user()->market_id;

        $commodities = Commodity::whereHas('commodityMarkets', function ($q) use ($marketId) {
            $q->where('market_id', $marketId)
                ->where('status', 'aktif'); // Hanya komoditas aktif di market login
        })
            ->with(['commodityMarkets' => function ($q) use ($marketId) {
                $q->where('market_id', $marketId); // Ambil pivot market login
            }, 'category', 'unit'])
            ->get();

        $countAll = $commodities->count();

        $countSudah = $commodities->filter(function ($item) {
            $pivot = $item->commodityMarkets->first();
            $todayPrice = optional(optional($pivot)->prices)
                ->where('date', now()->toDateString())
                ->first();

            return $todayPrice;
        })->count();

        $countBelum = $commodities->filter(function ($item) {
            $pivot = $item->commodityMarkets->first();
            $todayPrice = optional(optional($pivot)->prices)
                ->where('date', now()->toDateString())
                ->first();

            return !$todayPrice;
        })->count();

        // ============================
        // FILTER DATA UTAMA
        // ============================
        $filtered = $commodities->filter(function ($item) use ($filter) {
            $pivot = $item->commodityMarkets->first();
            $todayPrice = optional(optional($pivot)->prices)
                ->where('date', now()->toDateString())
                ->first();

            if ($filter === 'belum-update') return !$todayPrice;
            if ($filter === 'sudah-update') return $todayPrice;
            return true;
        });

        return view('dashboardAdmin.komoditas', [
            'commodities' => $filtered,
            'activeFilter' => $filter,
            'countAll' => $countAll,
            'countSudah' => $countSudah,
            'countBelum' => $countBelum,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'commodityId' => 'required',
            'price'       => 'required|array',
            'price.*'     => 'required|numeric',
            'price_date'  => 'required|date',
        ]);

        $commodityMarket = CommodityMarket::findOrFail($request->commodityId);

        foreach ($request->price as $p) {
            Price::create([
                'commodity_id' => $commodityMarket->commodity_id,
                'market_id'    => $commodityMarket->market_id,
                'user_id'      => auth()->id(),
                'price'        => $p,
                'date'         => $request->price_date,
            ]);
        }

        return back()->with('success', 'Harga berhasil ditambahkan!');
    }

    public function update(Request $request, $pivotId)
    {
        $request->validate([
            'price_date' => 'required|date',
            'price' => 'required|array|min:1',
            'price.*' => 'required|numeric|min:0',
            'market_id' => 'required|integer',
        ]);

        $pivot = CommodityMarket::findOrFail($pivotId);
        $commodityId = $pivot->commodity_id;
        $marketId = $request->market_id;
        $date = $request->price_date;

        // Hapus harga lama
        Price::where('commodity_id', $commodityId)
            ->where('market_id', $marketId)
            ->where('date', $date)
            ->delete();

        // Simpan harga baru
        foreach ($request->price as $price) {
            Price::create([
                'commodity_id' => $commodityId,
                'market_id' => $marketId,
                'user_id' => auth()->id(),
                'price' => $price,
                'date' => $date,
            ]);
        }

        return redirect()->back()->with('success', 'Harga berhasil diupdate.');
    }
}
