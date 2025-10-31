<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home.index');
})->name('home.index');
Route::get('/pasar', function () {
    return view('pasar.pasar');
})->name('pasar.pasar');
Route::get('/dashboard', function () {
    return view('dashboard.dashboard');
})->name('dashboard.dashboard');
Route::get('/komoditas', function () {
    return view('dashboard.komoditas');
})->name('dashboard.komoditas');
Route::get('/berita', function () {
    return view('berita.berita');
})->name('berita.berita');
Route::get('/detailberita', function () {
    return view('berita.detailberita');
})->name('berita.detailberita');
