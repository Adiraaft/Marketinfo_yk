<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Category;
use App\Models\Commodity;
use App\Models\Market; // <- WAJIB
use App\Models\Price;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class PublicBeritaController extends Controller
{
    // Halaman daftar berita
    public function indexBerita()
    {
        $berita = Berita::latest()->paginate(9);
        return view('berita.berita', compact('berita'));
    }

    // Detail berita
    public function detail($id)
    {
        $news = Berita::findOrFail($id);
        return view('berita.detailberita', compact('news'));
    }

    // Halaman Home
    public function indexHome(Request $request)
    {
        // =============================
        // DATA UMUM (WAJIB DI HOME)
        // =============================
        $latest  = Berita::latest()->first();
        $others  = Berita::latest()->skip(1)->take(3)->get();
        $berita  = Berita::latest()->paginate(6);
        $markets = Market::where('status', 'aktif')->get();
        $categories = Category::all();
        $unit = Unit::all();

        $commoditiesDropdown = Commodity::select(
            'id_commodity',
            'name_commodity',
            'category_id'
        )->get();

        // =============================
        // PARAMETER
        // =============================
        $commodityId = $request->commodity;
        $marketRaw   = $request->market;
        $trend       = $request->get('trend', 'all');

        $isAvgMarket    = !$marketRaw || $marketRaw === 'avg';
        $isAllMarket    = $marketRaw === 'all';
        $isSingleMarket = is_numeric($marketRaw);
        $marketId       = $isSingleMarket ? (int)$marketRaw : null;

        // =============================
        // MODE
        // =============================
        if (!$commodityId && $isAvgMarket) {
            $mode = 'ALL_AVG';
            $commodities = $this->allAvg();
        } elseif ($commodityId && $isAvgMarket) {
            $mode = 'ONE_AVG';
            $commodities = $this->oneAvg($commodityId);
        } elseif (!$commodityId && $isSingleMarket) {
            $mode = 'ALL_ONE_MARKET';
            $commodities = $this->allOneMarket($marketId);
        } elseif ($commodityId && $isAllMarket) {
            $mode = 'ONE_ALL_MARKET';
            $commodities = $this->oneAllMarket($commodityId);
        } else {
            $mode = 'ONE_ONE_MARKET';
            $commodities = $this->oneOneMarket($commodityId, $marketId);
        }

        // =============================
        // FILTER TREND (AMAN)
        // =============================
        if ($mode === 'ONE_ALL_MARKET' && in_array($trend, ['up', 'down'])) {

            $commodities = $commodities->sort(function ($a, $b) use ($trend) {

                $priceA = $a->avg_price ?? PHP_INT_MAX;
                $priceB = $b->avg_price ?? PHP_INT_MAX;

                // TERENDAH → TERTINGGI
                if ($trend === 'down') {
                    return $priceA <=> $priceB;
                }

                // TERTINGGI → TERENDAH
                return $priceB <=> $priceA;
            })->values();
        }


        // =============================
        // PAGINATION
        // =============================
        $page = request('page', 1);
        $perPage = 9;

        $commodities = new LengthAwarePaginator(
            $commodities->forPage($page, $perPage),
            $commodities->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('home.index', compact(
            'categories',
            'commoditiesDropdown',
            'unit',
            'commodities',
            'latest',
            'others',
            'berita',
            'markets',
            'mode'
        ));
    }

    private function getAvgChart($commodityId)
    {
        return DB::table('prices')
            ->selectRaw('date, ROUND(AVG(price)) as avg_price')
            ->where('commodity_id', $commodityId)
            ->whereBetween('date', [
                now()->subDays(6)->toDateString(),
                now()->toDateString()
            ])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(fn($r) => [
                'x' => $r->date,
                'y' => (int) $r->avg_price
            ]);
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

    private function allAvg()
    {
        return Cache::remember('home_all_avg', 60, function () {

            $commodities = Commodity::orderBy('id_commodity')->get();

            $latestDates = DB::table('prices')
                ->selectRaw('commodity_id, MAX(date) as date')
                ->groupBy('commodity_id');

            $latestPrices = DB::table('prices as p')
                ->joinSub($latestDates, 'ld', function ($j) {
                    $j->on('p.commodity_id', '=', 'ld.commodity_id')
                        ->on('p.date', '=', 'ld.date');
                })
                ->selectRaw('p.commodity_id, ROUND(AVG(p.price)) as avg_price, ld.date')
                ->groupBy('p.commodity_id', 'ld.date')
                ->get()
                ->keyBy('commodity_id');

            $chartRows = DB::table('prices as p')
                ->join(
                    DB::raw('(
                        SELECT commodity_id, date
                        FROM prices
                        ORDER BY date DESC
                    ) as t'),
                    function ($join) {
                        $join->on('p.commodity_id', '=', 't.commodity_id')
                            ->on('p.date', '=', 't.date');
                    }
                )
                ->selectRaw('p.commodity_id, p.date, ROUND(AVG(p.price)) as price')
                ->groupBy('p.commodity_id', 'p.date')
                ->orderBy('p.date')
                ->get()
                ->groupBy('commodity_id')
                ->map(fn($rows) => $rows->take(-7)->values());



            foreach ($commodities as $c) {

                // IMAGE
                $c->image_url = $c->image
                    ? asset('storage/commodity_images/' . $c->image)
                    : asset('images/no-image.png');

                // HARGA TERAKHIR
                $latest = $latestPrices[$c->id_commodity] ?? null;
                $c->avg_price  = $latest->avg_price ?? null;
                $c->price_date = $latest->date ?? null;

                // CHART
                $chart = $chartRows[$c->id_commodity] ?? collect();
                $c->chart_prices = $chart->map(fn($r) => [
                    'x' => $r->date,
                    'y' => (int) $r->price
                ])->values();

                // TREND + DIFF + PERCENT
                if ($c->chart_prices->count() >= 2) {
                    $first = $c->chart_prices->first()['y'];
                    $last  = $c->chart_prices->last()['y'];

                    $diff = $last - $first;

                    $c->trend = $diff > 0 ? 'up' : ($diff < 0 ? 'down' : 'flat');
                    $c->price_diff = abs($diff);
                    $c->price_percent = $first > 0
                        ? round(abs($diff / $first) * 100, 1)
                        : 0;
                } else {
                    $c->trend = 'flat';
                    $c->price_diff = null;
                    $c->price_percent = null;
                }
            }

            return $commodities;
        });
    }

    private function oneAvg($commodityId)
    {
        return $this->allAvg()
            ->where('id_commodity', $commodityId)
            ->values();
    }

    private function allOneMarket($marketId)
    {
        return Cache::remember("home_market_$marketId", 60, function () use ($marketId) {

            $commodities = Commodity::with('unit')->get();

            // ambil tanggal terbaru per komoditas DI PASAR INI
            $latestDates = DB::table('prices')
                ->where('market_id', $marketId)
                ->selectRaw('commodity_id, MAX(date) as date')
                ->groupBy('commodity_id');

            $latestPrices = DB::table('prices as p')
                ->joinSub($latestDates, 'ld', function ($j) {
                    $j->on('p.commodity_id', '=', 'ld.commodity_id')
                        ->on('p.date', '=', 'ld.date');
                })
                ->where('p.market_id', $marketId)
                ->selectRaw('p.commodity_id, ROUND(AVG(p.price)) as price, ld.date')
                ->groupBy('p.commodity_id', 'ld.date')
                ->get()
                ->keyBy('commodity_id');

            $chartRows = DB::table('prices')
                ->where('market_id', $marketId)
                ->whereBetween('date', [
                    now()->subDays(6)->toDateString(),
                    now()->toDateString()
                ])
                ->selectRaw('commodity_id, date, ROUND(AVG(price)) as price')
                ->groupBy('commodity_id', 'date')
                ->orderBy('date')
                ->get()
                ->groupBy('commodity_id');

            foreach ($commodities as $c) {

                $c->market_id = $marketId;

                $latest = $latestPrices[$c->id_commodity] ?? null;
                // IMAGE
                $c->image_url = $c->image
                    ? asset('storage/commodity_images/' . $c->image)
                    : asset('images/no-image.png');

                // HARGA MARKET (BUKAN AVG)
                $c->market_price = $latest->price ?? null;
                $c->price_date   = $latest->date ?? null;

                // chart
                $chart = $chartRows[$c->id_commodity] ?? collect();
                $c->chart = $chart->map(fn($r) => [
                    'x' => $r->date,
                    'y' => (int) $r->price
                ])->values();

                // TREND + DIFF
                $lastTwo = $c->chart->take(-2)->values();

                if ($lastTwo->count() === 2) {
                    $prev = $lastTwo[0]['y'];
                    $last = $lastTwo[1]['y'];

                    $diff = $last - $prev;

                    $c->trend = $diff > 0 ? 'up' : ($diff < 0 ? 'down' : 'flat');
                    $c->price_diff = abs($diff);
                    $c->price_percent = $prev > 0
                        ? round(abs($diff / $prev) * 100, 1)
                        : 0;
                } else {
                    $c->trend = 'flat';
                    $c->price_diff = null;
                    $c->price_percent = null;
                }
            }

            return $commodities;
        });
    }

    private function oneOneMarket($commodityId, $marketId)
    {
        return $this->allOneMarket($marketId)
            ->where('id_commodity', $commodityId)
            ->values();
    }

    private function oneAllMarket($commodityId)
    {
        $commodity = Commodity::with('unit')->findOrFail($commodityId);

        $imageUrl = $commodity->image
            ? asset('storage/commodity_images/' . $commodity->image)
            : asset('images/no-image.png');

        $markets = Market::where('status', 'aktif')->get();

        $cards = collect();

        foreach ($markets as $m) {

            $latestDate = DB::table('prices')
                ->where('commodity_id', $commodityId)
                ->where('market_id', $m->id_market)
                ->max('date');

            $price = 0;
            $chart = collect();

            if ($latestDate) {
                $price = DB::table('prices')
                    ->where('commodity_id', $commodityId)
                    ->where('market_id', $m->id_market)
                    ->where('date', $latestDate)
                    ->avg('price');

                $chart = $this->getChart($commodityId, $m->id_market);
            }

            $trend = 'flat';

            if ($chart->count() >= 2) {
                $first = $chart->first()['y'];
                $last  = $chart->last()['y'];

                if ($last > $first) $trend = 'up';
                elseif ($last < $first) $trend = 'down';
            }

            $cards->push((object)[
                'id_commodity' => $commodity->id_commodity,
                'market_id'    => $m->id_market,

                'name_commodity' => $commodity->name_commodity,
                'image_url'      => $imageUrl,
                'unit'           => $commodity->unit,

                'market_name'    => $m->market_name = $m->name_market ?? '-',

                'avg_price'   => $price,
                'price_date'     => $latestDate,
                'chart'          => $chart,

                'trend'          => $trend,
            ]);
        }

        return $cards;
    }

    public function getComparisonData(Request $request)
    {
        $commodityId = $request->commodity_id;
        $marketIds = $request->market_ids;
        $dateFrom = $request->date_from ?? now()->subDays(6)->toDateString();
        $dateTo = $request->date_to ?? now()->toDateString();

        // Validation
        if (!$commodityId || !$marketIds || !is_array($marketIds) || count($marketIds) < 2) {
            return response()->json([
                'success' => false,
                'error' => 'Pilih minimal 2 pasar dan 1 komoditas'
            ], 400);
        }

        try {
            $commodity = Commodity::with('unit')->findOrFail($commodityId);

            $comparisonData = [];

            foreach ($marketIds as $marketId) {
                $market = Market::findOrFail($marketId);

                // Ambil harga terbaru dalam range tanggal
                $latestDate = DB::table('prices')
                    ->where('commodity_id', $commodityId)
                    ->where('market_id', $marketId)
                    ->whereBetween('date', [$dateFrom, $dateTo])
                    ->max('date');

                $latestPrice = null;
                if ($latestDate) {
                    $latestPrice = DB::table('prices')
                        ->where('commodity_id', $commodityId)
                        ->where('market_id', $marketId)
                        ->where('date', $latestDate)
                        ->value('price');
                }

                // Ambil data chart dalam range tanggal
                $chartData = DB::table('prices')
                    ->select('date', 'price')
                    ->where('commodity_id', $commodityId)
                    ->where('market_id', $marketId)
                    ->whereBetween('date', [$dateFrom, $dateTo])
                    ->orderBy('date')
                    ->get()
                    ->map(fn($r) => [
                        'x' => $r->date,
                        'y' => (int) $r->price
                    ])
                    ->values()
                    ->toArray();

                $comparisonData[] = [
                    'market_id' => $marketId,
                    'market_name' => $market->name_market,
                    'latest_price' => (int) $latestPrice,
                    'latest_date' => $latestDate,
                    'chart_data' => $chartData
                ];
            }

            return response()->json([
                'success' => true,
                'commodity_name' => $commodity->name_commodity,
                'unit' => $commodity->unit->unit_name ?? 'kg',
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'markets' => $comparisonData
            ]);
        } catch (\Exception $e) {
            \Log::error('Comparison Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function detailCommodity(Request $request, $commodityId)
    {
        // dd($request->all());
        $marketId = $request->query('market');

        $markets = Market::where('status', 'aktif')->get();
        $commodity = Commodity::with('unit')->findOrFail($commodityId);

        $chartQuery = Price::where('commodity_id', $commodityId);

        if ($marketId) {
            // 1 komoditas - 1 market
            $prices = Price::where('commodity_id', $commodityId)
                ->where('market_id', $marketId)
                ->selectRaw('date, ROUND(AVG(price)) as price')
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            $market = Market::find($marketId);
            $marketName = $market->name_market ?? 'Pasar';
        } else {
            // rata-rata semua market
            $prices = Price::where('commodity_id', $commodityId)
                ->selectRaw('date, AVG(price) as price')
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            $market = null;
            $marketName = 'Rata-rata Semua Pasar';
        }

        // ⬅️ INI YANG KAMU BUTUH
        $priceToday = $prices->sortByDesc('date')->first();

        $chartQuery = Price::where('commodity_id', $commodityId);
        if ($marketId) {
            $chartQuery->where('market_id', $marketId);
        }
        $chart = $chartQuery->orderBy('date', 'desc')
            ->limit(7)
            ->get()
            ->reverse() // urut ASC
            ->map(fn($r) => ['x' => $r->date, 'y' => (int)$r->price])
            ->values();

        // trend, diff, percent
        $trend   = 'flat';
        $diff    = 0;
        $percent = 0;

        if ($prices->count() >= 2) {
            $latest     = $prices->last();
            $previous   = $prices[$prices->count() - 2];

            $diff = $latest->price - $previous->price;

            if ($previous->price > 0) {
                $percent = round(($diff / $previous->price) * 100, 1);
            }

            $trend = $diff > 0 ? 'up' : ($diff < 0 ? 'down' : 'flat');
        }

        return view('komoditas.detailkomoditas', compact(
            'commodity',
            'prices',
            'market',
            'markets',
            'marketName',
            'priceToday',
            'trend',
            'diff',
            'percent',
            'chart'
        ));
    }

    public function getChartData(Request $request, $commodityId)
    {
        $days = $request->query('days', 7); // default 7 hari
        $marketId = $request->query('market', 'all');

        $query = Price::where('commodity_id', $commodityId);

        if ($marketId !== 'all') {
            $query->where('market_id', $marketId);
        }

        $startDate = now()->subDays($days)->toDateString();

        $prices = $query->where('date', '>=', $startDate)
            ->orderBy('date')
            ->get();

        // Jika pilih all market, rata-rata harga per tanggal
        if ($marketId === 'all') {
            $prices = $prices->groupBy('date')->map(function ($group) {
                return [
                    'date' => $group->first()->date,
                    'price' => round($group->avg('price'))
                ];
            })->values();
        } else {
            // Single market: ambil harga rata-rata per tanggal jika ada multiple entry
            $prices = $prices->groupBy('date')->map(function ($group) {
                return [
                    'date' => $group->first()->date,
                    'price' => round($group->avg('price'))
                ];
            })->values();
        }

        return response()->json([
            'success' => true,
            'data' => $prices
        ]);
    }
}
