<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Commodity;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Ambil seluruh kategori
        $categories = Category::all();

        // Ambil komoditas + harga terbaru
        $commodities = Commodity::with([
            'prices' => function ($q) {
                $q->orderBy('date', 'desc')->first();
            }
        ])->get();

        return view('home.index', compact('categories', 'commodities'));
    }
}
