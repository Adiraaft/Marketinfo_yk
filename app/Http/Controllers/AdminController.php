<?php

namespace App\Http\Controllers;

use App\Models\Commodity;
use App\Models\CommodityMarket;
use App\Models\Market;
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
    public function komoditas(Request $request)
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

        return view('dashboardAdmin.komoditas', compact('commodities'));
    }
}
