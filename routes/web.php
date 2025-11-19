<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\PublicBeritaController;

Route::get('/', function () {
    return view('home.index');
})->name('home.index');
Route::get('/pasar', function () {
    return view('pasar.pasar');
})->name('pasar.pasar');
Route::get('/detailkomoditas', function () {
    return view('komoditas.detailkomoditas');
})->name('detailkomoditas');


Route::get('/berita', [PublicBeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{id}', [PublicBeritaController::class, 'show'])->name('berita.show');

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login/users', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {

    Route::get('/dashboard', [SuperAdminController::class, 'index'])->name('dashboard');

    Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
    Route::get('/berita/create', [BeritaController::class, 'create'])->name('berita.create');
    Route::post('/berita', [BeritaController::class, 'store'])->name('berita.store');
    Route::get('/berita/{berita}/edit', [BeritaController::class, 'edit'])->name('berita.edit');
    Route::put('/berita/{berita}', [BeritaController::class, 'update'])->name('berita.update');
    Route::delete('/berita/{berita}', [BeritaController::class, 'destroy'])->name('berita.destroy');

    Route::get('/petugas', [PetugasController::class, 'index'])->name('petugas');
    Route::get('/petugas/create', [PetugasController::class, 'create'])->name('petugas.create');
    Route::post('/petugas/store', [PetugasController::class, 'store'])->name('petugas.store');
    Route::get('/petugas/{id}/edit', [PetugasController::class, 'edit'])->name('petugas.edit');
    Route::put('/petugas/{id}', [PetugasController::class, 'update'])->name('petugas.update');
    Route::delete('/petugas/{id}', [PetugasController::class, 'destroy'])->name('petugas.destroy');

    Route::get('/market', [MarketController::class, 'index'])->name('market');
    Route::get('/market/create', [MarketController::class, 'create'])->name('market.create');
    Route::post('/market/store', [MarketController::class, 'store'])->name('market.store');
    route::get('/market/{id}/edit', [MarketController::class, 'edit'])->name('market.edit');
    route::put('/market/{id}', [MarketController::class, 'update'])->name('market.update');
    Route::delete('/market/{id}', [MarketController::class, 'destroy'])->name('market.destroy');

    Route::get('/komoditas', function () {
        return view('dashboard.komoditas');
    })->name('komoditas');

    Route::get('/laporan', function () {
        return view('dashboard.laporan');
    })->name('laporan');

    Route::get('/setting', function () {
        return view('dashboard.setting');
    })->name('setting');

    Route::get('/account', [SuperAdminController::class, 'edit'])->name('account');
    Route::put('/account', [SuperAdminController::class, 'update'])->name('account.update');

    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
    Route::get('/satuan', [SatuanController::class, 'index'])->name('satuan');
    Route::post('/satuan', [SatuanController::class, 'store'])->name('satuan.store');
    Route::put('/satuan/{id}', [SatuanController::class, 'update'])->name('satuan.update');
    Route::delete('/satuan/{id}', [SatuanController::class, 'destroy'])->name('satuan.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', function(){
        return view('dashboardAdmin.dashboard');
    })->name('dashboard');

    Route::get('/manajemen', function(){
        return view('dashboardAdmin.manajemen');
    })->name('manajemen');

    Route::get('/laporan', function(){
        return view('dashboardAdmin.laporan');
    })->name('laporan');
});
