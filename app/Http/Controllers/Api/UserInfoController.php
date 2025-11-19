<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Market;
use App\Models\Commodity;

class UserInfoController extends Controller
{
    public function index(Request $request)
    {
        // Ambil user dari token Sanctum
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Token tidak valid'
            ], 401);
        }

        // Ambil detail user + phone + market
        $market = Market::where('id_market', $user->market_id)->first();

        // Hitung total commodities
        $totalCommodities = Commodity::count();

        return response()->json([
            'success' => true,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_phone' => $user->phone,
            'market_name' => $market ? $market->name_market : 'Tidak diketahui',
            'total_commodities' => $totalCommodities,
        ]);
    }
}
