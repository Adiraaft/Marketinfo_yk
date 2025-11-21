<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    // GET /api/units
    public function index()
    {
        try {
            $units = Unit::orderBy('id')->get();
            return response()->json($units);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Server error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // GET /api/units/{id}
    public function show($id)
    {
        try {
            $unit = Unit::find($id);

            if (!$unit) {
                return response()->json(['error' => 'Unit not found'], 404);
            }

            return response()->json($unit);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Server error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
