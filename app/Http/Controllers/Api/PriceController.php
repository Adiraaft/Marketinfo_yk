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
    $date = $request->query('date'); // OPTIONAL: YYYY-MM-DD

    if (!$marketId) {
        return response()->json([
            'success' => false,
            'message' => 'User tidak terdaftar pada market manapun'
        ], 403);
    }

    $commodityIds = \DB::table('commodity_markets')
        ->where('market_id', $marketId)
        ->pluck('commodity_id');

    $commodities = Commodity::with(['category', 'unit'])
        ->whereIn('id_commodity', $commodityIds)
        ->orderBy('id_commodity', 'asc')
        ->get()
        ->map(function ($commodity) use ($marketId, $date) {

            $priceQuery = Price::where('commodity_id', $commodity->id_commodity)
                ->where('market_id', $marketId);

            // filter tanggal kalau dikirim
            if ($date) {
                $priceQuery->whereDate('date', $date);
            }

            $avgPrice = $priceQuery->avg('price');

            // kalau tidak ada data → jangan tampilkan
            if ($avgPrice === null) {
                return null;
            }

            $latestCreatedAt = (clone $priceQuery)
                ->orderBy('created_at', 'desc')
                ->value('created_at');

            return [
                'commodity_id'   => $commodity->id_commodity,
                'commodity_name' => $commodity->name_commodity,
                'category_name'  => $commodity->category->name_category ?? null,
                'unit_name'      => $commodity->unit->name_unit ?? null,
                'average_price'  => round($avgPrice),
                'date'           => $date,
                'created_at'     => $latestCreatedAt,
                'image'          => $commodity->image
                    ? url('storage/commodity_images/' . $commodity->image)
                    : null,
            ];
        })
        ->filter()
        ->values();

    return response()->json([
        'market_id' => $marketId,
        'date'      => $date,
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
        ->get()
        ->map(function ($price) {
            return [
                'id_price'     => $price->id_price,
                'commodity_id' => $price->commodity_id,
                'user_id'      => $price->user_id,
                'market_id'    => $price->market_id,
                'price'        => (int) $price->price,
                'date'         => $price->date,
                'created_at'   => $price->created_at,
                'updated_at'   => $price->updated_at,
            ];
        });
    return response()->json([
        'total' => $prices->count(),
        'data'  => $prices
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
    $date = $request->query('date'); // OPTIONAL

    $prices = Price::where('commodity_id', $commodityId)
        ->where('market_id', $marketId)
        ->when($date, function ($q) use ($date) {
            $q->whereDate('date', $date);
        })
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function ($price) {
            return [
                'id_price'   => $price->id_price,
                'price'      => (int) $price->price,
                'date'       => $price->date,
                'created_at' => $price->created_at,
            ];
        });

    return response()->json([
        'commodity_id' => $commodityId,
        'date'         => $date,
        'total'        => $prices->count(),
        'data'         => $prices
    ]);
}
}
