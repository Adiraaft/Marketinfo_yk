<?php

namespace App\Http\Controllers;

use App\Models\Commodity;
use App\Models\CommodityMarket;
use App\Models\Market;
use App\Models\Category;
use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

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

        // Insert otomatis ke tabel commodity_market
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
            // Hapus gambar lama jika ada
            if ($market->image) {
                Storage::disk('public')->delete($market->image);
            }
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

    /**
     * Detail pasar dengan daftar komoditas yang tersedia di pasar tersebut
     */
    public function detail($id)
    {
        $market = Market::findOrFail($id);
        $categories = Category::all();

        $commoditiesDropdown = Commodity::whereHas('commodityMarkets', function ($q) use ($id) {
            $q->where('market_id', $id)->where('status', 'aktif');
        })->with('category')->get();

        // Ambil komoditas yang aktif di pasar ini
        $commodities = Commodity::whereHas('commodityMarkets', function ($q) use ($id) {
            $q->where('market_id', $id)->where('status', 'aktif');
        })
        ->with(['unit', 'category'])
        ->get();

        // 🔥 ambil tanggal terbaru per komoditas
        $latestDates = DB::table('prices')
            ->where('market_id', $id)
            ->selectRaw('commodity_id, MAX(date) as date')
            ->groupBy('commodity_id');

        // 🔥 ambil harga terbaru (AVG jika ada lebih dari 1)
        $latestPrices = DB::table('prices as p')
            ->joinSub($latestDates, 'ld', function ($j) {
                $j->on('p.commodity_id', '=', 'ld.commodity_id')
                ->on('p.date', '=', 'ld.date');
            })
            ->where('p.market_id', $id)
            ->selectRaw('p.commodity_id, ROUND(AVG(p.price)) as price, ld.date')
            ->groupBy('p.commodity_id', 'ld.date')
            ->get()
            ->keyBy('commodity_id');

        foreach ($commodities as $c) {

            $c->market_id = $id;
            $c->market_name = null;

            // IMAGE
            $c->image_url = $c->image
                ? asset('storage/commodity_images/' . $c->image)
                : asset('images/no-image.png');

            // HARGA TERBARU
            $latest = $latestPrices[$c->id_commodity] ?? null;
            $c->market_price = $latest->price ?? null;
            $c->price_date   = $latest->date ?? null;

            // 🔥 WAJIB: chart format {x,y}
            $chart = $this->getChart($c->id_commodity, $id);
            $c->chart = $chart;

            // 🔥 TREND SAMA PERSIS
            $c->trend = $this->calcTrend($chart);

            if ($chart->count() >= 2) {
                $first = $chart->first()['y'];
                $last  = $chart->last()['y'];

                $diff = $last - $first;

                $c->price_diff = abs($diff);
                $c->price_percent = $first > 0
                    ? round(abs($diff / $first) * 100, 1)
                    : 0;
            } else {
                $c->price_diff = null;
                $c->price_percent = null;
            }
        }

        // pagination manual (sama seperti sebelumnya)
        $page = request('page', 1);
        $perPage = 9;
        $total = $commodities->count();

        $commodities = new \Illuminate\Pagination\LengthAwarePaginator(
            $commodities->forPage($page, $perPage),
            $total,
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('pasar.detailpasar', compact(
            'market',
            'categories',
            'commoditiesDropdown',
            'commodities'
        ));
    }

    private function getChart($commodityId, $marketId = null)
    {
        $q = DB::table('prices')
            ->where('commodity_id', $commodityId);

        if ($marketId !== null) {
            $q->where('market_id', $marketId);
        }

        return $q->selectRaw('date, ROUND(AVG(price)) as price')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(7)
            ->get()
            ->reverse()
            ->map(fn($r) => [
                'x' => $r->date,
                'y' => (int) $r->price
            ])
            ->values();
    }

    private function calcTrend($chart)
    {
        if ($chart->count() < 2) {
            return 'flat';
        }

        $first = $chart->first()['y'];
        $last  = $chart->last()['y'];

        if ($last > $first) return 'up';
        if ($last < $first) return 'down';
        return 'flat';
    }

    private function calcDiffPercent($chart)
    {
        if ($chart->count() < 2) {
            return [null, null];
        }

        $first = $chart->first()['y'];
        $last  = $chart->last()['y'];

        if ($first <= 0) {
            return [null, null];
        }

        $diff = $last - $first;
        $percent = ($diff / $first) * 100;

        return [
            abs(round($diff)),
            round(abs($percent), 1)
        ];
    }


    public function home()
    {
        $markets = Market::where('status', 'aktif')->get();
        return view('home.index', compact('markets'));
    }
}