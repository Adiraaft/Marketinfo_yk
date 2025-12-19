<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Category;
use App\Models\Commodity;
use App\Models\CommodityMarket;
use App\Models\Market; // <- WAJIB
use App\Models\Price;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

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
        // Ambil data berita
        $latest = Berita::latest()->first();
        $others = Berita::latest()->skip(1)->take(3)->get();
        $berita = Berita::latest()->paginate(6);

        // Ambil semua pasar aktif
        $markets = Market::where('status', 'aktif')->get();

        // Ambil seluruh kategori
        $categories = Category::all();

        $unit = Unit::all();

        $commoditiesDropdown = Commodity::select(
            'id_commodity',
            'name_commodity',
            'category_id'
        )->get();

        $today = now()->toDateString();

        $commodityId = $request->commodity;  // null | id
        $marketRaw    = $request->market;  // null / id
        $trend       = $request->get('trend', 'all');  // all | up | down

        $isAvgMarket    = !$marketRaw || $marketRaw === 'avg';
        $isAllMarket    = $marketRaw === 'all';
        $isSingleMarket = is_numeric($marketRaw);

        $marketId = $isSingleMarket ? (int) $marketRaw : null;
        $commodities = collect();

        // ============================
        // MODE VIEW
        // ============================
        if (!$commodityId && $isAvgMarket) {
            $mode = 'ALL_AVG'; // semua komoditas + avg kota
        } elseif ($commodityId && $isAvgMarket) {
            $mode = 'ONE_AVG'; // 1 komoditas + avg kota
        } elseif (!$commodityId && $isSingleMarket) {
            $mode = 'ALL_ONE_MARKET'; // semua komoditas + 1 pasar
        } elseif ($commodityId && $isAllMarket) {
            $mode = 'ONE_ALL_MARKET'; // 1 komoditas + semua pasar
        } elseif ($commodityId && is_numeric($marketRaw)) {
            $mode = 'ONE_ONE_MARKET';
        }

        if (!$commodityId && $isAvgMarket) {

            // Semua pasar
            $commodities = Commodity::with(['prices' => function ($q) {
                $q->orderBy('date', 'desc');
            }])
                ->orderBy('id_commodity')
                ->get();


            foreach ($commodities as $item) {

                // Image
                if ($item->image) {
                    $item->image_url = asset('storage/commodity_images/' . $item->image);
                } else {
                    $item->image_url = asset('images/no-image.png');
                }

                /**
                 * 1. Ambil TANGGAL TERBARU untuk komoditas ini
                 */
                $latestDate = DB::table('prices')
                    ->where('commodity_id', $item->id_commodity)
                    ->max('date');
                /**
                 * 2. Ambil harga di TANGGAL TERSEBUT SAJA
                 */
                $prices = DB::table('prices')
                    ->where('commodity_id', $item->id_commodity)
                    ->whereDate('date', $latestDate)
                    ->pluck('price');
                /**
                 * 3. Hitung rata-rata
                 */
                if ($prices->count() > 0) {
                    $item->avg_price = round($prices->avg());
                    $item->price_date = $latestDate;
                } else {
                    $item->avg_price = null;
                    $item->price_date = null;
                }

                // Ambil tanggal sebelumnya (AMAN dari NULL)
                if ($item->price_date) {

                    $previousDate = DB::table('prices')
                        ->where('commodity_id', $item->id_commodity)
                        ->whereDate('date', '<', $item->price_date)
                        ->max('date');

                    if ($previousDate) {

                        $prevPrices = DB::table('prices')
                            ->where('commodity_id', $item->id_commodity)
                            ->whereDate('date', $previousDate)
                            ->pluck('price');

                        if ($prevPrices->count() > 0) {
                            $prevAvg = $prevPrices->avg();

                            $diff = $item->avg_price - $prevAvg;
                            $percent = ($diff / $prevAvg) * 100;

                            $item->price_diff = round(abs($diff));
                            $item->price_percent = round(abs($percent), 1);

                            if ($diff > 0) {
                                $item->trend = 'up';
                            } elseif ($diff < 0) {
                                $item->trend = 'down';
                            } else {
                                $item->trend = 'same';
                            }
                        }
                    }
                } else {
                    // Jika belum ada harga sama sekali
                    $item->trend = null;
                    $item->price_diff = null;
                    $item->price_percent = null;
                }


                $rawChart = DB::table('prices')
                    ->selectRaw('date, ROUND(AVG(price)) as avg_price')
                    ->where('commodity_id', $item->id_commodity)
                    ->whereBetween('date', [
                        now()->subDays(6)->toDateString(),
                        now()->toDateString()
                    ])
                    ->groupBy('date')
                    ->orderBy('date')
                    ->pluck('avg_price', 'date');

                // isi default 7 hari
                $prices = [];

                for ($i = 6; $i >= 0; $i--) {
                    $date = now()->subDays($i)->toDateString();

                    if (isset($rawChart[$date])) {
                        $prices[] = [
                            'x' => $date,
                            'y' => (int) $rawChart[$date],
                        ];
                    }
                }

                // ❗ WAJIB: minimal 2 titik data valid
                $item->chart_prices = count($prices) >= 2 ? $prices : [];
            }
        } elseif ($commodityId && $isAllMarket) {

            $commodityMarkets = CommodityMarket::with(['market', 'commodity'])
                ->where('commodity_id', $commodityId)
                ->where('status', 'aktif')
                ->get();

            $commodities = collect();

            foreach ($commodityMarkets as $cm) {

                $item = new \stdClass();
                $item->id_commodity = $cm->id_commodity;
                $item->name_commodity = $cm->commodity->name_commodity;
                $item->image_url = $cm->commodity->image
                    ? asset('storage/commodity_images/' . $cm->commodity->image)
                    : asset('images/no-image.png');

                // Ambil semua harga untuk pasar ini (object lengkap)
                $marketPrices = DB::table('prices')
                    ->where('commodity_id', $cm->commodity_id)
                    ->where('market_id', $cm->market_id)
                    ->orderBy('date', 'desc')
                    ->get();

                // Ambil tanggal terbaru
                $latestDate = $marketPrices->max('date');

                // Ambil harga hari terbaru (rata-rata)
                $todayPrices = $marketPrices->where('date', $latestDate)->pluck('price');
                $avgPriceToday = $todayPrices->count() ? round($todayPrices->avg()) : null;

                // Buat market item
                $marketItem = new \stdClass();
                $marketItem->market_name = $cm->market->name_market;
                $marketItem->avg_price = $avgPriceToday;
                $marketItem->price_date = $latestDate;

                // Tambahkan ke array market_prices
                if (!isset($item->market_prices)) $item->market_prices = collect();
                $item->market_prices->push($marketItem);

                // Hitung tren dengan harga hari sebelumnya
                $prevDate = $marketPrices->where('date', '<', $latestDate)->max('date');
                if ($prevDate) {
                    $prevPrices = $marketPrices->where('date', $prevDate)->pluck('price');
                    if ($prevPrices->count() > 0) {
                        $diff = $avgPriceToday - $prevPrices->avg();
                        $percent = ($diff / $prevPrices->avg()) * 100;

                        $item->price_diff = round(abs($diff));
                        $item->price_percent = round(abs($percent), 1);
                        $item->trend = $diff > 0 ? 'up' : ($diff < 0 ? 'down' : 'same');
                    }
                }

                $rawChart = DB::table('prices')
                    ->selectRaw('date, ROUND(AVG(price)) as avg_price')
                    ->where('commodity_id', $cm->commodity_id)
                    ->where('market_id', $cm->market_id)
                    ->whereBetween('date', [
                        now()->subDays(6)->toDateString(),
                        now()->toDateString()
                    ])
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get();

                $marketItem->chart = $rawChart->count() >= 2
                    ? $rawChart->map(fn($r) => [
                        'x' => $r->date,
                        'y' => (int)$r->avg_price,
                    ])->values()
                    : collect();

                $commodities->push($item);
            }
        } elseif (!$commodityId && $isSingleMarket) {

            $commodities = Commodity::all();

            foreach ($commodities as $item) {

                // IMAGE
                $item->image_url = $item->image
                    ? asset('storage/commodity_images/' . $item->image)
                    : asset('images/no-image.png');

                // TANGGAL TERBARU
                $latestDate = DB::table('prices')
                    ->where('commodity_id', $item->id_commodity)
                    ->where('market_id', $marketId)
                    ->max('date');

                if (!$latestDate) {
                    $item->market_price = null;
                    $item->chart_prices = [];
                    continue;
                }

                // HARGA MARKET (BUKAN AVG)
                $item->market_price = DB::table('prices')
                    ->where('commodity_id', $item->id_commodity)
                    ->where('market_id', $marketId)
                    ->whereDate('date', $latestDate)
                    ->value('price');

                $item->price_date = $latestDate;

                // ===== TREND =====
                $previousDate = DB::table('prices')
                    ->where('commodity_id', $item->id_commodity)
                    ->where('market_id', $marketId)
                    ->whereDate('date', '<', $latestDate)
                    ->max('date');

                if ($previousDate) {
                    $prevPrice = DB::table('prices')
                        ->where('commodity_id', $item->id_commodity)
                        ->where('market_id', $marketId)
                        ->whereDate('date', $previousDate)
                        ->value('price');

                    $diff = $item->market_price - $prevPrice;

                    $item->price_diff = abs($diff);
                    $item->price_percent = $prevPrice > 0
                        ? round(abs($diff / $prevPrice * 100), 1)
                        : 0;

                    $item->trend = $diff > 0 ? 'up' : ($diff < 0 ? 'down' : 'same');
                } else {
                    $item->trend = null;
                }

                // ===== CHART 7 HARI =====
                $rawChart = DB::table('prices')
                    ->select('date', 'price')
                    ->where('commodity_id', $item->id_commodity)
                    ->where('market_id', $marketId)
                    ->orderBy('date', 'desc')
                    ->limit(7)
                    ->get()
                    ->reverse();

                $item->chart_prices = $rawChart->count() >= 2
                    ? $rawChart->map(fn($r) => [
                        'x' => \Carbon\Carbon::parse($r->date)->toDateString(),
                        'y' => (int) $r->price,
                    ])->values()
                    : [];
            }
        } elseif ($commodityId && $isAvgMarket) {

            $item = Commodity::findOrFail($commodityId);

            $latestDate = DB::table('prices')
                ->where('commodity_id', $commodityId)
                ->max('date');

            $prices = DB::table('prices')
                ->where('commodity_id', $commodityId)
                ->whereDate('date', $latestDate)
                ->pluck('price');

            $item->avg_price = $prices->count()
                ? round($prices->avg())
                : null;

            $item->image_url = $item->image
                ? asset('storage/commodity_images/' . $item->image)
                : asset('images/no-image.png');

            $rawChart = DB::table('prices')
                ->selectRaw('date, ROUND(AVG(price)) as avg_price')
                ->where('commodity_id', $commodityId)
                ->groupBy('date')
                ->orderBy('date')
                ->limit(7)
                ->get();

            $item->chart_prices = $rawChart->count() >= 2
                ? $rawChart->map(fn($r) => [
                    'x' => \Carbon\Carbon::parse($r->date)->toDateString(),
                    'y' => (int) $r->avg_price,
                ])->values()
                : [];


            $commodities = collect([$item]);
        } elseif ($commodityId && $isSingleMarket) {

            $item = Commodity::findOrFail($commodityId);

            // IMAGE
            $item->image_url = $item->image
                ? asset('storage/commodity_images/' . $item->image)
                : asset('images/no-image.png');

            // TANGGAL TERBARU
            $latestDate = DB::table('prices')
                ->where('commodity_id', $commodityId)
                ->where('market_id', $marketId)
                ->max('date');

            if ($latestDate) {

                $item->market_price = DB::table('prices')
                    ->where('commodity_id', $commodityId)
                    ->where('market_id', $marketId)
                    ->whereDate('date', $latestDate)
                    ->value('price');

                $item->price_date = $latestDate;

                // TREND
                $previousDate = DB::table('prices')
                    ->where('commodity_id', $commodityId)
                    ->where('market_id', $marketId)
                    ->whereDate('date', '<', $latestDate)
                    ->max('date');

                if ($previousDate) {
                    $prevPrice = DB::table('prices')
                        ->where('commodity_id', $commodityId)
                        ->where('market_id', $marketId)
                        ->whereDate('date', $previousDate)
                        ->value('price');

                    $diff = $item->market_price - $prevPrice;

                    $item->price_diff = abs($diff);
                    $item->price_percent = round(abs($diff / $prevPrice * 100), 1);
                    $item->trend = $diff > 0 ? 'up' : ($diff < 0 ? 'down' : 'same');
                }
            }

            // CHART
            $rawChart = DB::table('prices')
                ->select('date', 'price')
                ->where('commodity_id', $commodityId)
                ->where('market_id', $marketId)
                ->orderBy('date', 'desc')
                ->limit(7)
                ->get()
                ->reverse();

            $item->chart_prices = $rawChart->count() >= 2
                ? $rawChart->map(fn($r) => [
                    'x' => \Carbon\Carbon::parse($r->date)->toDateString(),
                    'y' => (int) $r->price,
                ])->values()
                : [];

            $commodities = collect([$item]);
        }

        if ($commodityId && in_array($trend, ['up', 'down'])) {

            $commodities = $commodities->sortBy(function ($item) {

                // MODE MARKET → selalu pakai harga market
                if (isset($item->market_prices)) {
                    // Ambil properti avg_price dari stdClass
                    return $item->market_prices->first()->avg_price ?? 0;
                }

                // fallback (harusnya tidak kepakai)
                return $item->avg_price ?? 0;
            });

            if ($trend === 'up') {
                $commodities = $commodities->reverse();
            }
        }


        $page = request()->get('page', 1);
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
}
