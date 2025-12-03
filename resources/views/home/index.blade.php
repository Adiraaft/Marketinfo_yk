@extends('layouts.home')

@section('title', 'Home')

@section('navbar')
    <x-navbar-transparent />
@endsection

@section('jumbotron')
    <div class="relative w-full h-screen bg-center bg-cover bg-no-repeat"
        style="background-image: url('{{ asset('images/jumbotron.png') }}')">
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="relative z-10 flex flex-col items-start justify-center h-full text-white pl-15">
            <h1 class="text-4xl sm:text-2xl md:text-3xl lg:text-4xl xl:text-5xl 2xl:5xl font-extrabold">
                Harga Komoditas Bahan <br> Pangan
                <span class="text-[#FB7A29]">Kota Yogyakarta</span>
            </h1>
            <p class="mt-2 font-medium text-xl sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl">
                Hadirkan data harga pangan terkini dari seluruh pasar Yogyakarta. <br>
                Bantu masyarakat dan pelaku usaha mengambil keputusan yang lebih bijak.
            </p>
        </div>
    </div>
@endsection

@section('content')
    <div class="mt-8 px-15">
        <h3 class="font-bold text-2xl sm:text-lg md:text-xl lg:2xl xl:3xl 2xl:4xl">Harga Barang Komoditas Bahan Pangan Kota
            Yogyakarta</h3>
        <div class="my-7 py-6 border rounded-lg border-gray-300">
            <div class="flex gap-4 mx-12 text-xl sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl">
                <div>
                    <label for="kategori" class="block">Pilih Kategori</label>
                    <select id="kategori" name="kategori"
                        class="border border-gray-300 rounded-lg p-1 md:w-60 w-auto focus:ring-blue-500 focus:border-blue-500">
                        <option value="#">Semua Kategori</option>
                        <option value="beras">Beras</option>
                        <option value="cabai">Cabai</option>
                        <option value="telur">Telur</option>
                    </select>
                </div>
                <div>
                    <label for="kategori" class="block">Pilih Bahan Komoditas</label>
                    <select id="kategori" name="kategori"
                        class="border border-gray-300 rounded-lg p-1 md:w-60 w-auto focus:ring-blue-500 focus:border-blue-500">
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
            <div class="flex my-6 mx-12 w-auto gap-5 text-lg sm:text-xs md:text-sm xl:text-base 2xl:text-lg">
                <button
                    class="py-2 px-6 rounded-lg border-2 border-gray-300 active:bg-gray-300 hover:bg-gray-300 w-auto">Rata -
                    Rata</button>
                <button
                    class="py-2 px-6 rounded-lg border-2 active:border-red-200 hover:border-red-200 border-gray-300 text-red-500 active:bg-red-200 hover:bg-red-200 w-auto">Harga
                    Tertinggi</button>
                <button
                    class="py-2 px-6 rounded-lg border-2 active:border-green-200 hover:border-green-200 border-gray-300 text-green-500 active:bg-green-200 hover:bg-green-200 w-auto">Harga
                    Terendah</button>
            </div>
            {{-- card --}}
            <div
                class="mx-12 mb-6 grid grid-cols-3 sm:grid md:grid md:grid-cols-2 lg:grid lg:grid-cols-3 xl:grid xl:grid-cols-3 2xl:grid 2xl:grid-cols-3 gap-9 sm:gap-4 md:gap-6 lg:gap-9 xl:gap-9 2xl:gap-9">
                {{-- card 1 --}}
                <div class="md:flex grid pb-4 min-w-full border border-gray-300 h-auto rounded-2xl">
                    {{-- Bagian Gambar --}}
                    <div>
                        <img src="{{ asset('images/tomat.png') }}" alt="#" class="w-full bg-clip-content p-4">
                        {{-- Tampilan Desktop --}}
                        <div class="md:flex hidden text-green-500 items-center text-xs md:mx-4 md:mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="md:mt-4 md:mr-4 md:pl-0 pl-4">
                        <p class="font-bold text-xl sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl md:mt-4">Tomat
                        </p>
                        <div class="flex justify-start md:justify-center gap-2">
                            <p class="text-lg sm:text-xs md:text-sm xl:text-base 2xl:text-lg">Rp. 11.000/kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </div>
                        {{-- Tampilan Mobile --}}
                        <div class="flex md:hidden text-green-500 items-center text-xs mt-4 md:mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                </div>
                {{-- card 2 --}}
                <div class="md:flex grid pb-4 min-w-full border border-gray-300 h-auto rounded-2xl">
                    {{-- Bagian Gambar --}}
                    <div>
                        <img src="{{ asset('images/bawangP.png') }}" alt="#" class="w-full bg-clip-content p-4">
                        {{-- Tampilan Desktop --}}
                        <div class="md:flex hidden text-red-500 items-center text-xs md:mx-4 md:mb-6 gap-1">
                            <i data-lucide="move-up" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="md:mt-4 md:mr-4 md:pl-0 pl-4">
                        <p class="font-bold text-xl sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl md:mt-4">
                            Bawang</p>
                        <div class="flex justify-start md:justify-center gap-2">
                            <p class="w-auto text-lg sm:text-xs md:text-sm xl:text-base 2xl:text-lg">Rp. 11.000/kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </div>
                        {{-- Tampilan Mobile --}}
                        <div class="flex md:hidden text-red-500 items-center text-xs mt-4 md:mb-6 gap-1">
                            <i data-lucide="move-up" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                </div>
                {{-- card 3 --}}
                <div class="md:flex grid pb-4 min-w-full border border-gray-300 h-auto rounded-2xl">
                    {{-- Bagian Gambar --}}
                    <div>
                        <img src="{{ asset('images/pete.png') }}" alt="#" class="w-full bg-clip-content p-4">
                        {{-- Tampilan Desktop --}}
                        <div class="md:flex hidden text-green-500 items-center text-xs md:mx-4 md:mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="md:mt-4 md:mr-4 md:pl-0 pl-4">
                        <p class="font-bold text-xl sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl md:mt-4">Pete
                        </p>
                        <div class="flex justify-start md:justify-center gap-2">
                            <p class="text-lg sm:text-xs md:text-sm xl:text-base 2xl:text-lg">Rp. 11.000/kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </div>
                        {{-- Tampilan Mobile --}}
                        <div class="flex md:hidden text-green-500 items-center text-xs mt-4 md:mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                </div>
                {{-- card 4 --}}
                <div class="md:flex grid pb-4 min-w-full border border-gray-300 h-auto rounded-2xl">
                    {{-- Bagian Gambar --}}
                    <div>
                        <img src="{{ asset('images/tomat.png') }}" alt="#" class="w-full bg-clip-content p-4">
                        {{-- Tampilan Desktop --}}
                        <div class="md:flex hidden text-green-500 items-center text-xs md:mx-4 md:mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="md:mt-4 md:mr-4 md:pl-0 pl-4">
                        <p class="font-bold text-xl sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl md:mt-4">
                            Tomat</p>
                        <div class="flex justify-start md:justify-center gap-2">
                            <p class="text-lg sm:text-xs md:text-sm xl:text-base 2xl:text-lg">Rp. 11.000/kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </div>
                        {{-- Tampilan Mobile --}}
                        <div class="flex md:hidden text-green-500 items-center text-xs mt-4 md:mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                </div>
                {{-- card 5 --}}
                <div class="md:flex grid pb-4 min-w-full border border-gray-300 h-auto rounded-2xl">
                    {{-- Bagian Gambar --}}
                    <div>
                        <img src="{{ asset('images/bawangP.png') }}" alt="#" class="w-full bg-clip-content p-4">
                        {{-- Tampilan Desktop --}}
                        <div class="md:flex hidden text-red-500 items-center text-xs md:mx-4 md:mb-6 gap-1">
                            <i data-lucide="move-up" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="md:mt-4 md:mr-4 md:pl-0 pl-4">
                        <p class="font-bold text-xl sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl md:mt-4">
                            Bawang</p>
                        <div class="flex justify-start md:justify-center gap-2">
                            <p class="text-lg sm:text-xs md:text-sm xl:text-base 2xl:text-lg">Rp. 11.000/kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </div>
                        {{-- Tampilan Mobile --}}
                        <div class="flex md:hidden text-red-500 items-center text-xs mt-4 md:mb-6 gap-1">
                            <i data-lucide="move-up" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                </div>
                {{-- card 6 --}}
                <div class="md:flex grid pb-4 min-w-full border border-gray-300 h-auto rounded-2xl">
                    {{-- Bagian Gambar --}}
                    <div>
                        <img src="{{ asset('images/pete.png') }}" alt="#" class="w-full bg-clip-content p-4">
                        {{-- Tampilan Desktop --}}
                        <div class="md:flex hidden text-green-500 items-center text-xs md:mx-4 md:mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="md:mt-4 md:mr-4 md:pl-0 pl-4">
                        <p class="font-bold text-xl sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl md:mt-4">Pete
                        </p>
                        <div class="flex justify-start md:justify-center gap-2">
                            <p class="text-lg sm:text-xs md:text-sm xl:text-base 2xl:text-lg">Rp. 11.000/kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </div>
                        {{-- Tampilan Mobile --}}
                        <div class="flex md:hidden text-green-500 items-center text-xs mt-4 md:mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                </div>
                {{-- card 7 --}}
                <div class="md:flex grid pb-4 min-w-full border border-gray-300 h-auto rounded-2xl">
                    {{-- Bagian Gambar --}}
                    <div>
                        <img src="{{ asset('images/tomat.png') }}" alt="#" class="w-full bg-clip-content p-4">
                        {{-- Tampilan Desktop --}}
                        <div class="md:flex hidden text-green-500 items-center text-xs md:mx-4 md:mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="md:mt-4 md:mr-4 md:pl-0 pl-4">
                        <p class="font-bold text-xl sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl md:mt-4">
                            Tomat</p>
                        <div class="flex justify-start md:justify-center gap-2">
                            <p class="text-lg sm:text-xs md:text-sm xl:text-base 2xl:text-lg">Rp. 11.000/kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </div>
                        {{-- Tampilan Mobile --}}
                        <div class="flex md:hidden text-green-500 items-center text-xs mt-4 md:mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                </div>
                {{-- card 8 --}}
                <div class="md:flex grid pb-4 min-w-full border border-gray-300 h-auto rounded-2xl">
                    {{-- Bagian Gambar --}}
                    <div>
                        <img src="{{ asset('images/bawangP.png') }}" alt="#" class="w-full bg-clip-content p-4">
                        {{-- Tampilan Desktop --}}
                        <div class="md:flex hidden text-red-500 items-center text-xs md:mx-4 md:mb-6 gap-1">
                            <i data-lucide="move-up" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="md:mt-4 md:mr-4 md:pl-0 pl-4">
                        <p class="font-bold text-xl sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl md:mt-4">
                            Bawang</p>
                        <div class="flex justify-start md:justify-center gap-2">
                            <p class="text-lg sm:text-xs md:text-sm xl:text-base 2xl:text-lg">Rp. 11.000/kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </div>
                        {{-- Tampilan Mobile --}}
                        <div class="flex md:hidden text-red-500 items-center text-xs mt-4 md:mb-6 gap-1">
                            <i data-lucide="move-up" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                </div>
                {{-- card 9 --}}
                <div class="md:flex grid pb-4 min-w-full border border-gray-300 h-auto rounded-2xl">
                    {{-- Bagian Gambar --}}
                    <div>
                        <img src="{{ asset('images/pete.png') }}" alt="#" class="w-full bg-clip-content p-4">
                        {{-- Tampilan Desktop --}}
                        <div class="md:flex hidden text-green-500 items-center text-xs md:mx-4 md:mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="md:mt-4 md:mr-4 md:pl-0 pl-4">
                        <p class="font-bold text-xl sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl md:mt-4">Pete
                        </p>
                        <div class="flex justify-start md:justify-center gap-2">
                            <p class="text-lg sm:text-xs md:text-sm xl:text-base 2xl:text-lg">Rp. 11.000/kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </div>
                        {{-- Tampilan Mobile --}}
                        <div class="flex md:hidden text-green-500 items-center text-xs mt-4 md:mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex gap-2 text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs justify-center">
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

    {{-- Berita --}}
    <div class="bg-primary px-12 py-9 mb-7 mx-15 rounded-lg">
        <p class="text-4xl sm:text-2xl md:text-3xl lg:text-4xl xl:text-5xl 2xl:5xl text-white text-center font-bold">
            Berita Terbaru
        </p>

        <div
            class="flex sm:grid sm:grid-cols-1 md:grid md:grid-cols-1 lg:grid lg:grid-cols-2 xl:grid xl:grid-cols-2 2xl:grid 2xl:grid-cols-2 gap-6 justify-center mt-10 mx-12 items-stretch">

            {{-- KIRI — SWIPER SLIDER --}}
            <div class="flex-1">

                <style>
                    .mySwiper {
                        width: 100%;
                        height: 440px;
                    }
                </style>

                <div class="swiper mySwiper rounded-lg">
                    <div class="swiper-wrapper">

                        {{-- Slide Utama --}}
                        <div class="swiper-slide relative h-[420px] overflow-hidden rounded-lg">
                            <img src="{{ asset('storage/' . $latest->image1) }}"
                                class="absolute inset-0 w-full h-full object-cover" alt="gambar berita">

                            <div class="absolute inset-0 bg-black/30"></div>

                            <div class="absolute bottom-4 left-4 text-white px-4 py-2">
                                <h3 class="font-light mb-2 text-xl">{{ $latest->created_at->format('d F Y') }}</h3>
                                <h3 class="font-bold text-2xl">{{ $latest->title }}</h3>
                            </div>
                        </div>

                        {{-- Slide Lainnya --}}
                        @foreach ($others as $item)
                            <div class="swiper-slide relative h-[420px] overflow-hidden rounded-lg">
                                <img src="{{ asset('storage/' . $item->image1) }}"
                                    class="absolute inset-0 w-full h-full object-cover" alt="gambar berita">

                                <div class="absolute inset-0 bg-black/30"></div>

                                <div class="absolute bottom-4 left-4 text-white px-4 py-2">
                                    <h3 class="font-light mb-2 text-xl">{{ $item->created_at->format('d F Y') }}</h3>
                                    <h3 class="font-bold text-2xl">{{ $item->title }}</h3>
                                </div>
                            </div>
                        @endforeach

                    </div>

                    <div class="swiper-button-prev !text-white"></div>
                    <div class="swiper-button-next !text-white"></div>
                </div>
            </div>

            <div class="flex-1 flex flex-col gap-7">

                @foreach ($others as $item)
                    <a href="{{ route('berita.detail', $item->id) }}"
                        class="flex gap-5 bg-white p-4 rounded-lg hover:bg-gray-100 transition">

                        {{-- Thumbnail --}}
                        <img src="{{ asset('storage/' . $item->image1) }}" class="w-32 h-24 object-cover rounded-lg"
                            alt="gambar berita">

                        <div class="flex flex-col justify-between">
                            <h3 class="text-xl font-semibold">{{ $item->title }}</h3>
                            <p class="text-sm text-gray-600 font-medium">
                                {{ $item->created_at->format('d F Y') }}
                            </p>
                        </div>
                    </a>
                @endforeach

            </div>


        </div>

        <div class="flex mx-12 mt-6 justify-self-end">
            <a href="{{ route('berita.index') }}" class="bg-[#FB7A29] py-3 px-12 text-white rounded-lg text-xl">
                Berita Lainnya
            </a>
        </div>
    </div>




    <div class="mt-8 px-15">
        <h3 class="font-bold text-2xl sm:text-lg md:text-xl lg:2xl xl:3xl 2xl:4xl">Daftar Harga Bahan Pangan Pasar Kota
            Yogykarta</h3>
        <div class="my-7 py-6 border rounded-lg border-gray-300">
            <div
                class="grid grid-rows-2 sm:grid sm:grid-rows-2 md:grid md:grid-rows-2 lg:grid lg:grid-rows-2 xl:flex 2xl:flex items-center justify-between mx-12 mr-8">
                <!-- Filter dan Search -->
                <div class="flex max-w-full gap-4 items-end">
                    <div class="text-xl sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl">
                        <label for="pasar" class="block">Pilih Pasar</label>
                        <select id="pasar" name="pasar"
                            class="border border-gray-300 rounded-lg p-1 focus:ring-blue-500 focus:border-blue-500">
                            <option value="#">Semua Pasar</option>
                            <option value="beringharjo">Pasar Beringharjo</option>
                            <option value="kranggan">Pasar Kranggan</option>
                            <option value="demangan">Pasar Demangan</option>
                        </select>
                    </div>

                    <div class="text-xl sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl">
                        <label for="kategori" class="block">Pilih Kategori</label>
                        <select id="kategori" name="kategori"
                            class="border border-gray-300 rounded-lg p-1 focus:ring-blue-500 focus:border-blue-500">
                            <option value="#">Semua Kategori</option>
                            <option value="beras">Beras</option>
                            <option value="cabai">Cabai</option>
                            <option value="telur">Telur</option>
                        </select>
                    </div>

                    <div class="text-xl sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl">
                        <label for="komoditas" class="block">Pilih Bahan Komoditas</label>
                        <select id="komoditas" name="komoditas"
                            class="border border-gray-300 rounded-lg p-1 focus:ring-blue-500 focus:border-blue-500">
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
                <div class="flex text-lg sm:text-xs md:text-sm xl:text-base 2xl:text-lg gap-4 items-center justify-center">
                    <div class="flex items-center gap-1 text-red-500">
                        <i data-lucide="move-up" class="w-4 h-4"></i>
                        <p>Harga Naik</p>
                    </div>
                    <div class="flex items-center gap-1 text-green-500">
                        <i data-lucide="move-down" class="w-4 h-4"></i>
                        <p>Harga Turun</p>
                    </div>
                    <div class="flex items-center gap-1">
                        <i data-lucide="minus" class="w-4 h-4"></i>
                        <p>Harga Tetap</p>
                    </div>
                </div>
            </div>

            <hr class="mt-6 opacity-20">
            <div
                class="flex text-xl sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl my-6 mx-12 gap-2 p-2 border-2 bg-gray-200 w-fit rounded-lg border-secondary">
                <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                <p>Menampilkan harga rata-rata di Kota Yogyakarta, pilih pasar dan barang untuk harga yang lebih akurat</p>
            </div>
            {{-- card --}}
            <div
                class="mx-12 mb-6 grid grid-cols-3 sm:grid md:grid md:grid-cols-2 lg:grid lg:grid-cols-3 xl:grid xl:grid-cols-3 2xl:grid 2xl:grid-cols-3 gap-9 sm:gap-4 md:gap-6 lg:gap-9 xl:gap-9 2xl:gap-9">
                {{-- card 1 --}}
                <div class="md:flex grid pb-4 min-w-full border border-gray-300 h-auto rounded-2xl">
                    {{-- Bagian Gambar --}}
                    <div>
                        <img src="{{ asset('images/tomat.png') }}" alt="#" class="w-full bg-clip-content p-4">
                        {{-- Tampilan Desktop --}}
                        <div class="md:flex hidden text-green-500 items-center text-xs md:mx-4 md:mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="md:mt-4 md:mr-4 md:pl-0 pl-4">
                        <p class="font-bold text-xl sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl md:mt-4">
                            Tomat</p>
                        <div class="flex justify-start md:justify-center gap-2">
                            <p class="text-lg sm:text-xs md:text-sm xl:text-base 2xl:text-lg">Rp. 11.000/kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </div>
                        {{-- Tampilan Mobile --}}
                        <div class="flex md:hidden text-green-500 items-center text-xs mt-4 md:mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                </div>
                {{-- card 2 --}}
                <div class="md:flex grid pb-4 min-w-full border border-gray-300 h-auto rounded-2xl">
                    {{-- Bagian Gambar --}}
                    <div>
                        <img src="{{ asset('images/bawangP.png') }}" alt="#" class="w-full bg-clip-content p-4">
                        {{-- Tampilan Desktop --}}
                        <div class="md:flex hidden text-red-500 items-center text-xs md:mx-4 md:mb-6 gap-1">
                            <i data-lucide="move-up" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="md:mt-4 md:mr-4 md:pl-0 pl-4">
                        <p class="font-bold text-xl sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl md:mt-4">
                            Bawang</p>
                        <div class="flex justify-start md:justify-center gap-2">
                            <p class="text-lg sm:text-xs md:text-sm xl:text-base 2xl:text-lg">Rp. 11.000/kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </div>
                        {{-- Tampilan Mobile --}}
                        <div class="flex md:hidden text-red-500 items-center text-xs mt-4 md:mb-6 gap-1">
                            <i data-lucide="move-up" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                </div>
                {{-- card 3 --}}
                <div class="md:flex grid pb-4 min-w-full border border-gray-300 h-auto rounded-2xl">
                    {{-- Bagian Gambar --}}
                    <div>
                        <img src="{{ asset('images/pete.png') }}" alt="#" class="w-full bg-clip-content p-4">
                        {{-- Tampilan Desktop --}}
                        <div class="md:flex hidden text-green-500 items-center text-xs md:mx-4 md:mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="md:mt-4 md:mr-4 md:pl-0 pl-4">
                        <p class="font-bold text-xl sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl md:mt-4">Pete
                        </p>
                        <div class="flex justify-start md:justify-center gap-2">
                            <p class="text-lg sm:text-xs md:text-sm xl:text-base 2xl:text-lg">Rp. 11.000/kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </div>
                        {{-- Tampilan Mobile --}}
                        <div class="flex md:hidden text-green-500 items-center text-xs mt-4 md:mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                </div>
                {{-- card 4 --}}
                <div class="md:flex grid pb-4 min-w-full border border-gray-300 h-auto rounded-2xl">
                    {{-- Bagian Gambar --}}
                    <div>
                        <img src="{{ asset('images/tomat.png') }}" alt="#" class="w-full bg-clip-content p-4">
                        {{-- Tampilan Desktop --}}
                        <div class="md:flex hidden text-green-500 items-center text-xs md:mx-4 md:mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="md:mt-4 md:mr-4 md:pl-0 pl-4">
                        <p class="font-bold text-xl sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl md:mt-4">
                            Tomat</p>
                        <div class="flex justify-start md:justify-center gap-2">
                            <p class="text-lg sm:text-xs md:text-sm xl:text-base 2xl:text-lg">Rp. 11.000/kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </div>
                        {{-- Tampilan Mobile --}}
                        <div class="flex md:hidden text-green-500 items-center text-xs mt-4 md:mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                </div>
                {{-- card 5 --}}
                <div class="md:flex grid pb-4 min-w-full border border-gray-300 h-auto rounded-2xl">
                    {{-- Bagian Gambar --}}
                    <div>
                        <img src="{{ asset('images/bawangP.png') }}" alt="#" class="w-full bg-clip-content p-4">
                        {{-- Tampilan Desktop --}}
                        <div class="md:flex hidden text-red-500 items-center text-xs md:mx-4 md:mb-6 gap-1">
                            <i data-lucide="move-up" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="md:mt-4 md:mr-4 md:pl-0 pl-4">
                        <p class="font-bold text-xl sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl md:mt-4">
                            Bawang</p>
                        <div class="flex justify-start md:justify-center gap-2">
                            <p class="text-lg sm:text-xs md:text-sm xl:text-base 2xl:text-lg">Rp. 11.000/kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </div>
                        {{-- Tampilan Mobile --}}
                        <div class="flex md:hidden text-red-500 items-center text-xs mt-4 md:mb-6 gap-1">
                            <i data-lucide="move-up" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                </div>
                {{-- card 6 --}}
                <div class="md:flex grid pb-4 min-w-full border border-gray-300 h-auto rounded-2xl">
                    {{-- Bagian Gambar --}}
                    <div>
                        <img src="{{ asset('images/pete.png') }}" alt="#" class="w-full bg-clip-content p-4">
                        {{-- Tampilan Desktop --}}
                        <div class="md:flex hidden text-green-500 items-center text-xs md:mx-4 md:mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="md:mt-4 md:mr-4 md:pl-0 pl-4">
                        <p class="font-bold text-xl sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl md:mt-4">Pete
                        </p>
                        <div class="flex justify-start md:justify-center gap-2">
                            <p class="text-lg sm:text-xs md:text-sm xl:text-base 2xl:text-lg">Rp. 11.000/kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </div>
                        {{-- Tampilan Mobile --}}
                        <div class="flex md:hidden text-green-500 items-center text-xs mt-4 md:mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                </div>
                {{-- card 7 --}}
                <div class="md:flex grid pb-4 min-w-full border border-gray-300 h-auto rounded-2xl">
                    {{-- Bagian Gambar --}}
                    <div>
                        <img src="{{ asset('images/tomat.png') }}" alt="#" class="w-full bg-clip-content p-4">
                        {{-- Tampilan Desktop --}}
                        <div class="md:flex hidden text-green-500 items-center text-xs md:mx-4 md:mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="md:mt-4 md:mr-4 md:pl-0 pl-4">
                        <p class="font-bold text-xl sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl md:mt-4">
                            Tomat</p>
                        <div class="flex justify-start md:justify-center gap-2">
                            <p class="text-lg sm:text-xs md:text-sm xl:text-base 2xl:text-lg">Rp. 11.000/kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </div>
                        {{-- Tampilan Mobile --}}
                        <div class="flex md:hidden text-green-500 items-center text-xs mt-4 md:mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                </div>
                {{-- card 8 --}}
                <div class="md:flex grid pb-4 min-w-full border border-gray-300 h-auto rounded-2xl">
                    {{-- Bagian Gambar --}}
                    <div>
                        <img src="{{ asset('images/bawangP.png') }}" alt="#" class="w-full bg-clip-content p-4">
                        {{-- Tampilan Desktop --}}
                        <div class="md:flex hidden text-red-500 items-center text-xs md:mx-4 md:mb-6 gap-1">
                            <i data-lucide="move-up" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="md:mt-4 md:mr-4 md:pl-0 pl-4">
                        <p class="font-bold text-xl sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl md:mt-4">
                            Bawang</p>
                        <div class="flex justify-start md:justify-center gap-2">
                            <p class="text-lg sm:text-xs md:text-sm xl:text-base 2xl:text-lg">Rp. 11.000/kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </div>
                        {{-- Tampilan Mobile --}}
                        <div class="flex md:hidden text-red-500 items-center text-xs mt-4 md:mb-6 gap-1">
                            <i data-lucide="move-up" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                </div>
                {{-- card 9 --}}
                <div class="md:flex grid pb-4 min-w-full border border-gray-300 h-auto rounded-2xl">
                    {{-- Bagian Gambar --}}
                    <div>
                        <img src="{{ asset('images/pete.png') }}" alt="#" class="w-full bg-clip-content p-4">
                        {{-- Tampilan Desktop --}}
                        <div class="md:flex hidden text-green-500 items-center text-xs md:mx-4 md:mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="md:mt-4 md:mr-4 md:pl-0 pl-4">
                        <p class="font-bold text-xl sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl md:mt-4">Pete
                        </p>
                        <div class="flex justify-start md:justify-center gap-2">
                            <p class="text-lg sm:text-xs md:text-sm xl:text-base 2xl:text-lg">Rp. 11.000/kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </div>
                        {{-- Tampilan Mobile --}}
                        <div class="flex md:hidden text-green-500 items-center text-xs mt-4 md:mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex gap-2 justify-center">
                <button
                    class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs p-2 rounded-lg border-2 border-gray-300 hover:bg-gray-300">Sebelumnya</button>
                <button
                    class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs py-2 px-3 rounded-lg border-2 border-gray-300 active:bg-slate-500 hover:bg-slate-500">1</button>
                <button
                    class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs py-2 px-3 rounded-lg border-2 border-gray-300 active:bg-slate-500 hover:bg-slate-500">2</button>
                <button
                    class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs py-2 px-3 rounded-lg border-2 border-gray-300 active:bg-slate-500 hover:bg-slate-500">3</button>
                <button
                    class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs py-2 px-3 rounded-lg border-2 border-gray-300 active:bg-slate-500 hover:bg-slate-500">...</button>
                <button
                    class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs py-2 px-3 rounded-lg border-2 border-gray-300 active:bg-slate-500 hover:bg-slate-500">10</button>
                <button
                    class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs p-2 rounded-lg border-2 border-gray-300 hover:bg-gray-300">Selanjutnya</button>
            </div>
        </div>
    </div>

    <!-- LIST PASAR -->
    <div class="bg-white border rounded-lg border-gray-300 py-12 px-16 mx-15 mb-10">
        <h3 class="text-3xl md:text-2xl font-bold mb-10 text-gray-800">
            Visualisasi Pasar Kota Yogyakarta
        </h3>

        <div
            class="flex sm:grid sm:grid-cols-1 md:grid md:grid-cols-1 lg:grid lg:grid-cols-2 xl:grid xl:grid-cols-2 2xl:grid 2xl:grid-cols-2 gap-8">

            <!-- MAP -->
            <div class="rounded-2xl overflow-hidden shadow-lg border border-gray-200"> <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.0526399756865!2d110.36608747469724!3d-7.784727177294295!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a578c00000000%3A0x9e3b99aafab678c7!2sPasar%20Beringharjo!5e0!3m2!1sid!2sid!4v1690800000000!5m2!1sid!2sid"
                    width="100%" height="500" allowfullscreen="" loading="lazy" class="w-full h-[500px]"> </iframe>
            </div>

            <!-- LIST PASAR DINAMIS -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-200 overflow-y-auto max-h-[500px]">
                <h3 class="md:text-xl text-2xl font-bold mb-4">Daftar Pasar</h3>

                <ul class="space-y-4">
                    @foreach ($markets as $pasar)
                        <li class="flex justify-between items-center border-b pb-3">
                            <div>
                                <p
                                    class="font-bold text-xl sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl text-gray-800">
                                    {{ $pasar->name_market }}
                                </p>
                                <p class="text-lg sm:text-xs md:text-sm xl:text-base 2xl:text-lg text-gray-500">
                                    {{ $pasar->address }}
                                </p>
                            </div>

                            <a href="{{ route('pasar.detail', $pasar->id_market) }}"
                                class="bg-secondary text-white px-4 py-2 rounded-lg hover:bg-secondary/80 flex items-center gap-1 text-lg sm:text-xs md:text-sm xl:text-base 2xl:text-lg">
                                <i data-lucide="map-pin" class="w-4 h-4"></i>
                                Detail
                            </a>
                        </li>
                    @endforeach
                </ul>

            </div>
        </div>
    </div>





@endsection
