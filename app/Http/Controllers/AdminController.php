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
        // Ambil market admin saat ini
        $market = Market::find(auth()->user()->market_id);

        // Jika market ditemukan → ambil komoditas beserta pivot
        $commodities = $market
            ? $market->commodities()->with(['category', 'unit'])->get()
            : collect();

        return view('dashboardAdmin.manajemen', compact('commodities', 'market'));
    }

    public function updateStatus(Request $request, $id)
    {
        $pivot = CommodityMarket::findOrFail($id);

        $pivot->status = $request->status;
        $pivot->save();

        return response()->json(['success' => true]);
    }
}
