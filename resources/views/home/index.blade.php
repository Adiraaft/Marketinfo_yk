@extends('layouts.home')

@section('title', 'Home')

@section('navbar')
    <x-navbar-transparent />
@endsection

@section('jumbotron')
    <div class="relative w-screen h-screen bg-center bg-cover bg-no-repeat"
        style="background-image: url('{{ asset('images/jumbotron.png') }}')">
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="relative z-10 flex flex-col items-start justify-center h-full text-white pl-15">
            <h1 class="text-4xl font-extrabold">
                Harga Komoditas Bahan <br> Pangan
                <span class="text-[#FB7A29]">Kota Yogyakarta</span>
            </h1>
            <p class="mt-2 font-semibold">
                Hadirkan data harga pangan terkini dari seluruh pasar Yogyakarta. <br>
                Bantu masyarakat dan pelaku usaha mengambil keputusan yang lebih bijak.
            </p>
        </div>
    </div>
@endsection

@section('content')
    <div class="mt-8 px-15">
        <h3 class="font-bold text-2xl">Harga Barang Komuditas Bahan Pangan Kota Yogyakarta</h3>
        <div class="my-7 py-6 border rounded-lg border-gray-300">
            <div class="flex gap-4 mx-12">
                <div>
                    <label for="kategori" class="block">Pilih Kategori</label>
                    <select id="kategori" name="kategori"
                        class="border border-gray-300 rounded-lg p-1 w-60 focus:ring-blue-500 focus:border-blue-500">
                        <option value="#">Semua Kategori</option>
                        <option value="beras">Beras</option>
                        <option value="cabai">Cabai</option>
                        <option value="telur">Telur</option>
                    </select>
                </div>
                <div>
                    <label for="kategori" class="block">Pilih Bahan Komoditas</label>
                    <select id="kategori" name="kategori"
                        class="border border-gray-300 rounded-lg p-1 w-60 focus:ring-blue-500 focus:border-blue-500">
                        <option value="#">Semua Komoditas</option>
                        <option value="beras">Beras</option>
                        <option value="cabai">Cabai</option>
                        <option value="telur">Telur</option>
                    </select>
                </div>
                <button class="p-2 w-8 h-8 rounded-lg bg-secondary self-end cursor-pointer">
                    <i data-lucide="search" class="place-self-center w-4 h-4 text-white"></i>
                </button>
            </div>
            <hr class="mt-6 opacity-20">
            <div class="flex my-6 mx-12 gap-5">
                <button class="py-2 px-6 rounded-lg border-2 border-gray-300 active:bg-gray-300 hover:bg-gray-300">Rata -
                    Rata</button>
                <button
                    class="py-2 px-6 rounded-lg border-2 active:border-red-200 hover:border-red-200 border-gray-300 text-red-500 active:bg-red-200 hover:bg-red-200">Harga
                    Tertinggi</button>
                <button
                    class="py-2 px-6 rounded-lg border-2 active:border-green-200 hover:border-green-200 border-gray-300 text-green-500 active:bg-green-200 hover:bg-green-200">Harga
                    Terendah</button>
            </div>
            {{-- card --}}
            <div class="mx-12 mb-6 grid grid-cols-3 gap-9">
                {{-- card 1 --}}
                <div class="flex pt-4 pl-4 border border-gray-300 h-auto rounded-2xl  ">
                    <div>
                        <img src="{{ asset('images/tomat.png') }}" alt="#">
                        <div class="flex text-green-500 items-center text-xs mt-4 mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p>2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="ml-4 mt-4">
                        <p class="font-bold">Tomat</p>
                        <span class="flex justify-center gap-2">
                            <p class="text-sm">Rp. 16.012 - 21.500 /Kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </span>
                    </div>
                </div>
                {{-- card 2 --}}
                <div class="flex pt-4 pl-4 border border-gray-300 h-auto rounded-2xl">
                    <div>
                        <img src="{{ asset('images/bawangP.png') }}" alt="#">
                        <div class="flex text-red-500 items-center text-xs mt-4 mb-6 gap-1">
                            <i data-lucide="move-up" class="h-4 w-4"></i>
                            <p>2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="ml-4 mt-4">
                        <p class="font-bold">Bawang Putih</p>
                        <span class="flex justify-center gap-2">
                            <p class="text-sm">Rp. 16.012 - 21.500 /Kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </span>
                    </div>
                </div>
                {{-- card 3 --}}
                <div class="flex pt-4 pl-4 border border-gray-300 h-auto rounded-2xl">
                    <div>
                        <img src="{{ asset('images/pete.png') }}" alt="#">
                        <div class="flex text-green-500 items-center text-xs mt-4 mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p>2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="ml-4 mt-4">
                        <p class="font-bold">Pete</p>
                        <span class="flex justify-center gap-2">
                            <p class="text-sm">Rp. 11.000/Kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </span>
                    </div>
                </div>
                {{-- card 4 --}}
                <div class="flex pt-4 pl-4 border border-gray-300 h-auto rounded-2xl  ">
                    <div>
                        <img src="{{ asset('images/tomat.png') }}" alt="#">
                        <div class="flex text-green-500 items-center text-xs mt-4 mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p>2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="ml-4 mt-4">
                        <p class="font-bold">Tomat</p>
                        <span class="flex justify-center gap-2">
                            <p class="text-sm">Rp. 11.000/Kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </span>
                    </div>
                </div>
                {{-- card 5 --}}
                <div class="flex pt-4 pl-4 border border-gray-300 h-auto rounded-2xl">
                    <div>
                        <img src="{{ asset('images/bawangP.png') }}" alt="#">
                        <div class="flex text-red-500 items-center text-xs mt-4 mb-6 gap-1">
                            <i data-lucide="move-up" class="h-4 w-4"></i>
                            <p>2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="ml-4 mt-4">
                        <p class="font-bold">Bawang Putih</p>
                        <span class="flex justify-center gap-2">
                            <p class="text-sm">Rp. 16.012 - 21.500 /Kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </span>
                    </div>
                </div>
                {{-- card 6 --}}
                <div class="flex pt-4 pl-4 border border-gray-300 h-auto rounded-2xl">
                    <div>
                        <img src="{{ asset('images/pete.png') }}" alt="#">
                        <div class="flex text-green-500 items-center text-xs mt-4 mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p>2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="ml-4 mt-4">
                        <p class="font-bold">Pete</p>
                        <span class="flex justify-center gap-2">
                            <p class="text-sm">Rp. 11.000/Kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </span>
                    </div>
                </div>
                {{-- card 7 --}}
                <div class="flex pt-4 pl-4 border border-gray-300 h-auto rounded-2xl  ">
                    <div>
                        <img src="{{ asset('images/tomat.png') }}" alt="#">
                        <div class="flex text-green-500 items-center text-xs mt-4 mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p>2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="ml-4 mt-4">
                        <p class="font-bold">Tomat</p>
                        <span class="flex justify-center gap-2">
                            <p class="text-sm">Rp. 11.000/Kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </span>
                    </div>
                </div>
                {{-- card 8 --}}
                <div class="flex pt-4 pl-4 border border-gray-300 h-auto rounded-2xl">
                    <div>
                        <img src="{{ asset('images/bawangP.png') }}" alt="#">
                        <div class="flex text-red-500 items-center text-xs mt-4 mb-6 gap-1">
                            <i data-lucide="move-up" class="h-4 w-4"></i>
                            <p>2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="ml-4 mt-4">
                        <p class="font-bold">Bawang Putih</p>
                        <span class="flex justify-center gap-2">
                            <p class="text-sm">Rp. 16.012 - 21.500 /Kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </span>
                    </div>
                </div>
                {{-- card 9 --}}
                <div class="flex pt-4 pl-4 border border-gray-300 h-auto rounded-2xl">
                    <div>
                        <img src="{{ asset('images/pete.png') }}" alt="#">
                        <div class="flex text-green-500 items-center text-xs mt-4 mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p>2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="ml-4 mt-4">
                        <p class="font-bold">Pete</p>
                        <span class="flex justify-center gap-2">
                            <p class="text-sm">Rp. 11.000/Kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="flex gap-2 justify-center">
                <button class="p-2 rounded-lg border-2 border-gray-300 hover:bg-gray-300">Sebelumnya</button>
                <button
                    class="py-2 px-3 rounded-lg border-2 border-gray-300 active:bg-slate-500 hover:bg-slate-500">1</button>
                <button
                    class="py-2 px-3 rounded-lg border-2 border-gray-300 active:bg-slate-500 hover:bg-slate-500">2</button>
                <button
                    class="py-2 px-3 rounded-lg border-2 border-gray-300 active:bg-slate-500 hover:bg-slate-500">3</button>
                <button
                    class="py-2 px-3 rounded-lg border-2 border-gray-300 active:bg-slate-500 hover:bg-slate-500">...</button>
                <button
                    class="py-2 px-3 rounded-lg border-2 border-gray-300 active:bg-slate-500 hover:bg-slate-500">10</button>
                <button class="p-2 rounded-lg border-2 border-gray-300 hover:bg-gray-300">Selanjutnya</button>
            </div>
        </div>
    </div>

    <div class="bg-primary px-12 py-9 mb-7 mx-15 rounded-lg">
        <p class="text-4xl text-white text-center font-bold">Berita Terbaru</p>
        <div class="flex gap-6 justify-center mt-10 mx-12 items-stretch">
            {{-- kiri --}}
            <div class="flex-1 relative">
                <img src="{{ asset('images/Tberita.png') }}" class="h-full w-full object-cover rounded-lg"
                    alt="#">
                <div class="absolute inset-0 bg-black/20"></div>
                <div class="absolute bottom-4 left-4 text-white px-4 py-2">
                    <h3 class="font-light mb-2 text-2xl">23 Agustus 2025</h3>
                    <h3 class="font-bold text-2xl">Gibran Tinjau Pasar Rogojampi, <br> Pedagang Harapkan Harga Bahan <br>
                        Pokok
                        Turun</h3>
                </div>

                <div class="flex flex-row mt-6 gap-2 justify-center">
                    <button class="bg-secondary/50 active:bg-secondary hover:bg-secondary px-4 py-3 rounded-lg"><i
                            data-lucide="chevron-left" class="text-white w-6 h-6"></i></button>
                    <button class="bg-secondary/50 active:bg-secondary hover:bg-secondary px-4 py-3 rounded-lg"><i
                            data-lucide="chevron-right" class="text-white w-6 h-6"></i></button>
                </div>
            </div>
            {{-- kanan --}}
            <div class="flex-1 flex flex-col gap-7">
                <div class="pt-4 pl-6 pb-5 rounded-lg pr-9 bg-white">
                    <h3 class="text-2xl font-semibold">Harga Telur di Ambon Rp 3.000 Per Butir, Warga: Hidup Semakin Susah
                    </h3>
                    <p class="mt-6 text-xs font-semibold">15 Juli 2025</p>
                </div>
                <div class="pt-4 pl-6 pb-5 rounded-lg pr-9 bg-white">
                    <h3 class="text-2xl font-semibold">Sehari Jelang Idul Adha, Harga Cabai Keriting Naik Rp 20.000, Tomat
                        Rp 3.000
                    </h3>
                    <p class="mt-6 text-xs font-semibold">2 Febuari 2025</p>
                </div>
                <div class="pt-4 pl-6 pb-5 rounded-lg pr-9 bg-white">
                    <h3 class="text-2xl font-semibold">Harga Daging Capai Rp 140.000 Per Kg, Pedagang Keluhkan Omzet
                        Merosot Jelang
                        Lebaran </h3>
                    <p class="mt-6 text-xs font-semibold">7 Maret 2025</p>
                </div>
            </div>
        </div>
        <div class="flex mx-12 mt-6 justify-self-end">
            <a href="#" class="bg-[#FB7A29] py-3 px-12 text-white rounded-lg">
                Berita Lainnya
            </a>
        </div>
    </div>

    <div class="mt-8 px-15">
        <h3 class="font-bold text-2xl">Daftar Harga Bahan Pangan Pasar Kota Yogykarta</h3>
        <div class="my-7 py-6 border rounded-lg border-gray-300">
            <div class="flex items-center justify-between mx-12">
                <!-- Filter dan Search -->
                <div class="flex gap-4 items-end">
                    <div>
                        <label for="pasar" class="block text-sm font-medium">Pilih Pasar</label>
                        <select id="pasar" name="pasar"
                            class="border border-gray-300 rounded-lg p-1 w-60 focus:ring-blue-500 focus:border-blue-500">
                            <option value="#">Semua Pasar</option>
                            <option value="beringharjo">Pasar Beringharjo</option>
                            <option value="kranggan">Pasar Kranggan</option>
                            <option value="demangan">Pasar Demangan</option>
                        </select>
                    </div>

                    <div>
                        <label for="kategori" class="block">Pilih Kategori</label>
                        <select id="kategori" name="kategori"
                            class="border border-gray-300 rounded-lg p-1 w-60 focus:ring-blue-500 focus:border-blue-500">
                            <option value="#">Semua Kategori</option>
                            <option value="beras">Beras</option>
                            <option value="cabai">Cabai</option>
                            <option value="telur">Telur</option>
                        </select>
                    </div>

                    <div>
                        <label for="komoditas" class="block text-sm font-medium">Pilih Bahan Komoditas</label>
                        <select id="komoditas" name="komoditas"
                            class="border border-gray-300 rounded-lg p-1 w-60 focus:ring-blue-500 focus:border-blue-500">
                            <option value="#">Semua Komoditas</option>
                            <option value="beras">Beras</option>
                            <option value="cabai">Cabai</option>
                            <option value="telur">Telur</option>
                        </select>
                    </div>

                    <button class="p-2 w-8 h-8 rounded-lg bg-secondary cursor-pointer flex items-center justify-center">
                        <i data-lucide="search" class="w-4 h-4 text-white"></i>
                    </button>
                </div>

                <!-- Indikator Harga -->
                <div class="flex gap-4 items-center">
                    <div class="flex items-center gap-1 text-red-500">
                        <i data-lucide="move-up" class="w-4 h-4"></i>
                        <p class="text-sm">Harga Naik</p>
                    </div>
                    <div class="flex items-center gap-1 text-green-500">
                        <i data-lucide="move-down" class="w-4 h-4"></i>
                        <p class="text-sm">Harga Turun</p>
                    </div>
                    <div class="flex items-center gap-1">
                        <i data-lucide="minus" class="w-4 h-4"></i>
                        <p class="text-sm">Harga Tetap</p>
                    </div>
                </div>
            </div>

            <hr class="mt-6 opacity-20">
            <div class="flex my-6 mx-12 gap-2 p-2 border-2 bg-gray-200 w-fit rounded-lg border-secondary">
                <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                <p>Menampilkan harga rata-rata di Kota Yogyakarta, pilih pasar dan barang untuk harga yang lebih akurat</p>
            </div>
            {{-- card --}}
            <div class="mx-12 mb-6 grid grid-cols-3 gap-9">
                {{-- card 1 --}}
                <div class="flex pt-4 pl-4 border border-gray-300 h-auto rounded-2xl  ">
                    <div>
                        <img src="{{ asset('images/tomat.png') }}" alt="#">
                        <div class="flex text-green-500 items-center text-xs mt-4 mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p>2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="ml-4 mt-4">
                        <p class="font-bold">Tomat</p>
                        <span class="flex justify-center gap-2">
                            <p class="text-sm">Rp. 16.012 - 21.500 /Kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </span>
                    </div>
                </div>
                {{-- card 2 --}}
                <div class="flex pt-4 pl-4 border border-gray-300 h-auto rounded-2xl">
                    <div>
                        <img src="{{ asset('images/bawangP.png') }}" alt="#">
                        <div class="flex text-red-500 items-center text-xs mt-4 mb-6 gap-1">
                            <i data-lucide="move-up" class="h-4 w-4"></i>
                            <p>2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="ml-4 mt-4">
                        <p class="font-bold">Bawang Putih</p>
                        <span class="flex justify-center gap-2">
                            <p class="text-sm">Rp. 16.012 - 21.500 /Kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </span>
                    </div>
                </div>
                {{-- card 3 --}}
                <div class="flex pt-4 pl-4 border border-gray-300 h-auto rounded-2xl">
                    <div>
                        <img src="{{ asset('images/pete.png') }}" alt="#">
                        <div class="flex text-green-500 items-center text-xs mt-4 mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p>2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="ml-4 mt-4">
                        <p class="font-bold">Pete</p>
                        <span class="flex justify-center gap-2">
                            <p class="text-sm">Rp. 16.012 - 21.500 /Kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </span>
                    </div>
                </div>
                {{-- card 4 --}}
                <div class="flex pt-4 pl-4 border border-gray-300 h-auto rounded-2xl  ">
                    <div>
                        <img src="{{ asset('images/tomat.png') }}" alt="#">
                        <div class="flex text-green-500 items-center text-xs mt-4 mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p>2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="ml-4 mt-4">
                        <p class="font-bold">Tomat</p>
                        <span class="flex justify-center gap-2">
                            <p class="text-sm">Rp. 16.012 - 21.500 /Kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </span>
                    </div>
                </div>
                {{-- card 5 --}}
                <div class="flex pt-4 pl-4 border border-gray-300 h-auto rounded-2xl">
                    <div>
                        <img src="{{ asset('images/bawangP.png') }}" alt="#">
                        <div class="flex text-red-500 items-center text-xs mt-4 mb-6 gap-1">
                            <i data-lucide="move-up" class="h-4 w-4"></i>
                            <p>2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="ml-4 mt-4">
                        <p class="font-bold">Bawang Putih</p>
                        <span class="flex justify-center gap-2">
                            <p class="text-sm">Rp. 16.012 - 21.500 /Kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </span>
                    </div>
                </div>
                {{-- card 6 --}}
                <div class="flex pt-4 pl-4 border border-gray-300 h-auto rounded-2xl">
                    <div>
                        <img src="{{ asset('images/pete.png') }}" alt="#">
                        <div class="flex text-green-500 items-center text-xs mt-4 mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p>2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="ml-4 mt-4">
                        <p class="font-bold">Pete</p>
                        <span class="flex justify-center gap-2">
                            <p class="text-sm">Rp. 16.012 - 21.500 /Kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </span>
                    </div>
                </div>
                {{-- card 7 --}}
                <div class="flex pt-4 pl-4 border border-gray-300 h-auto rounded-2xl  ">
                    <div>
                        <img src="{{ asset('images/tomat.png') }}" alt="#">
                        <div class="flex text-green-500 items-center text-xs mt-4 mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p>2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="ml-4 mt-4">
                        <p class="font-bold">Tomat</p>
                        <span class="flex justify-center gap-2">
                            <p class="text-sm">Rp. 16.012 - 21.500 /Kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </span>
                    </div>
                </div>
                {{-- card 8 --}}
                <div class="flex pt-4 pl-4 border border-gray-300 h-auto rounded-2xl">
                    <div>
                        <img src="{{ asset('images/bawangP.png') }}" alt="#">
                        <div class="flex text-red-500 items-center text-xs mt-4 mb-6 gap-1">
                            <i data-lucide="move-up" class="h-4 w-4"></i>
                            <p>2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="ml-4 mt-4">
                        <p class="font-bold">Bawang Putih</p>
                        <span class="flex justify-center gap-2">
                            <p class="text-sm">Rp. 16.012 - 21.500 /Kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </span>
                    </div>
                </div>
                {{-- card 9 --}}
                <div class="flex pt-4 pl-4 border border-gray-300 h-auto rounded-2xl">
                    <div>
                        <img src="{{ asset('images/pete.png') }}" alt="#">
                        <div class="flex text-green-500 items-center text-xs mt-4 mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p>2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="ml-4 mt-4">
                        <p class="font-bold">Pete</p>
                        <span class="flex justify-center gap-2">
                            <p class="text-sm">Rp. 16.012 - 21.500 /Kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="flex gap-2 justify-center">
                <button class="p-2 rounded-lg border-2 border-gray-300 hover:bg-gray-300">Sebelumnya</button>
                <button
                    class="py-2 px-3 rounded-lg border-2 border-gray-300 active:bg-slate-500 hover:bg-slate-500">1</button>
                <button
                    class="py-2 px-3 rounded-lg border-2 border-gray-300 active:bg-slate-500 hover:bg-slate-500">2</button>
                <button
                    class="py-2 px-3 rounded-lg border-2 border-gray-300 active:bg-slate-500 hover:bg-slate-500">3</button>
                <button
                    class="py-2 px-3 rounded-lg border-2 border-gray-300 active:bg-slate-500 hover:bg-slate-500">...</button>
                <button
                    class="py-2 px-3 rounded-lg border-2 border-gray-300 active:bg-slate-500 hover:bg-slate-500">10</button>
                <button class="p-2 rounded-lg border-2 border-gray-300 hover:bg-gray-300">Selanjutnya</button>
            </div>
        </div>
    </div>

    <div class="bg-white border rounded-lg border-gray-300 py-12 px-16 mx-15 mb-10">
        <h3 class="text-2xl font-bold mb-10 text-gray-800">
            Visualisasi Pasar Kota Yogyakarta
        </h3>

        <div class="grid grid-cols-2 gap-8">
            <!-- MAP -->
            <div class="rounded-2xl overflow-hidden shadow-lg border border-gray-200">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.0526399756865!2d110.36608747469724!3d-7.784727177294295!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a578c00000000%3A0x9e3b99aafab678c7!2sPasar%20Beringharjo!5e0!3m2!1sid!2sid!4v1690800000000!5m2!1sid!2sid"
                    width="100%" height="500" allowfullscreen="" loading="lazy" class="w-full h-[500px]">
                </iframe>
            </div>

            <!-- LIST PASAR -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-200 overflow-y-auto max-h-[500px]">
                <h3 class="text-xl font-semibold mb-4">Daftar Pasar</h3>
                <ul class="space-y-4">
                    <!-- Pasar item -->
                    <li class="flex justify-between items-center border-b pb-3">
                        <div>
                            <p class="font-bold text-gray-800">Pasar Beringharjo</p>
                            <p class="text-sm text-gray-500">Jl. Margo Mulyo, Yogyakarta</p>
                        </div>
                        <button
                            class="bg-secondary text-white px-4 py-2 rounded-lg hover:bg-secondary/80 flex items-center gap-1">
                            <i data-lucide="map-pin" class="w-4 h-4"></i>
                            Detail
                        </button>
                    </li>
                    <li class="flex justify-between items-center border-b pb-3">
                        <div>
                            <p class="font-bold text-gray-800">Pasar Kranggan</p>
                            <p class="text-sm text-gray-500">Jl. Poncowinatan No.18, Jetis</p>
                        </div>
                        <button
                            class="bg-secondary text-white px-4 py-2 rounded-lg hover:bg-secondary/80 flex items-center gap-1">
                            <i data-lucide="map-pin" class="w-4 h-4"></i>
                            Detail
                        </button>
                    </li>
                    <li class="flex justify-between items-center border-b pb-3">
                        <div>
                            <p class="font-bold text-gray-800">Pasar Demangan</p>
                            <p class="text-sm text-gray-500">Jl. Gejayan, Yogyakarta</p>
                        </div>
                        <button
                            class="bg-secondary text-white px-4 py-2 rounded-lg hover:bg-secondary/80 flex items-center gap-1">
                            <i data-lucide="map-pin" class="w-4 h-4"></i>
                            Detail
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>


@endsection
