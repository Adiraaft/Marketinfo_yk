<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Commodity;
use Illuminate\Http\Request;

class CommodityController extends Controller
{
    // GET /api/commodities
    public function index()
    {
        try {
            $commodities = Commodity::with('category')
                ->orderBy('id_commodity')
                ->get()
                ->map(function ($item) {
                    return [
                        'id_commodity' => $item->id_commodity,
                        'name_commodity' => $item->name_commodity,
                        'unit_id' => $item->unit_id,
                        'category_id' => $item->category_id,
                        'image' => $item->image 
                        ? url('storage/commodities/' . $item->image)
                        : null,
                        'category_name' => $item->category ? $item->category->name_category : null,
                    ];
                });

            return response()->json($commodities);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Server error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
