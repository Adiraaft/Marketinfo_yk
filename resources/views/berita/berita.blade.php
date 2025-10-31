@extends('layouts.home')

@section('title', 'Berita')

@section('navbar')
    <x-navbar-color />

@endsection

@section('content')
    <div class="mx-15 mt-6">
        <h2 class="text-3xl font-bold">Berita Pasar Terkini</h2>
        <p class="text-gray-500 mt-2">Informasi terbaru seputar harga dan tren pasar</p>
        {{-- Card --}}
        <div class="grid grid-cols-3 mt-6 gap-x-5 gap-y-9">
            <div class="w-full space-y-5">
                <div class="relative">
                    <img src="{{ asset('images/berita.png') }}" alt="berita" class="w-full">
                    <p class="absolute bottom-3 right-3 text-sm px-4 py-2 text-white bg-secondary rounded-lg">
                        23 Agustus 2025
                    </p>
                </div>
                <div class="space-y-3">
                    <!-- Teks ini akan terpotong jadi satu baris + ... -->
                    <p class="text-xl font-bold line-clamp-2 w-full">
                        Gibran Tinjau Pasar Rogojampi, Pedagang Harapkan Harga Bahan Pokok Turun
                    </p>
                    <p class="line-clamp-3">
                        Wakil Presiden (Wapres) RI Gibran Rakabuming blusukan meninjau kegiatan di Pasar Cipulir, Kebayoran
                        Lama, Jakarta Selatan, Kamis (4/9/2025) malam.
                    </p>
                    <a href="{{ route('berita.detailberita')}}"
                        class="text-blue-500 hover:underline mt-3 inline-block">
                        Baca Selengkapnya →
                    </a>
                </div>
            </div>
        </div>
        <div class="flex gap-2 justify-center my-10">
            <button class="p-2 rounded-lg border-2 border-gray-300 hover:bg-gray-300">Sebelumnya</button>
            <button class="py-2 px-3 rounded-lg border-2 border-gray-300 active:bg-slate-500 hover:bg-slate-500">1</button>
            <button class="py-2 px-3 rounded-lg border-2 border-gray-300 active:bg-slate-500 hover:bg-slate-500">2</button>
            <button class="py-2 px-3 rounded-lg border-2 border-gray-300 active:bg-slate-500 hover:bg-slate-500">3</button>
            <button
                class="py-2 px-3 rounded-lg border-2 border-gray-300 active:bg-slate-500 hover:bg-slate-500">...</button>
            <button class="py-2 px-3 rounded-lg border-2 border-gray-300 active:bg-slate-500 hover:bg-slate-500">10</button>
            <button class="p-2 rounded-lg border-2 border-gray-300 hover:bg-gray-300">Selanjutnya</button>
        </div>
    </div>
@endsection
