<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class PublicBeritaController extends Controller
{
    // Untuk halaman daftar berita
    public function indexBerita()
    {
        $berita = Berita::latest()->paginate(9);
        return view('berita.berita', compact('berita'));
    }

    // Untuk halaman detail berita
    public function detail($id)
    {
        $news = Berita::findOrFail($id);
        return view('berita.detailberita', compact('news'));
    }

    // Untuk Berita di Dashboard User
        public function indexHome()
    {
        // 1 berita terbaru untuk kiri besar
        $latest = Berita::latest()->first();

        // 3 berita lainnya untuk bagian kanan desktop
        $others = Berita::latest()->skip(1)->take(3)->get();

        // daftar berita (paginate) — dipakai di bagian bawah yang menampilkan grid berita
        $berita = Berita::latest()->paginate(6);

        // kirim semua variabel yang dipakai view
        return view('home.index', compact('latest', 'others', 'berita'));
    }



    
}
