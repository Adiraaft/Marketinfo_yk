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
        <div class="grid grid-cols-12 sm:grid sm:grid-cols-1 md:grid md:grid-cols-1 lg:grid lg:grid-cols-1 xl:grid xl:gris-cols-1 2xl:grid 2xl:grid-cols-12 mt-6 gap-8">
            {{-- kiri (4 kolom) --}}
            <div class="col-span-12 md:col-span-4 space-y-6">
                <img src="{{ asset('images/berita.png') }}" class="w-full h-135 object-cover rounded-lg" alt="berita1">
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
                <button class="p-2 w-8 h-8 rounded-lg bg-secondary self-end cursor-pointer">
                    <i data-lucide="search" class="place-self-center w-4 h-4 text-white"></i>
                </button>
            </div>
            <hr class="mt-6 opacity-20 mb-6">
            {{-- card --}}
            <div class="mx-12 mb-6 grid grid-cols-3 sm:grid md:grid md:grid-cols-2 lg:grid lg:grid-cols-3 xl:grid xl:grid-cols-3 2xl:grid 2xl:grid-cols-3 gap-9 sm:gap-4 md:gap-6 lg:gap-9 xl:gap-9 2xl:gap-9">
                {{-- card 1 --}}
                <div class="md:flex grid pb-4 min-w-full border border-gray-300 h-auto rounded-2xl">
                    {{--Bagian Gambar--}}
                    <div>
                        <img src="{{ asset('images/tomat.png') }}" alt="#" class="w-full bg-clip-content p-4">
                        {{--Tampilan Desktop--}}
                        <div class="md:flex hidden text-green-500 items-center text-xs md:mx-4 md:mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="md:mt-4 md:mr-4 md:pl-0 pl-4">
                        <p class="font-bold text-xl sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl md:mt-4">Tomat</p>
                        <div class="flex justify-start md:justify-center gap-2">
                            <p class="text-lg sm:text-xs md:text-sm xl:text-base 2xl:text-lg">Rp. 11.000/kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </div>
                        {{--Tampilan Mobile--}}
                        <div class="flex md:hidden text-green-500 items-center text-xs mt-4 md:mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                </div>
                {{-- card 2 --}}
                <div class="md:flex grid pb-4 min-w-full border border-gray-300 h-auto rounded-2xl">
                    {{--Bagian Gambar--}}
                    <div>
                        <img src="{{ asset('images/bawangP.png') }}" alt="#" class="w-full bg-clip-content p-4">
                        {{--Tampilan Desktop--}}
                        <div class="md:flex hidden text-red-500 items-center text-xs md:mx-4 md:mb-6 gap-1">
                            <i data-lucide="move-up" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="md:mt-4 md:mr-4 md:pl-0 pl-4">
                        <p class="font-bold text-xl sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl md:mt-4">Bawang</p>
                        <div class="flex justify-start md:justify-center gap-2">
                            <p class="w-auto text-lg sm:text-xs md:text-sm xl:text-base 2xl:text-lg">Rp. 11.000/kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </div>
                        {{--Tampilan Mobile--}}
                        <div class="flex md:hidden text-red-500 items-center text-xs mt-4 md:mb-6 gap-1">
                            <i data-lucide="move-up" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                </div>
                {{-- card 3 --}}
                <div class="md:flex grid pb-4 min-w-full border border-gray-300 h-auto rounded-2xl">
                    {{--Bagian Gambar--}}
                    <div>
                        <img src="{{ asset('images/pete.png') }}" alt="#" class="w-full bg-clip-content p-4">
                        {{--Tampilan Desktop--}}
                        <div class="md:flex hidden text-green-500 items-center text-xs md:mx-4 md:mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="md:mt-4 md:mr-4 md:pl-0 pl-4">
                        <p class="font-bold text-xl sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl md:mt-4">Pete</p>
                        <div class="flex justify-start md:justify-center gap-2">
                            <p class="text-lg sm:text-xs md:text-sm xl:text-base 2xl:text-lg">Rp. 11.000/kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </div>
                        {{--Tampilan Mobile--}}
                        <div class="flex md:hidden text-green-500 items-center text-xs mt-4 md:mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                </div>
                {{-- card 4 --}}
                <div class="md:flex grid pb-4 min-w-full border border-gray-300 h-auto rounded-2xl">
                    {{--Bagian Gambar--}}
                    <div>
                        <img src="{{ asset('images/tomat.png') }}" alt="#" class="w-full bg-clip-content p-4">
                        {{--Tampilan Desktop--}}
                        <div class="md:flex hidden text-green-500 items-center text-xs md:mx-4 md:mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="md:mt-4 md:mr-4 md:pl-0 pl-4">
                        <p class="font-bold text-xl sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl md:mt-4">Tomat</p>
                        <div class="flex justify-start md:justify-center gap-2">
                            <p class="text-lg sm:text-xs md:text-sm xl:text-base 2xl:text-lg">Rp. 11.000/kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </div>
                        {{--Tampilan Mobile--}}
                        <div class="flex md:hidden text-green-500 items-center text-xs mt-4 md:mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                </div>
                {{-- card 5 --}}
                <div class="md:flex grid pb-4 min-w-full border border-gray-300 h-auto rounded-2xl">
                    {{--Bagian Gambar--}}
                    <div>
                        <img src="{{ asset('images/bawangP.png') }}" alt="#" class="w-full bg-clip-content p-4">
                        {{--Tampilan Desktop--}}
                        <div class="md:flex hidden text-red-500 items-center text-xs md:mx-4 md:mb-6 gap-1">
                            <i data-lucide="move-up" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="md:mt-4 md:mr-4 md:pl-0 pl-4">
                        <p class="font-bold text-xl sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl md:mt-4">Bawang</p>
                        <div class="flex justify-start md:justify-center gap-2">
                            <p class="text-lg sm:text-xs md:text-sm xl:text-base 2xl:text-lg">Rp. 11.000/kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </div>
                        {{--Tampilan Mobile--}}
                        <div class="flex md:hidden text-red-500 items-center text-xs mt-4 md:mb-6 gap-1">
                            <i data-lucide="move-up" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                </div>
                {{-- card 6 --}}
                <div class="md:flex grid pb-4 min-w-full border border-gray-300 h-auto rounded-2xl">
                    {{--Bagian Gambar--}}
                    <div>
                        <img src="{{ asset('images/pete.png') }}" alt="#" class="w-full bg-clip-content p-4">
                        {{--Tampilan Desktop--}}
                        <div class="md:flex hidden text-green-500 items-center text-xs md:mx-4 md:mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="md:mt-4 md:mr-4 md:pl-0 pl-4">
                        <p class="font-bold text-xl sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl md:mt-4">Pete</p>
                        <div class="flex justify-start md:justify-center gap-2">
                            <p class="text-lg sm:text-xs md:text-sm xl:text-base 2xl:text-lg">Rp. 11.000/kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </div>
                        {{--Tampilan Mobile--}}
                        <div class="flex md:hidden text-green-500 items-center text-xs mt-4 md:mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                </div>
                {{-- card 7 --}}
                <div class="md:flex grid pb-4 min-w-full border border-gray-300 h-auto rounded-2xl">
                    {{--Bagian Gambar--}}
                    <div>
                        <img src="{{ asset('images/tomat.png') }}" alt="#" class="w-full bg-clip-content p-4">
                        {{--Tampilan Desktop--}}
                        <div class="md:flex hidden text-green-500 items-center text-xs md:mx-4 md:mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="md:mt-4 md:mr-4 md:pl-0 pl-4">
                        <p class="font-bold text-xl sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl md:mt-4">Tomat</p>
                        <div class="flex justify-start md:justify-center gap-2">
                            <p class="text-lg sm:text-xs md:text-sm xl:text-base 2xl:text-lg">Rp. 11.000/kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </div>
                        {{--Tampilan Mobile--}}
                        <div class="flex md:hidden text-green-500 items-center text-xs mt-4 md:mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                </div>
                {{-- card 8 --}}
                <div class="md:flex grid pb-4 min-w-full border border-gray-300 h-auto rounded-2xl">
                    {{--Bagian Gambar--}}
                    <div>
                        <img src="{{ asset('images/bawangP.png') }}" alt="#" class="w-full bg-clip-content p-4">
                        {{--Tampilan Desktop--}}
                        <div class="md:flex hidden text-red-500 items-center text-xs md:mx-4 md:mb-6 gap-1">
                            <i data-lucide="move-up" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="md:mt-4 md:mr-4 md:pl-0 pl-4">
                        <p class="font-bold text-xl sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl md:mt-4">Bawang</p>
                        <div class="flex justify-start md:justify-center gap-2">
                            <p class="text-lg sm:text-xs md:text-sm xl:text-base 2xl:text-lg">Rp. 11.000/kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </div>
                        {{--Tampilan Mobile--}}
                        <div class="flex md:hidden text-red-500 items-center text-xs mt-4 md:mb-6 gap-1">
                            <i data-lucide="move-up" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                </div>
                {{-- card 9 --}}
                <div class="md:flex grid pb-4 min-w-full border border-gray-300 h-auto rounded-2xl">
                    {{--Bagian Gambar--}}
                    <div>
                        <img src="{{ asset('images/pete.png') }}" alt="#" class="w-full bg-clip-content p-4">
                        {{--Tampilan Desktop--}}
                        <div class="md:flex hidden text-green-500 items-center text-xs md:mx-4 md:mb-6 gap-1">
                            <i data-lucide="move-down" class="h-4 w-4"></i>
                            <p class="text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs">2,5% (Rp 120)</p>
                        </div>
                    </div>
                    <div class="md:mt-4 md:mr-4 md:pl-0 pl-4">
                        <p class="font-bold text-xl sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl md:mt-4">Pete</p>
                        <div class="flex justify-start md:justify-center gap-2">
                            <p class="text-lg sm:text-xs md:text-sm xl:text-base 2xl:text-lg">Rp. 11.000/kg</p>
                            <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        </div>
                        {{--Tampilan Mobile--}}
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
    </div>
@endsection
