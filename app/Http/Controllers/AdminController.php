<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Commodity;
use App\Models\CommodityMarket;
use App\Models\Market;
use App\Models\Price;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
        $selectedDate = $request->tanggal ?? now()->toDateString();
        $yesterdayDate = \Carbon\Carbon::parse($selectedDate)->subDay()->toDateString();

        $adminCount = User::where('role', 'admin')
            ->where('market_id', $marketId)
            ->count();

        $commodityCount = Commodity::whereHas('commodityMarkets', function ($q) use ($marketId) {
            $q->where('market_id', $marketId)->where('status', 'aktif');
        })->count();

        $updatedCommodityIds = Price::where('market_id', $marketId)
            ->where('date', $selectedDate)
            ->distinct()
            ->pluck('commodity_id');

        $prices = Price::where('market_id', $marketId)
            ->where('date', $selectedDate)
            ->with(['commodity.unit'])
            ->get()
            ->groupBy('commodity_id');

        $latestPrices = [];

        foreach ($prices as $commodityId => $rows) {

            $todayAvg = $rows->avg('price');

            // ambil harga terakhir sebelum tanggal yg dipilih
            $yesterdayAvg = Price::where('market_id', $marketId)
                ->where('commodity_id', $commodityId)
                ->where('date', '<', $selectedDate)
                ->orderBy('date', 'desc')
                ->value('price');

            $commodity = $rows->first()->commodity;

            $latestPrices[] = [
                'commodity' => $commodity,
                'today_price' => $todayAvg,
                'yesterday_price' => $yesterdayAvg,
                'change' => $yesterdayAvg ? $todayAvg - $yesterdayAvg : 0,
            ];
        }
        $belumUpdate = Commodity::whereHas('commodityMarkets', function ($q) use ($marketId) {
            $q->where('market_id', $marketId)->where('status', 'aktif');
        })
            ->whereNotIn('id_commodity', $updatedCommodityIds)
            ->select('name_commodity')
            ->get()
            ->map(fn($c) => ['name' => $c->name_commodity]);

        return view('dashboardAdmin.dashboard', [
            'latestPrices' => $latestPrices,
            'belumUpdate' => $belumUpdate,
            'selectedDate' => $selectedDate,
            'adminCount' => $adminCount,
            'commodityCount' => $commodityCount,
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

        $prices = Price::where('market_id', $marketId)
            ->where('date', $selectedDate)
            ->get()
            ->groupBy('commodity_id');

        $commodities = $commodities->map(function ($c) use ($prices, $marketId, $selectedDate) {

            $rows = $prices[$c->id_commodity] ?? collect();

            $c->today_avg   = $rows->avg('price');
            $c->today_count = $rows->count();
            $c->is_updated  = $rows->isNotEmpty();

            if ($c->is_updated) {
                $pivot = $c->commodityMarkets->first();

                $c->edit_payload = [
                    'id' => $pivot->id,
                    'commodityId' => $pivot->commodity_id,
                    'marketId' => $pivot->market_id,
                    'name' => $c->name_commodity,
                    'prices' => $rows->pluck('price')->map(fn($p) => (int) $p)->toArray(),
                    'date' => $selectedDate,
                ];
            }

            return $c;
        });

        // ========== FILTER KATEGORI ==========
        if ($request->kategori && $request->kategori != '#') {
            $commodities = $commodities->where('category_id', $request->kategori);
        }

        // ========== HITUNG TOTAL ==========
        $countAll   = $commodities->count();
        $countSudah = $commodities->where('is_updated', true)->count();
        $countBelum = $commodities->where('is_updated', false)->count();


        // ========== FILTER STATUS (TAB) ==========
        $filtered = $commodities->filter(function ($item) use ($filter) {
            if ($filter === 'belum-update') return !$item->is_updated;
            if ($filter === 'sudah-update') return $item->is_updated;
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
    public function editProfile()
    {
        $user = auth()->user(); // ambil akun admin yang sedang login

        return view('dashboardAdmin.setting', [
            'petugas' => $user
        ]);
    }
    public function updateProfile(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // VALIDASI hanya untuk field yang boleh diubah admin
        $request->validate([
            'first_name'    => 'required|string|max:100',
            'last_name'     => 'required|string|max:100',
            'date_of_birth' => 'required|date',
            'phone'         => 'required|string|max:20',
            'password'      => 'nullable|string|min:6',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update nama lengkap
        $user->name = ucfirst(strtolower($request->first_name)) . ' ' . ucfirst(strtolower($request->last_name));

        $user->date_of_birth = $request->date_of_birth;
        $user->phone = $request->phone;

        // Password (opsional)
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        // Upload Foto jika ada
        if ($request->hasFile('image')) {

            // Hapus foto lama jika ada
            if ($user->image && Storage::exists('public/' . $user->image)) {
                Storage::delete('public/' . $user->image);
            }

            // Simpan foto baru
            $user->image = $request->file('image')->store('petugas_images', 'public');
        }

        $user->save();

        return redirect()->back()->with('success', 'Akun berhasil diperbarui.');
    }
}
