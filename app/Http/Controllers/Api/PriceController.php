<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Price;
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

    // ambil primary key sesuai model (id_user)
    $userId = $user->getKey();

    $prices = Price::with([
        'commodity.category',
        'commodity.unit'
    ])
    ->where('user_id', $userId)
    ->orderBy('id_price', 'desc')
    ->get()
    ->map(function($item) {
        return [
            'id_price'       => $item->id_price,
            'commodity_name' => $item->commodity->name_commodity ?? null,
            'price'          => $item->price,
            'category_name'  => $item->commodity->category->name_category ?? null,
            'unit_name'      => $item->commodity->unit->name ?? null,
            'created_at'     => $item->created_at,
            'updated_at'     => $item->updated_at,
        ];
    });

    return response()->json([
        'user_id'   => $userId,
        'user_name' => $user->name,
        'total'     => $prices->count(),
        'data'      => $prices
    ]);
}


 // GET /api/prices/test/{userId}
    public function testByUser($userId)
    {
        $prices = Price::with([
            'commodity.category',
            'commodity.unit'
        ])
        ->where('user_id', $userId)
        ->orderBy('id_price', 'desc')
        ->get()
        ->map(function($item) {
            return [
                'id_price'          => $item->id_price,
                'commodity_name'    => $item->commodity->name_commodity ?? null,
                'price'             => $item->price,
                'category_name'     => $item->commodity->category->name_category ?? null,
                'unit_name'         => $item->commodity->unit->name ?? null,
                'created_at'        => $item->created_at,
                'updated_at'        => $item->updated_at,
            ];
        });

        return response()->json([
            'user_id_checked' => $userId,
            'total_data'      => $prices->count(),
            'data'            => $prices
        ]);
    }

}

   

