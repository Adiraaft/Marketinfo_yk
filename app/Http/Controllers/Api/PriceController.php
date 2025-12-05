<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Price;
use App\Models\Commodity;
use Illuminate\Http\Request;


class PriceController extends Controller
{
public function index(Request $request)
{
    $user = $request->user();

    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'Token tidak valid'
        ], 401);
    }

    $marketId = $user->market_id;

    if (!$marketId) {
        return response()->json([
            'success' => false,
            'message' => 'User tidak terdaftar pada market manapun'
        ], 403);
    }

    // Ambil semua commodity_id yang masuk ke market user
    $commodityIds = \DB::table('commodity_markets')
        ->where('market_id', $marketId)
        ->pluck('commodity_id');

    // Ambil komoditas + hitung average harga dari tabel prices
    $commodities = Commodity::with(['category', 'unit'])
        ->whereIn('id_commodity', $commodityIds)
        ->orderBy('id_commodity', 'asc')
        ->get()
        ->map(function ($commodity) use ($marketId) {

            $avgPrice = Price::where('commodity_id', $commodity->id_commodity)
                ->where('market_id', $marketId)
                ->avg('price');

            return [
                'commodity_id'   => $commodity->id_commodity,
                'commodity_name' => $commodity->name_commodity,
                'category_name'  => $commodity->category->name_category ?? null,
                'unit_name'      => $commodity->unit->name_unit ?? null,
                'average_price'  => $avgPrice ? round($avgPrice) : null,
            ];
        });

    return response()->json([
        'market_id' => $marketId,
        'total'     => $commodities->count(),
        'data'      => $commodities
    ]);
}

public function allPrices(Request $request)
{
    $user = $request->user();
    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'Token tidak valid'
        ], 401);
    }

    $marketId = $user->market_id;

    $prices = Price::where('market_id', $marketId)
        ->orderBy('commodity_id', 'asc')
        ->orderBy('created_at', 'desc')
        ->get();

    return response()->json([
        'total' => $prices->count(),
        'data' => $prices
    ]);
}

public function detailByCommodity(Request $request, $commodityId)
{
    $user = $request->user();
    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'Token tidak valid'
        ], 401);
    }

    $marketId = $user->market_id;

    // Ambil semua harga untuk komoditas ini di market user
    $prices = Price::where('commodity_id', $commodityId)
        ->where('market_id', $marketId)
        ->orderBy('created_at', 'desc')
        ->get();

    return response()->json([
        'commodity_id' => $commodityId,
        'total' => $prices->count(),
        'data' => $prices
    ]);
}


}

   

