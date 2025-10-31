@extends('layouts.home')

@section('title', 'Detail Berita')

@section('navbar')
    <x-navbar-color />

@endsection

@section('content')
    <div class="mx-15 mt-5 mb-20">
        <a href="{{ route('berita.berita') }}" class="text-blue-500 hover:underline mt-3 inline-block">
            ← Kembali
        </a>
        <div class="grid grid-cols-12 mt-6 gap-8">
            {{-- kiri (4 kolom) --}}
            <div class="col-span-12 md:col-span-4 space-y-5">
                <img src="{{ asset('images/berita.png') }}" class="w-full h-120 object-cover rounded-lg" alt="berita1">

                <div class="flex gap-5 justify-center">
                    <img src="{{ asset('images/berita.png') }}" class="w-20 h-20 object-cover rounded-lg" alt="berita1">
                    <img src="{{ asset('images/berita.png') }}" class="w-20 h-20 object-cover rounded-lg" alt="berita1">
                    <img src="{{ asset('images/berita.png') }}" class="w-20 h-20 object-cover rounded-lg" alt="berita1">
                </div>

                <div class="space-y-2">
                    <p class="text-sm font-semibold text-center">Sumber</p>
                    <a href="https://kmp.im/plus6" target="_blank"
                        class="block text-blue-500 underline border border-secondary py-3 px-3 rounded-lg">
                        Baca berita lengkap di Kompas.com
                    </a>
                </div>
            </div>

            {{-- kanan (8 kolom) --}}
            <div class="col-span-12 md:col-span-8 space-y-4">
                <h2 class="text-3xl font-bold">Gibran Tinjau Pasar Rogojampi, Pedagang Harapkan Harga Bahan Pokok Turun</h2>
                <div class="space-y-4 text-justify leading-relaxed">
                    <p>
                        Wakil Presiden (Wapres) RI Gibran Rakabuming blusukan meninjau kegiatan di Pasar Cipulir, Kebayoran
                        Lama, Jakarta Selatan, Kamis (4/9/2025) malam. Adapun Gibran tiba di pasar sekitar pukul 23.45 WIB
                        usai
                        mengecek Sistem Keamanan Lingkungan (Siskamling) di Kawasan Kembangan, Jakarta Barat dan Kawasan
                        Pesanggrahan, Jakarta Selatan. Dari siaran YouTube Wakil Presiden Republik Indonesia, Gibran
                        terlihat
                        menyusuri Jalan Ciledug Raya yang dipenuhi lapak pedagang.
                    </p>

                    <p>
                        Setiap mendatangi lapak para pedagang, Gibran terlihat berbincang singkat dengan penjualnya. Selain
                        mengecek situasi perekonomian pasca aksi demonstrasi pada Agustus lalu, ia sekaligus berbelanja
                        untuk
                        mendukung perekonomian rakyat.
                    </p>

                    <p>
                        Tampak Gibran berkeliling dan memborong dagangan dari lapak penjual sayuran, ikan, ayam, hingga
                        bumbu
                        dapur. Tidak sedikit juga warga baik pedagang dan pembeli yang mengerumuni untuk berfoto dan
                        menyalami
                        Gibran. Gibran berharap aktivitas masyarakat, khususnya di pasar tradisional sebagai pusat
                        perputaran
                        ekonomi rakyat, dapat terus berjalan normal.
                    </p>

                    <p>
                        Dia juga menegaskan pentingnya menjaga ketenangan bersama agar roda ekonomi tetap berputar dan
                        kepercayaan publik terhadap stabilitas nasional semakin kuat.
                    </p>

                    <p>
                        Menurutnya, stabilitas bukan hanya ditopang oleh keamanan, tetapi juga oleh terjaganya denyut
                        ekonomi
                        rakyat. Adapun langkah ini sejalan dengan arahan Presiden Prabowo Subianto yang menekankan
                        pentingnya
                        menjaga stabilitas tidak hanya dari sisi keamanan, tetapi juga melalui penguatan ekonomi rakyat.
                    </p>
                </div>

            </div>
        </div>

    </div>
@endsection
