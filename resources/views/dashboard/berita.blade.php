@extends('layouts.admin')

@section('title', 'Daftar Berita')

@section('navbar')
    <x-navbar-dashboard />
@endsection

@section('content')
    <div class="mx-15 mt-6 mb-10">
        {{-- Header + Tombol Tambah --}}
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-secondary">Daftar Berita</h3>
            <a href="{{ route('superadmin.berita.create') }}"
                class="bg-secondary text-white px-5 py-2 rounded-lg hover:bg-blue-600 transition">
                + Tambah Berita
            </a>
        </div>

        {{-- Notifikasi --}}
        @if (session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-5">
                {{ session('success') }}
            </div>
        @endif

        {{-- Grid Card Berita --}}
        <div class="mt-6 bg-white rounded-lg shadow-md overflow-hidden p-6">
            @if ($berita->isEmpty())
                <p class="text-gray-400 text-center py-6">Belum ada berita yang ditambahkan.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($berita as $item)
                        {{-- Card --}}
                        <a href="{{ route('superadmin.berita.edit', ['berita' => $item->id]) }}"
                            class="relative group block rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300">

                            {{-- Gambar Utama --}}
                            @if ($item->image1)
                                <img src="{{ asset('storage/' . $item->image1) }}" alt="Gambar Berita"
                                    class="w-full h-80 object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-64 bg-gray-300 flex items-center justify-center">
                                    <i data-lucide="image" class="text-gray-500 h-10 w-10"></i>
                                </div>
                            @endif

                            {{-- Overlay Gelap --}}
                            <div
                                class="absolute inset-0 bg-black/40 group-hover:bg-black/50 transition-colors duration-300">
                            </div>

                            {{-- Judul di atas Gambar --}}
                            <div class="absolute inset-0 flex items p-4">
                                <h3
                                    class="text-white text-2xl font-bold text-left drop-shadow-lg line-clamp-2 group-hover:text-blue-200 transition">
                                    {{ $item->title }}
                                </h3>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
@endsection
