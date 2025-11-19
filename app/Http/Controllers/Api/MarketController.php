<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Market;
use Illuminate\Http\Request;

class MarketController extends Controller
{
    // GET /api/markets
    public function index()
    {
        try {
            $markets = Market::orderBy('id_market')->get();
            return response()->json($markets);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Server error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // GET /api/markets/{id}
    public function show($id)
    {
        try {
            $market = Market::find($id);

            if (!$market) {
                return response()->json(['error' => 'Market not found'], 404);
            }

            return response()->json($market);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Server error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
