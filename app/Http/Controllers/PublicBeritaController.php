<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Market; // <- WAJIB
use Illuminate\Http\Request;

class PublicBeritaController extends Controller
{
    // Halaman daftar berita
    public function indexBerita()
    {
        $berita = Berita::latest()->paginate(9);
        return view('berita.berita', compact('berita'));
    }

    // Detail berita
    public function detail($id)
    {
        $news = Berita::findOrFail($id);
        return view('berita.detailberita', compact('news'));
    }

    // Halaman Home
    public function indexHome()
    {
        // Ambil data berita
        $latest = Berita::latest()->first();
        $others = Berita::latest()->skip(1)->take(3)->get();
        $berita = Berita::latest()->paginate(6);

        // Ambil semua pasar aktif
        $markets = Market::where('status', 'aktif')->get();

        // Kirim KE SEMUA yg dipakai view
        return view('home.index', compact('latest', 'others', 'berita', 'markets'));
    }
}
