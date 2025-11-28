@extends('layouts.home')

@section('title', 'Berita')

@section('navbar')
    <x-navbar-color />
@endsection

@section('content')
    <div class="mx-15 mt-6">

        <h2 class="text-3xl font-bold">Berita Pasar Terkini</h2>
        <p class="text-gray-500 mt-2">Informasi terbaru seputar harga dan tren pasar</p>

        {{-- Grid Berita --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 mt-6 gap-x-5 gap-y-9">

            @forelse ($berita as $item)
                <div class="w-full space-y-5">

                    {{-- Gambar Berita --}}
                    <div class="relative">
                        @if ($item->image1)
                            <img src="{{ asset('storage/' . $item->image1) }}" alt="berita"
                                class="w-full h-56 object-cover rounded-lg">
                        @else
                            <div class="w-full h-56 bg-gray-200 rounded-lg flex items-center justify-center">
                                <span class="text-gray-500">Tidak ada gambar</span>
                            </div>
                        @endif

                        <p class="absolute bottom-3 right-3 text-sm px-4 py-2 text-white bg-secondary rounded-lg">
                            {{ $item->created_at->format('d M Y') }}
                        </p>
                    </div>

                    {{-- Judul + Deskripsi --}}
                    <div class="space-y-3">
                        <p class="text-xl font-bold line-clamp-2">
                            {{ $item->title }}
                        </p>

                        <p class="line-clamp-3 text-gray-700">
                            {{ $item->description }}
                        </p>

                        <a href="{{ route('berita.detail', $item->id) }}">
                            Baca Selengkapnya
                        </a>

                    </div>

                </div>
            @empty

                <p class="text-gray-500 col-span-3 text-center py-10">
                    Belum ada berita tersedia.
                </p>
            @endforelse

        </div>

        {{-- PAGINATION (opsional kalau mau) --}}
        {{-- {{ $berita->links() }} --}}

        {{-- Placeholder Pagination (punyamu) --}}
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
