@extends('layouts.home')

@section('title', 'Detail Berita')

@section('navbar')
    <x-navbar-color />
@endsection

@section('content')
    <div class="mx-6 md:mx-20 mt-6 mb-24">
        <a href="{{ route('berita.berita') }}" class="text-blue-500 hover:underline mt-3 hidden md:inline-block ">
            ← Kembali
        </a>

        <div class="grid grid-cols-1 md:grid-cols-12 mt-6 gap-6 md:gap-8">
            {{-- Kolom kiri --}}
            <div class="md:col-span-4 space-y-6">
                {{-- Judul Mobile --}}
                <h2 class="block md:hidden text-5xl md:text-4xl font-bold leading-snug pb-8">
                    Gibran Tinjau Pasar Rogojampi, Pedagang Harapkan Harga Bahan Pokok Turun
                </h2>
                {{-- Gambar utama --}}
                <div class="-mx-5 md:mx-0 -mt-5 md:mt-0">
                <img src="{{ asset('images/berita.png') }}" 
                     class="w-full h-170 md:h-120 object-cover rounded-lg shadow-md" 
                     alt="berita1">
                </div>
                {{-- Thumbnail --}}
                <div class="flex gap-4 md:gap-6 justify-center flex-wrap">
                    <img src="{{ asset('images/berita.png') }}" class="md:w-24 md:h-24 w-48 h-48 object-cover rounded-lg shadow" alt="berita1">
                    <img src="{{ asset('images/berita.png') }}" class="md:w-24 md:h-24 w-48 h-48 object-cover rounded-lg shadow" alt="berita1">
                    <img src="{{ asset('images/berita.png') }}" class="md:w-24 md:h-24 w-48 h-48 object-cover rounded-lg shadow" alt="berita1">
                </div>

                {{-- Sumber Berita Desktop--}}
                <div class="hidden md:block space-y-2 text-center">
                    <p class="text-sm font-semibold text-center">Sumber</p>
                    <a href="https://kmp.im/plus6" target="_blank"
                       class="block text-blue-500 underline border border-secondary py-3 px-3 rounded-lg hover:bg-blue-50">
                        Baca berita lengkap di Kompas.com
                    </a>
                </div>
            </div>

            {{-- Kolom Kanan --}}
            <div class="md:col-span-8 space-y-6">
                {{-- Judul Desktop --}}
                <h2 class="hidden md:block text-5xl md:text-4xl font-bold leading-snug">
                    Gibran Tinjau Pasar Rogojampi, Pedagang Harapkan Harga Bahan Pokok Turun
                </h2>

                <div class="space-y-5 text-justify leading-relaxed text-4xl md:text-lg">
                    <p>
                        Wakil Presiden (Wapres) RI Gibran Rakabuming blusukan meninjau kegiatan di Pasar Cipulir, Kebayoran
                        Lama, Jakarta Selatan, Kamis (4/9/2025) malam. Adapun Gibran tiba di pasar sekitar pukul 23.45 WIB
                        usai mengecek Sistem Keamanan Lingkungan (Siskamling) di Kawasan Kembangan, Jakarta Barat dan Kawasan
                        Pesanggrahan, Jakarta Selatan. Dari siaran YouTube Wakil Presiden Republik Indonesia, Gibran terlihat
                        menyusuri Jalan Ciledug Raya yang dipenuhi lapak pedagang.
                    </p>

                    <p>
                        Setiap mendatangi lapak para pedagang, Gibran terlihat berbincang singkat dengan penjualnya. Selain
                        mengecek situasi perekonomian pasca aksi demonstrasi pada Agustus lalu, ia sekaligus berbelanja
                        untuk mendukung perekonomian rakyat.
                    </p>

                    <p>
                        Tampak Gibran berkeliling dan memborong dagangan dari lapak penjual sayuran, ikan, ayam, hingga bumbu
                        dapur. Tidak sedikit juga warga baik pedagang dan pembeli yang mengerumuni untuk berfoto dan
                        menyalami Gibran. Gibran berharap aktivitas masyarakat, khususnya di pasar tradisional sebagai pusat
                        perputaran ekonomi rakyat, dapat terus berjalan normal.
                    </p>

                    <p>
                        Dia juga menegaskan pentingnya menjaga ketenangan bersama agar roda ekonomi tetap berputar dan
                        kepercayaan publik terhadap stabilitas nasional semakin kuat.
                    </p>

                    <p>
                        Menurutnya, stabilitas bukan hanya ditopang oleh keamanan, tetapi juga oleh terjaganya denyut
                        ekonomi rakyat. Adapun langkah ini sejalan dengan arahan Presiden Prabowo Subianto yang menekankan
                        pentingnya menjaga stabilitas tidak hanya dari sisi keamanan, tetapi juga melalui penguatan ekonomi
                        rakyat.
                    </p>
                </div>
                {{-- Sumber Berita Mobile --}}
                <div class="block md:hidden mt-8 pt-6 space-y-2">
                    <p class="text-center text-2xl font-semibold">Sumber</p>
                    <a href="https://kmp.im/plus6" target="_blank"
                       class="block text-center text-2xl text-blue-500 underline border border-blue-400 py-3 px-4 rounded-lg hover:bg-blue-50 transition">
                        Baca berita lengkap di Kompas.com
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

