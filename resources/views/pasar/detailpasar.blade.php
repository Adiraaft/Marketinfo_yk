@extends('layouts.home')

@section('title', 'Detail Pasar')

@section('navbar')
    <x-navbar-color />

@endsection

@section('content')
    <div class="mx-15 mt-5 mb-20">
        <a href="{{ route('pasar.pasar') }}" class="text-blue-500 hover:underline mt-3 inline-block">
            ← Kembali
        </a>
        <h2 class="text-5xl font-bold mt-4">Pasar Beringharjo</h2>
        <div class="grid grid-cols-12 mt-6 gap-8">
            {{-- kiri (4 kolom) --}}
            <div class="col-span-12 md:col-span-4 space-y-5">
                <img src="{{ asset('images/berita.png') }}" class="w-full h-120 object-cover rounded-lg" alt="berita1">

                <div class="flex gap-3 justify-center">
                    <img src="{{ asset('images/berita.png') }}" class="w-20 h-20 object-cover rounded-lg" alt="berita1">
                    <img src="{{ asset('images/berita.png') }}" class="w-20 h-20 object-cover rounded-lg" alt="berita1">
                    <img src="{{ asset('images/berita.png') }}" class="w-20 h-20 object-cover rounded-lg" alt="berita1">
                    <img src="{{ asset('images/berita.png') }}" class="w-20 h-20 object-cover rounded-lg" alt="berita1">
                    <img src="{{ asset('images/berita.png') }}" class="w-20 h-20 object-cover rounded-lg" alt="berita1">
                </div>
            </div>

            {{-- kanan (8 kolom) --}}
            <div class="col-span-12 md:col-span-8 space-y-4">
                <h2 class="text-2xl font-bold">Detail</h2>
                <div class="space-y-4 text-justify leading-relaxed">
                    <p>
                        Pasar Beringharjo adalah pasar tertua dan salah satu ikon bersejarah di Yogyakarta yang terletak
                        tidak jauh dari
                        Jalan Malioboro. Pasar ini bukan hanya pusat perbelanjaan berbagai macam produk khas Yogyakarta
                        seperti batik, pakaian, cenderamata, makanan, dan kerajinan tangan, tetapi juga memiliki makna
                        filosofis karena namanya berasal dari kata "bering" (pohon beringin) dan "harjo" (kesejahteraan),
                        yang mencerminkan harapan agar pasar ini membawa kemakmuran bagi masyarakat.
                    </p>

                    <p>
                        Produk dan Daya Tarik
                        Batik: Pasar ini dikenal sebagai pusatnya batik, menjual berbagai jenis batik tulis, cap, dan
                        kombinasi.
                        Oleh-Oleh Khas Jogja: Pengunjung bisa menemukan berbagai oleh-oleh seperti makanan khas (bakpia,
                        gudeg kaleng), pakaian tradisional (kebaya, surjan), kerajinan tangan (anyaman, kulit), dan
                        aksesoris etnik.
                        Jajanan dan Makanan: Terdapat berbagai macam jajanan pasar, makanan siap saji, dan kuliner seperti
                        pecel yang banyak dijual di sekitar pasar.
                    </p>

                    <h2 class="text-2xl font-bold">Jam Buka</h2>
                    <h2 class="text-lg">05.00 - 18.00</h2>
                    <h2 class="text-2xl font-bold">Lokasi</h2>
                    <div class="space-y-2">
                        <a href="https://kmp.im/plus6" target="_blank" class="flex items-center gap-2  text-blue-500 underline border border-secondary py-3 px-3 rounded-lg">
                            <i data-lucide="navigation" class="w-4 h-4 text-black" ></i>
                            Jl. Pabringan, Ngupasan, Kec. Gondomanan, Kota Yogyakarta, Daerah Istimewa Yogyakarta
                        </a>
                    </div>






                </div>

            </div>
        </div>

    </div>
@endsection
