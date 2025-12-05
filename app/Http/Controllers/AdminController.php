<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Commodity;
use App\Models\CommodityMarket;
use App\Models\Market;
use App\Models\Price;
use App\Models\Unit;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
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

    public function dashboard(Request $request)
    {
        $marketId = auth()->user()->market_id;

        // Kalau user pilih tanggal → pakai itu, kalau tidak → pakai hari ini
        $selectedDate = $request->tanggal ?? now()->toDateString();
        $yesterday = now()->subDay()->toDateString();

        // ====== AMBIL KOMODITAS SESUAI MARKET ======
        $commodities = Commodity::whereHas('commodityMarkets', function ($q) use ($marketId) {
            $q->where('market_id', $marketId)->where('status', 'aktif');
        })
            ->with([
                'commodityMarkets' => function ($q) use ($marketId) {
                    $q->where('market_id', $marketId);
                },
                'commodityMarkets.prices' => function ($q) use ($selectedDate, $yesterday) {
                    $q->whereIn('date', [$selectedDate, $yesterday]);
                },
                'unit'
            ])
            ->get();

        // ====== SUDAH UPDATE HARI INI ======
        $latestPrices = $commodities->filter(function ($item) use ($selectedDate) {
            $pivot = $item->commodityMarkets->first();
            return optional(optional($pivot)->prices)
                ->where('date', $selectedDate)
                ->first();
        });

        // ====== BELUM UPDATE HARI INI ======
        $belumUpdate = $commodities->filter(function ($item) use ($selectedDate) {
            $pivot = $item->commodityMarkets->first();
            return !optional(optional($pivot)->prices)
                ->where('date', $selectedDate)
                ->first();
        });

        return view('dashboardAdmin.dashboard', [
            'latestPrices' => $latestPrices,
            'belumUpdate' => $belumUpdate,
            'selectedDate' => $selectedDate,
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $pivot = CommodityMarket::findOrFail($id);

        $pivot->status = $request->status;
        $pivot->save();

        return response()->json(['success' => true]);
    }

    public function komoditas(Request $request, $filter = 'all')
    {
        $marketId = auth()->user()->market_id;

        // Tanggal dipilih user
        $selectedDate = $request->tanggal ?? now()->toDateString();

        $commodities = Commodity::whereHas('commodityMarkets', function ($q) use ($marketId) {
            $q->where('market_id', $marketId)
                ->where('status', 'aktif');
        })
            ->with(['commodityMarkets' => function ($q) use ($marketId) {
                $q->where('market_id', $marketId);
            }, 'category', 'unit'])
            ->get();

        // ========== FILTER KATEGORI ==========
        if ($request->kategori && $request->kategori != '#') {
            $commodities = $commodities->where('category_id', $request->kategori);
        }

        // ========== HITUNG TOTAL ==========
        $countAll = $commodities->count();

        $countSudah = $commodities->filter(function ($item) use ($selectedDate) {
            $pivot = $item->commodityMarkets->first();
            return optional(optional($pivot)->prices)
                ->where('date', $selectedDate)
                ->first();
        })->count();

        $countBelum = $commodities->filter(function ($item) use ($selectedDate) {
            $pivot = $item->commodityMarkets->first();
            return !optional(optional($pivot)->prices)
                ->where('date', $selectedDate)
                ->first();
        })->count();

        // ========== FILTER STATUS (TAB) ==========
        $filtered = $commodities->filter(function ($item) use ($filter, $selectedDate) {
            $pivot = $item->commodityMarkets->first();
            $price = optional(optional($pivot)->prices)
                ->where('date', $selectedDate)
                ->first();

            if ($filter === 'belum-update') return !$price;
            if ($filter === 'sudah-update') return $price;
            return true;
        });

        $category = Category::all();

        return view('dashboardAdmin.komoditas', [
            'commodities' => $filtered,
            'activeFilter' => $filter,
            'countAll' => $countAll,
            'countSudah' => $countSudah,
            'countBelum' => $countBelum,
            'category' => $category,
            'selectedDate' => $selectedDate,
        ]);
    }


    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'pivotId' => 'required|integer|exists:commodity_markets,id',
            'commodityId' => 'required',
            'price'       => 'required|array',
            'price.*'     => 'required|numeric',
            'price_date'  => 'required|date',
        ]);

        $pivot = CommodityMarket::findOrFail($request->pivotId);

        foreach ($request->price as $p) {
            Price::create([
                'commodity_id' => $pivot->commodity_id,
                'market_id'    => $pivot->market_id,
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
