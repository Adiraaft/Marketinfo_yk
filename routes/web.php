<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\CommodityController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\PublicBeritaController;
use App\Http\Controllers\ReportController;

// Dashboard Utama User
Route::get('/', [PublicBeritaController::class, 'indexHome'])->name('home.index');
Route::get('/comparison-data', [PublicBeritaController::class, 'getComparisonData'])->name('comparison.data');
Route::get('/komoditas/{commodity}', [PublicBeritaController::class, 'detailCommodity'])->name('commodity.detail');
Route::get('/komoditas/{commodity}/chart', [PublicBeritaController::class, 'getChartData'])->name('commodity.chart');

// Halaman berita utama
Route::get('/berita', [PublicBeritaController::class, 'indexBerita'])->name('berita.index');
// Detail berita
Route::get('/berita/{id}', [PublicBeritaController::class, 'detail'])->name('berita.detail');
Route::get('/pasar', [MarketController::class, 'publicIndex'])->name('pasar.pasar');
Route::get('/pasar/{id}', [MarketController::class, 'detail'])->name('pasar.detail');

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login/users', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {

    Route::get('/dashboard', [SuperAdminController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/data-harga', [SuperAdminController::class, 'getPriceData']);

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

    Route::get('/komoditas', [CommodityController::class, 'index'])->name('komoditas');
    Route::get('/komoditas/create', [CommodityController::class, 'create'])->name('komoditas.create');
    Route::post('/komoditas/store', [CommodityController::class, 'store'])->name('komoditas.store');
    Route::delete('/komoditas/{id}', [CommodityController::class, 'destroy'])->name('komoditas.destroy');
    Route::get('komoditas/{id}/edit', [CommodityController::class, 'edit'])->name('komoditas.edit');
    Route::put('komoditas/{id}', [CommodityController::class, 'update'])->name('komoditas.update');


    Route::get('/laporan', [ReportController::class, 'index'])->name('laporan');
    Route::get('/laporan/by-category/{id}', [ReportController::class, 'getCommoditiesByCategory']);
    Route::get('/laporan/filter', [ReportController::class, 'filter']);
    Route::get('/laporan/export/excel', [ReportController::class, 'exportExcel'])->name('laporan.export.excel');
    Route::get('/laporan/export/pdf', [ReportController::class, 'exportPDF'])->name('laporan.export.pdf');


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

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/komoditas/{filter?}', [AdminController::class, 'komoditas'])->name('komoditas');
    Route::post('/komoditas/store', [AdminController::class, 'store'])->name('komoditas.store');
    Route::put('/komoditas/update/{id}', [AdminController::class, 'update'])->name('komoditas.update');

    Route::get('/manajemen', [AdminController::class, 'index'])->name('manajemen');
    Route::post('/manajemen/{id}/status', [AdminController::class, 'updateStatus'])->name('manajemen.status');

    Route::get('/laporan', [ReportController::class, 'indexAdmin'])->name('laporan');
    Route::get('/laporan/by-category/{id}', [ReportController::class, 'getCommoditiesByCategory']);
    Route::get('/laporan/filter', [ReportController::class, 'filterAdmin']);
    Route::get('/laporan/export/excel', [ReportController::class, 'exportExcel'])->name('laporan.export.excel');
    Route::get('/laporan/export/pdf', [ReportController::class, 'exportPDF'])->name('laporan.export.pdf');

    Route::get('account/setting', [AdminController::class, 'editProfile'])
        ->name('account.edit');

    Route::put('account/setting/{id}', [AdminController::class, 'updateProfile'])
        ->name('account.update');
});
