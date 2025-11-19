<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserInfoController;
use App\Http\Controllers\Api\SyncController;

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
});
// endpoint login
Route::post('/login-mobile', [AuthController::class, 'login']);
