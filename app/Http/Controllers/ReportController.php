<?php

namespace App\Http\Controllers;

use App\Exports\PriceExport;
use App\Models\Category;
use App\Models\Commodity;
use App\Models\Market;
use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $markets = Market::all();

        return view('dashboard.laporan', compact('categories', 'markets'));
    }
    public function indexAdmin()
    {
        $categories = Category::all();
        $markets = auth()->user()->market;

        return view('dashboardAdmin.laporan', compact('categories', 'markets'));
    }
    public function getCommoditiesByCategory($categoryId)
    {
        // pastikan $categoryId numeric
        if (!is_numeric($categoryId)) {
            return response()->json([], 400);
        }

        // Ambil komoditas yang punya category_id = id_category
        $commodities = Commodity::where('category_id', $categoryId)
            ->get(['id_commodity', 'name_commodity'])
            ->map(function ($c) {
                // ubah key id_commodity -> id supaya JS bisa pakai item.id
                return [
                    'id' => $c->id_commodity,
                    'name_commodity' => $c->name_commodity
                ];
            });

        return response()->json($commodities);
    }
    public function filter(Request $r)
    {
        $export = filter_var($r->export, FILTER_VALIDATE_BOOLEAN);
        $marketAll = ($r->market == "all");

        $query = Price::query()
            ->join('commodities', 'commodities.id_commodity', '=', 'prices.commodity_id')
            ->join('markets', 'markets.id_market', '=', 'prices.market_id')
            ->join('categories', 'categories.id_category', '=', 'commodities.category_id')
            ->join('users', 'users.id_user', '=', 'prices.user_id');

        // ===== SELECT =====
        if ($marketAll) {
            // Ketika semua pasar → HAPUS select pasar
            $query->select(
                DB::raw('DATE(prices.date) as tanggal'),
                'commodities.name_commodity as nama_commodity',
                DB::raw('ROUND(AVG(prices.price)) as harga_rata'),
                DB::raw("'Semua Pasar' as nama_pasar"), // ← di-set manual
                DB::raw("'Petugas Pasar' as admin"),
                'commodities.id_commodity'
            );
        } else {
            // Jika pasar spesifik dipilih → tampilkan nama pasar
            $query->select(
                DB::raw('DATE(prices.date) as tanggal'),
                'commodities.name_commodity as nama_commodity',
                'markets.name_market as nama_pasar',
                DB::raw('ROUND(AVG(prices.price)) as harga_rata'),
                'users.name as admin'
            );

            $query->where('markets.id_market', $r->market);
        }

        // ===== FILTER =====
        if ($r->category) {
            $query->where('commodities.category_id', $r->category);
        }

        if ($r->komoditas) {
            $query->where('commodities.id_commodity', $r->komoditas);
        }

        // ===== FILTER TANGGAL =====
        if ($r->date == 'today') {
            $query->whereDate('prices.date', today());
        } elseif ($r->date == '7days') {
            $startDate = Carbon::today()->subDays(6);
            $endDate = Carbon::today();

            // Buat array periode tanggal
            $period = [];
            for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
                $period[] = $date->format('Y-m-d');
            }

            // Ambil nama komoditas
            $commodityName = '-';
            if ($r->komoditas) {
                $commodity = \App\Models\Commodity::find($r->komoditas);
                $commodityName = $commodity?->name_commodity ?? '-';
            }

            // Ambil nama pasar
            $marketName = $marketAll ? 'Semua Pasar' : '-';
            if (!$marketAll && $r->market) {
                $market = \App\Models\Market::find($r->market);
                $marketName = $market?->name_market ?? '-';
            }

            // Ambil harga per tanggal beserta admin
            $pricesQuery = Price::query()
                ->whereBetween('prices.date', [$startDate, $endDate])
                ->when($r->komoditas, fn($q) => $q->where('prices.commodity_id', $r->komoditas))
                ->when(!$marketAll && $r->market, fn($q) => $q->where('prices.market_id', $r->market))
                ->when($r->category, fn($q) => $q->whereHas('commodity', fn($q2) => $q2->where('category_id', $r->category)));

            $prices = $pricesQuery
                ->join('users', 'users.id_user', '=', 'prices.user_id')
                ->select(
                    DB::raw('DATE(prices.date) as tanggal'),
                    DB::raw('ROUND(AVG(prices.price)) as harga_rata'),
                    DB::raw('MAX(users.name) as admin')
                )
                ->groupBy('tanggal')
                ->get()
                ->keyBy('tanggal');

            // Merge periode tanggal dengan harga
            $data = collect();
            foreach ($period as $tanggal) {
                $rowPrice = $prices[$tanggal] ?? null;
                $data->push((object)[
                    'tanggal' => $tanggal,
                    'nama_commodity' => $commodityName,
                    'nama_pasar' => $marketName,
                    'harga_rata' => $rowPrice ? $rowPrice->harga_rata : null,
                    'perubahan' => 0,
                    'admin' => $rowPrice ? ($marketAll ? 'Petugas Pasar' : $rowPrice->admin) : '-',
                ]);
            }

            // Hitung perubahan harga
            $prev = null;
            foreach ($data as $row) {
                if ($row->harga_rata === null) {
                    $row->perubahan = 0;
                } else {
                    if ($prev === null) {
                        $row->perubahan = 0;
                    } else {
                        $row->perubahan = round((($row->harga_rata - $prev) / $prev) * 100, 2);
                    }
                    $prev = $row->harga_rata;
                }
            }

            if ($export) return $data;
            return response()->json($data);
        } elseif ($r->date == '30days') {
            $startDate = Carbon::today()->subDays(29);
            $endDate = Carbon::today();

            // Buat array periode tanggal
            $period = [];
            for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
                $period[] = $date->format('Y-m-d');
            }

            // Ambil nama komoditas
            $commodityName = '-';
            if ($r->komoditas) {
                $commodity = \App\Models\Commodity::find($r->komoditas);
                $commodityName = $commodity?->name_commodity ?? '-';
            }

            // Ambil nama pasar
            $marketName = $marketAll ? 'Semua Pasar' : '-';
            if (!$marketAll && $r->market) {
                $market = \App\Models\Market::find($r->market);
                $marketName = $market?->name_market ?? '-';
            }

            // Ambil harga per tanggal beserta admin
            $pricesQuery = Price::query()
                ->whereBetween('prices.date', [$startDate, $endDate])
                ->where('prices.commodity_id', $r->komoditas);

            if (!$marketAll) {
                $pricesQuery->where('prices.market_id', $r->market);
            }
            if ($r->category) {
                $pricesQuery->whereHas('commodity', fn($q) => $q->where('category_id', $r->category));
            }


            $prices = $pricesQuery
                ->join('users', 'users.id_user', '=', 'prices.user_id')
                ->select(
                    DB::raw('DATE(prices.date) as tanggal'),
                    DB::raw('ROUND(AVG(prices.price)) as harga_rata'),
                    DB::raw('MAX(users.name) as admin') // ambil salah satu user yang input
                )
                ->groupBy('tanggal')
                ->get()
                ->keyBy('tanggal'); // jadikan key tanggal agar mudah lookup

            // Merge periode tanggal dengan harga
            $data = collect();
            foreach ($period as $tanggal) {
                $rowPrice = $prices[$tanggal] ?? null; // ambil data harga kalau ada
                $data->push((object)[
                    'tanggal' => $tanggal,
                    'nama_commodity' => $commodityName,
                    'nama_pasar' => $marketName,
                    'harga_rata' => $rowPrice ? $rowPrice->harga_rata : null,
                    'perubahan' => 0,
                    'admin' => $rowPrice ? ($marketAll ? 'Petugas Pasar' : $rowPrice->admin) : '-',
                ]);
            }

            // Hitung perubahan harga
            $prev = null;
            foreach ($data as $row) {
                if ($row->harga_rata === '-') {
                    $row->perubahan = 0;
                } else {
                    if ($prev === null || $prev === '-') {
                        $row->perubahan = 0;
                    } else {
                        $row->perubahan = round((($row->harga_rata - $prev) / $prev) * 100, 2);
                    }
                    $prev = $row->harga_rata;
                }
            }

            if ($export) return $data;
            return response()->json($data);
        } elseif ($r->date == '1year') {
            $marketAll = ($r->market == "all");

            $startMonth = Carbon::now()->subMonths(11)->startOfMonth();
            $endMonth = Carbon::now()->endOfMonth();

            // Buat array 12 bulan terakhir
            $period = [];
            for ($date = $startMonth->copy(); $date <= $endMonth; $date->addMonth()) {
                $period[] = $date->format('Y-m');
            }

            // Ambil nama komoditas
            $commodityName = '-';
            if ($r->komoditas) {
                $commodity = \App\Models\Commodity::find($r->komoditas);
                $commodityName = $commodity?->name_commodity ?? '-';
            }

            // Ambil nama pasar
            $marketName = $marketAll ? 'Semua Pasar' : '-';
            if (!$marketAll && $r->market) {
                $market = \App\Models\Market::find($r->market);
                $marketName = $market?->name_market ?? '-';
            }

            // Ambil harga per bulan beserta admin
            $pricesQuery = Price::query()
                ->whereBetween('prices.date', [$startMonth, $endMonth])
                ->when($r->komoditas, fn($q) => $q->where('prices.commodity_id', $r->komoditas))
                ->when(!$marketAll && $r->market, fn($q) => $q->where('prices.market_id', $r->market))
                ->when($r->category, fn($q) => $q->whereHas('commodity', fn($q2) => $q2->where('category_id', $r->category)));

            $prices = $pricesQuery
                ->join('users', 'users.id_user', '=', 'prices.user_id')
                ->select(
                    DB::raw("TO_CHAR(prices.date, 'YYYY-MM') as bulan"),
                    DB::raw('ROUND(AVG(prices.price)) as harga_rata'),
                    DB::raw('MAX(users.name) as admin')
                )
                ->groupBy('bulan')
                ->get()
                ->keyBy('bulan');

            // Merge periode bulan dengan harga
            $data = collect();
            foreach ($period as $bulan) {
                $rowPrice = $prices[$bulan] ?? null;
                $data->push((object)[
                    'tanggal' => $bulan,
                    'nama_commodity' => $commodityName,
                    'nama_pasar' => $marketName,
                    'harga_rata' => $rowPrice ? $rowPrice->harga_rata : null,
                    'perubahan' => 0,
                    'admin' => $rowPrice ? ($marketAll ? 'Petugas Pasar' : $rowPrice->admin) : '-',
                ]);
            }

            // Hitung perubahan harga per bulan
            $prev = null;
            foreach ($data as $row) {
                if ($row->harga_rata === null) {
                    $row->perubahan = 0;
                } else {
                    if ($prev === null) {
                        $row->perubahan = 0;
                    } else {
                        $row->perubahan = round((($row->harga_rata - $prev) / $prev) * 100, 2);
                    }
                    $prev = $row->harga_rata;
                }
            }

            if ($export) return $data;
            return response()->json($data);
        } elseif ($r->date == 'custom') {
            if ($r->start && $r->end) {
                $startDate = Carbon::parse($r->start);
                $endDate = Carbon::parse($r->end);

                // Buat array periode tanggal
                $period = [];
                for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
                    $period[] = $date->format('Y-m-d');
                }

                // Ambil nama komoditas
                $commodityName = '-';
                if ($r->komoditas) {
                    $commodity = \App\Models\Commodity::find($r->komoditas);
                    $commodityName = $commodity?->name_commodity ?? '-';
                }

                // Ambil nama pasar
                $marketName = $marketAll ? 'Semua Pasar' : '-';
                if (!$marketAll && $r->market) {
                    $market = \App\Models\Market::find($r->market);
                    $marketName = $market?->name_market ?? '-';
                }

                // Ambil harga per tanggal beserta admin
                $pricesQuery = Price::query()
                    ->whereBetween('prices.date', [$startDate, $endDate])
                    ->when($r->komoditas, fn($q) => $q->where('prices.commodity_id', $r->komoditas))
                    ->when(!$marketAll && $r->market, fn($q) => $q->where('prices.market_id', $r->market))
                    ->when($r->category, fn($q) => $q->whereHas('commodity', fn($q2) => $q2->where('category_id', $r->category)));

                $prices = $pricesQuery
                    ->join('users', 'users.id_user', '=', 'prices.user_id')
                    ->select(
                        DB::raw('DATE(prices.date) as tanggal'),
                        DB::raw('ROUND(AVG(prices.price)) as harga_rata'),
                        DB::raw('MAX(users.name) as admin')
                    )
                    ->groupBy('tanggal')
                    ->get()
                    ->keyBy('tanggal');

                // Merge periode tanggal dengan harga
                $data = collect();
                foreach ($period as $tanggal) {
                    $rowPrice = $prices[$tanggal] ?? null;
                    $data->push((object)[
                        'tanggal' => $tanggal,
                        'nama_commodity' => $commodityName,
                        'nama_pasar' => $marketName,
                        'harga_rata' => $rowPrice ? $rowPrice->harga_rata : null,
                        'perubahan' => 0,
                        'admin' => $rowPrice ? ($marketAll ? 'Petugas Pasar' : $rowPrice->admin) : '-',
                    ]);
                }

                // Hitung perubahan harga
                $prev = null;
                foreach ($data as $row) {
                    if ($row->harga_rata === null) {
                        $row->perubahan = 0;
                    } else {
                        if ($prev === null) {
                            $row->perubahan = 0;
                        } else {
                            $row->perubahan = round((($row->harga_rata - $prev) / $prev) * 100, 2);
                        }
                        $prev = $row->harga_rata;
                    }
                }

                if ($export) return $data;
                return response()->json($data);
            }
        }


        // ===== GROUP BY =====
        if ($marketAll) {
            // semua pasar → group hanya berdasarkan tanggal + komoditas
            $query->groupBy(
                DB::raw('DATE(prices.date)'),
                'commodities.id_commodity'
            );
        } else {
            // pasar tertentu → group by pasar
            $query->groupBy(
                DB::raw('DATE(prices.date)'),
                'commodities.id_commodity',
                'markets.name_market',
                'users.name'
            );
        }

        $data = $query->orderBy('tanggal', 'ASC')->get();

        // ===== HITUNG PERUBAHAN =====
        $prev = null;
        foreach ($data as $row) {
            if ($row->harga_rata === '-') {
                $row->perubahan = 0;
            } else {
                if ($prev === null || $prev === '-') {
                    $row->perubahan = 0;
                } else {
                    $row->perubahan = round((($row->harga_rata - $prev) / $prev) * 100, 2);
                }
                $prev = $row->harga_rata;
            }
        }

        if ($export) return $data;
        return response()->json($data);
    }

    public function filterAdmin(Request $r)
    {
        $export = filter_var($r->export, FILTER_VALIDATE_BOOLEAN);

        // MARKET HANYA 1 SESUAI USER LOGIN
        $marketId = auth()->user()->market_id;
        $marketAll = false; // admin TIDAK BISA pilih semua pasar


        // ============================
        // FILTER TODAY
        // ============================
        if ($r->date == 'today') {

            $today = Carbon::today()->format('Y-m-d');
            $marketName = auth()->user()->market->name_market ?? '-';

            // Ambil nama komoditas
            $commodityName = '-';
            if ($r->komoditas) {
                $commodity = \App\Models\Commodity::find($r->komoditas);
                $commodityName = $commodity?->name_commodity ?? '-';
            }

            // Ambil data harga hari ini
            $price = Price::query()
                ->whereDate('prices.date', $today)
                ->where('prices.market_id', $marketId)
                ->when($r->komoditas, fn($q) => $q->where('prices.commodity_id', $r->komoditas))
                ->when($r->category, fn($q) => $q->whereHas(
                    'commodity',
                    fn($q2) =>
                    $q2->where('category_id', $r->category)
                ))
                ->join('users', 'users.id_user', '=', 'prices.user_id')
                ->select(
                    DB::raw("DATE(prices.date) as tanggal"),
                    DB::raw("ROUND(AVG(prices.price)) as harga_rata"),
                    DB::raw("MAX(users.name) as admin")
                )
                ->groupBy('tanggal')
                ->first();

            // Jika tidak ada harga → tetap tampil dengan '-'
            $data = [
                (object)[
                    'tanggal'       => $today,
                    'nama_commodity' => $commodityName,
                    'nama_pasar'    => $marketName,
                    'harga_rata'    => $price->harga_rata ?? null,
                    'perubahan'     => 0,
                    'admin'         => $price->admin ?? '-',
                ]
            ];

            if ($export) return collect($data);
            return response()->json($data);
        }

        // =====================================================================
        // KHUSUS FILTER 7 DAYS
        // =====================================================================
        if ($r->date == '7days') {

            $startDate = Carbon::today()->subDays(6);
            $endDate = Carbon::today();

            // generate array tanggal
            $period = [];
            for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
                $period[] = $date->format('Y-m-d');
            }

            // nama komoditas
            $commodityName = '-';
            if ($r->komoditas) {
                $commodity = Commodity::find($r->komoditas);
                $commodityName = $commodity?->name_commodity ?? '-';
            }

            // nama pasar otomatis
            $marketName = Market::find($marketId)?->name_market ?? '-';

            // AMBIL HARGA
            $pricesQuery = Price::query()
                ->whereBetween('prices.date', [$startDate, $endDate])
                ->where('prices.market_id', $marketId)
                ->when($r->komoditas, fn($q) => $q->where('prices.commodity_id', $r->komoditas))
                ->when($r->category, fn($q) => $q->whereHas('commodity', fn($q2) => $q2->where('category_id', $r->category)));

            $prices = $pricesQuery
                ->join('users', 'users.id_user', '=', 'prices.user_id')
                ->select(
                    DB::raw('DATE(prices.date) as tanggal'),
                    DB::raw('ROUND(AVG(prices.price)) as harga_rata'),
                    DB::raw('MAX(users.name) as admin')
                )
                ->groupBy('tanggal')
                ->get()
                ->keyBy('tanggal');

            // MERGE
            $data = collect();
            foreach ($period as $tanggal) {
                $rowPrice = $prices[$tanggal] ?? null;
                $data->push((object)[
                    'tanggal' => $tanggal,
                    'nama_commodity' => $commodityName,
                    'nama_pasar' => $marketName,
                    'harga_rata' => $rowPrice->harga_rata ?? null,
                    'perubahan' => 0,
                    'admin' => $rowPrice->admin ?? '-'
                ]);
            }

            // HITUNG PERUBAHAN
            $prev = null;
            foreach ($data as $row) {
                if ($row->harga_rata === null) {
                    $row->perubahan = 0;
                } else {
                    if ($prev === null) {
                        $row->perubahan = 0;
                    } else {
                        $row->perubahan = round((($row->harga_rata - $prev) / $prev) * 100, 2);
                    }
                    $prev = $row->harga_rata;
                }
            }

            if ($export) return $data;
            return response()->json($data);
        }

        // =====================================================================
        // 30 DAYS
        // =====================================================================
        if ($r->date == '30days') {

            $startDate = Carbon::today()->subDays(29);
            $endDate = Carbon::today();

            $period = [];
            for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
                $period[] = $date->format('Y-m-d');
            }

            $commodityName = '-';
            if ($r->komoditas) {
                $commodity = Commodity::find($r->komoditas);
                $commodityName = $commodity?->name_commodity ?? '-';
            }

            $marketName = Market::find($marketId)?->name_market ?? '-';

            // Query harga
            $pricesQuery = Price::query()
                ->whereBetween('prices.date', [$startDate, $endDate])
                ->where('prices.market_id', $marketId)
                ->when($r->komoditas, fn($q) => $q->where('prices.commodity_id', $r->komoditas))
                ->when($r->category, fn($q) => $q->whereHas('commodity', fn($q2) => $q2->where('category_id', $r->category)));

            $prices = $pricesQuery
                ->join('users', 'users.id_user', '=', 'prices.user_id')
                ->select(
                    DB::raw('DATE(prices.date) as tanggal'),
                    DB::raw('ROUND(AVG(prices.price)) as harga_rata'),
                    DB::raw('MAX(users.name) as admin')
                )
                ->groupBy('tanggal')
                ->get()
                ->keyBy('tanggal');

            $data = collect();
            foreach ($period as $tanggal) {
                $rowPrice = $prices[$tanggal] ?? null;
                $data->push((object)[
                    'tanggal' => $tanggal,
                    'nama_commodity' => $commodityName,
                    'nama_pasar' => $marketName,
                    'harga_rata' => $rowPrice->harga_rata ?? null,
                    'perubahan' => 0,
                    'admin' => $rowPrice->admin ?? '-'
                ]);
            }

            // Hitung perubahan
            $prev = null;
            foreach ($data as $row) {
                if ($row->harga_rata === null) {
                    $row->perubahan = 0;
                } else {
                    if ($prev === null) {
                        $row->perubahan = 0;
                    } else {
                        $row->perubahan = round((($row->harga_rata - $prev) / $prev) * 100, 2);
                    }
                    $prev = $row->harga_rata;
                }
            }

            if ($export) return $data;
            return response()->json($data);
        }


        // =====================================================================
        // 1 YEAR
        // =====================================================================
        if ($r->date == '1year') {

            $startMonth = Carbon::now()->subMonths(11)->startOfMonth();
            $endMonth = Carbon::now()->endOfMonth();

            // Buat array 12 bulan terakhir
            $period = [];
            for ($date = $startMonth->copy(); $date <= $endMonth; $date->addMonth()) {
                $period[] = $date->format('Y-m');
            }

            // Ambil nama komoditas
            $commodityName = '-';
            if ($r->komoditas) {
                $commodity = \App\Models\Commodity::find($r->komoditas);
                $commodityName = $commodity?->name_commodity ?? '-';
            }

            // Ambil nama pasar
            $marketName = Market::find($marketId)?->name_market ?? '-';

            // Ambil harga per bulan beserta admin
            $pricesQuery = Price::query()
                ->whereBetween('prices.date', [$startMonth, $endMonth])
                ->when($r->komoditas, fn($q) => $q->where('prices.commodity_id', $r->komoditas))
                ->where('prices.market_id', $marketId)
                ->when($r->category, fn($q) => $q->whereHas('commodity', fn($q2) => $q2->where('category_id', $r->category)));

            $prices = $pricesQuery
                ->join('users', 'users.id_user', '=', 'prices.user_id')
                ->select(
                    DB::raw("TO_CHAR(prices.date, 'YYYY-MM') as bulan"),
                    DB::raw('ROUND(AVG(prices.price)) as harga_rata'),
                    DB::raw('MAX(users.name) as admin')
                )
                ->groupBy('bulan')
                ->get()
                ->keyBy('bulan');

            // Merge periode bulan dengan harga
            $data = collect();
            foreach ($period as $bulan) {
                $rowPrice = $prices[$bulan] ?? null;
                $data->push((object)[
                    'tanggal' => $bulan,
                    'nama_commodity' => $commodityName,
                    'nama_pasar' => $marketName,
                    'harga_rata' => $rowPrice ? $rowPrice->harga_rata : null,
                    'perubahan' => 0,
                    'admin' => $rowPrice ? ($marketAll ? 'Petugas Pasar' : $rowPrice->admin) : '-',
                ]);
            }

            // Hitung perubahan harga per bulan
            $prev = null;
            foreach ($data as $row) {
                if ($row->harga_rata === null) {
                    $row->perubahan = 0;
                } else {
                    if ($prev === null) {
                        $row->perubahan = 0;
                    } else {
                        $row->perubahan = round((($row->harga_rata - $prev) / $prev) * 100, 2);
                    }
                    $prev = $row->harga_rata;
                }
            }

            if ($export) return $data;
            return response()->json($data);
        }

        // =====================================================================
        // CUSTOM RANGE
        // =====================================================================
        if ($r->date == 'custom') {

            if ($r->start && $r->end) {
                $startDate = Carbon::parse($r->start);
                $endDate = Carbon::parse($r->end);

                // Buat array periode tanggal
                $period = [];
                for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
                    $period[] = $date->format('Y-m-d');
                }

                // Ambil nama komoditas
                $commodityName = '-';
                if ($r->komoditas) {
                    $commodity = \App\Models\Commodity::find($r->komoditas);
                    $commodityName = $commodity?->name_commodity ?? '-';
                }

                $marketName = Market::find($marketId)?->name_market ?? '-';

                // Ambil harga per tanggal beserta admin
                $pricesQuery = Price::query()
                    ->whereBetween('prices.date', [$startDate, $endDate])
                    ->when($r->komoditas, fn($q) => $q->where('prices.commodity_id', $r->komoditas))
                    ->where('prices.market_id', $marketId)
                    ->when($r->category, fn($q) => $q->whereHas('commodity', fn($q2) => $q2->where('category_id', $r->category)));

                $prices = $pricesQuery
                    ->join('users', 'users.id_user', '=', 'prices.user_id')
                    ->select(
                        DB::raw('DATE(prices.date) as tanggal'),
                        DB::raw('ROUND(AVG(prices.price)) as harga_rata'),
                        DB::raw('MAX(users.name) as admin')
                    )
                    ->groupBy('tanggal')
                    ->get()
                    ->keyBy('tanggal');

                // Merge periode tanggal dengan harga
                $data = collect();
                foreach ($period as $tanggal) {
                    $rowPrice = $prices[$tanggal] ?? null;
                    $data->push((object)[
                        'tanggal' => $tanggal,
                        'nama_commodity' => $commodityName,
                        'nama_pasar' => $marketName,
                        'harga_rata' => $rowPrice ? $rowPrice->harga_rata : null,
                        'perubahan' => 0,
                        'admin' => $rowPrice ? ($marketAll ? 'Petugas Pasar' : $rowPrice->admin) : '-',
                    ]);
                }

                // Hitung perubahan harga
                $prev = null;
                foreach ($data as $row) {
                    if ($row->harga_rata === null) {
                        $row->perubahan = 0;
                    } else {
                        if ($prev === null) {
                            $row->perubahan = 0;
                        } else {
                            $row->perubahan = round((($row->harga_rata - $prev) / $prev) * 100, 2);
                        }
                        $prev = $row->harga_rata;
                    }
                }

                if ($export) return $data;
                return response()->json($data);
            }
        }
    }

    public function exportExcel(Request $r)
    {
        $r->merge(['export' => true]);

        $data = $this->filter($r);
        // dd($r->all(), $data);
        return Excel::download(new PriceExport($data), 'laporan.xlsx');
    }

    public function exportPDF(Request $r)
    {
        $r->merge(['export' => true]);
        $data = $this->filter($r);

        $pdf = Pdf::loadView('dashboard.laporan-pdf', ['data' => $data])
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan.pdf');
    }
}
