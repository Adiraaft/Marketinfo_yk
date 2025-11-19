<?php

namespace App\Http\Controllers;

use App\Models\Berita;   // ← MODEL YANG BENAR
use Illuminate\Http\Request;

class PublicBeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::latest()->get();
        return view('berita.berita', compact('berita'));
    }

    public function show($id)
    {
        $news = Berita::findOrFail($id);  // ← GANTI News jadi Berita
        return view('berita.detailberita', compact('news'));
    }
}
