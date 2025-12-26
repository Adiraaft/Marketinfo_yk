<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::orderBy('id_category')
                ->get()
                ->map(function ($item) {
                    return [
                        'id_category' => $item->id_category,
                        'name_category' => $item->name_category,
                        'image' => $item->image 
                            ? url ('images/' . $item->image)
                            : null,
                    ];
                });

            return response()->json($categories);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Server error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}



