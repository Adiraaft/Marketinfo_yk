@extends('layouts.home')

@section('title', 'Home')

@section('navbar')
    <x-navbar-color />
@endsection

@section('content')
    <div class="mt-8 px-15 mb-8">
        <h3 class="font-bold text-[24px]">Pasar Kota Yogyakarta</h3>

        <!-- Filter Pasar (optional bisa dibuat dinamis juga nanti) -->
        <div class="mt-4 flex gap-4">
            <div>
                <label for="kategori" class="block">Pilih Pasar</label>
                <select id="kategori" name="kategori"
                    class="border border-gray-300 rounded-lg p-1 w-60 focus:ring-blue-500 focus:border-blue-500">
                    <option value="#">Semua Pasar</option>
                    @foreach ($markets as $market)
                        <option value="{{ $market->id_market }}">{{ $market->name_market }}</option>
                    @endforeach
                </select>
            </div>
            <button class="p-2 w-8 h-8 rounded-lg bg-secondary self-end cursor-pointer">
                <i data-lucide="search" class="place-self-center w-4 h-4 text-white"></i>
            </button>
        </div>

        <!-- Card pasar dinamis -->
        <div class="grid grid-cols-2 w-auto space-x-4">

            @foreach ($markets as $market)
                <a href="{{ route('pasar.detail', $market->id_market) }}" class="block">
                    <div class="grid grid-cols-2 mt-4 p-7 border-2 border-gray-300 rounded-2xl hover:shadow-lg transition">
                        <div>
                            <img src="{{ asset('storage/' . $market->image) }}" class="w-100 h-50 object-cover rounded-lg">
                        </div>
                        <div class="ml-4">
                            <h6 class="font-bold">{{ $market->name_market }}</h6>
                            <p class="text-justify">
                                {{ Str::limit($market->description, 150) }}
                            </p>
                        </div>
                    </div>
                </a>
            @endforeach

        </div>
    </div>
@endsection
