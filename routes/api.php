<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserInfoController;
use App\Http\Controllers\Api\SyncController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CommodityController;
use App\Http\Controllers\Api\MarketController;
use App\Http\Controllers\Api\UnitController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    // endpoint userinfo
    Route::get('/userinfo', [UserInfoController::class, 'index']);
    // endpoint sync
    Route::post('/sync', [SyncController::class, 'syncBatch']);
    Route::post('/sync/price', [SyncController::class, 'syncSingle']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{id}', [CategoryController::class, 'show']);
    Route::get('/commodities', [CommodityController::class, 'index']);
    Route::get('/commodities/{id}', [CommodityController::class, 'show']);
    Route::get('/markets', [MarketController::class, 'index']);
    Route::get('/markets/{id}', [MarketController::class, 'show']);
    Route::put('/change-password', [AuthController::class, 'changePassword']);
    Route::get('/units', [UnitController::class, 'index']);
    Route::get('/units/{id}', [UnitController::class, 'show']);
});
// endpoint login
Route::post('/login-mobile', [AuthController::class, 'login']);
