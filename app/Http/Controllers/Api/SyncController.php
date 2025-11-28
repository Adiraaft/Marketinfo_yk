<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Commodity;
use App\Models\Market;
use App\Models\Price;

use Illuminate\Support\Facades\DB;

class SyncController extends Controller
{
    // === Sinkronisasi batch data offline ===
    public function syncBatch(Request $request)
    {
        $user = $request->user(); // ambil dari token Sanctum

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Token tidak valid'
            ], 401);
        }

        $data = $request->data;

        if (!is_array($data) || count($data) == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Data sinkronisasi kosong'
            ], 400);
        }

        // Ambil data market dari user
        $market = Market::where('id_market', $user->market_id)->first();

        if (!$market) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak memiliki data pasar'
            ], 400);
        }

        $results = [];

        foreach ($data as $item) {
            if (!isset($item['commodity_id']) || !isset($item['price'])) {
                continue;
            }

            $commodity = Commodity::with('unit')
                ->where('id_commodity', $item['commodity_id'])
                ->first();

            if (!$commodity) {
                continue;
            }

            // Simpan harga baru
            $price = Price::create([
                'commodity_id' => $item['commodity_id'],
                'user_id'      => $user->id_user,
                'price'        => $item['price'],
                'date'         => now(),
                'market_id'    => $user->market_id,
                'updated_at'   => now(),
                'created_at'   => now()
            ]);

            $results[] = [
                'commodity_id'   => $commodity->id_commodity,
                'name_commodity' => $commodity->name_commodity,
                'unit'           => $commodity->unit?->nama_satuan,
                'price'          => $item['price'],
                'market' => [
                    'id_market'   => $market->id_market,
                    'name_market' => $market->name_market,
                ],
                'created_at'     => $price->created_at,
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Data offline berhasil disinkronkan',
            'count'   => count($results),
            'data'    => $results
        ]);
    }

    // === Sinkronisasi satu harga ===
    public function syncSingle(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Token tidak valid'
            ], 401);
        }

        $request->validate([
            'commodity_id' => 'required|integer',
            'price'        => 'required|numeric'
        ]);

        $commodity = Commodity::with('unit')
            ->where('id_commodity', $request->commodity_id)
            ->first();

        if (!$commodity) {
            return response()->json([
                'success' => false,
                'message' => 'Komoditas tidak ditemukan'
            ], 404);
        }

        $market = Market::find($user->market_id);

        if (!$market) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak memiliki data pasar'
            ], 400);
        }

        $price = Price::create([
            'commodity_id' => $commodity->id_commodity,
            'user_id'      => $user->id_user,
            'price'        => $request->price,
            'date'         => now(),
            'market_id'    => $user->market_id,
            'updated_at'   => now(),
            'created_at'   => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data harga komoditas berhasil disimpan',
            'data' => [
                'id_price'       => $price->id_price,
                'commodity_id'   => $commodity->id_commodity,
                'name_commodity' => $commodity->name_commodity,
                'unit'           => $commodity->unit ?$commodity->unit->name : 'mbuh',
                'price'          => $request->price,
                'market' => [
                    'id_market'   => $market->id_market,
                    'name_market' => $market->name_market,
                ],
                'user_id'        => $user->id_user,
                'created_at'     => $price->created_at
            ]
        ]);
    }
}
