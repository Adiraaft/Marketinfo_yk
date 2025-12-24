<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Commodity;
use Illuminate\Http\Request;

class CommodityController extends Controller
{
    // GET /api/commodities
public function index(Request $request)
{
    try {
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

        // Ambil semua commodity_id dari market tersebut
        $commodityIds = \DB::table('commodity_markets')
            ->where('market_id', $marketId)
            ->pluck('commodity_id');

        // Ambil komoditas lengkap dengan category + unit
        $commodities = Commodity::with(['category', 'unit'])
            ->whereIn('id_commodity', $commodityIds)
            ->orderBy('id_commodity')
            ->get()
            ->map(function ($item) {
                return [
                    'id_commodity'   => $item->id_commodity,
                    'name_commodity' => $item->name_commodity,
                    'unit_id'        => $item->unit_id,
                    'unit_name'      => $item->unit->name_unit ?? null,
                    'category_id'    => $item->category_id,
                    'category_name'  => $item->category->name_category ?? null,
                    'image'          => $item->image
                        ? url('storage/commoditiy_images/' . $item->image)
                        : null,
                ];
            });

        return response()->json([
            'market_id' => $marketId,
            'total'     => $commodities->count(),
            'data'      => $commodities
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'error'   => 'Server error',
            'message' => $e->getMessage()
        ], 500);
    }
}

}
