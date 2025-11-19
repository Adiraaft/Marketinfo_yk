@extends('layouts.home')

@section('title', 'Detail Berita')

@section('navbar')
    <x-navbar-color />
@endsection

@section('content')
    <div class="mx-6 md:mx-20 mt-6 mb-24">
        <a href="{{ route('berita.index') }}" class="text-blue-500 hover:underline mt-3 hidden md:inline-block ">
            ← Kembali
        </a>

        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-12 xl:grid-cols-12 2xl:grid-cols-12 mt-6 gap-6 md:gap-8">

            {{-- Kolom kiri --}}
            <div class="md:col-span-4 space-y-6">

                {{-- Judul Mobile --}}
                <h2 class="block md:hidden text-5xl md:text-4xl font-bold leading-snug pb-8">
                    {{ $news->title }}
                </h2>

                {{-- Gambar utama --}}
                <div class="-mx-5 md:mx-0 -mt-5 md:mt-0">
                    <img src="{{ asset('storage/' . $news->image1) }}"
                         class="w-full h-170 md:h-120 object-cover rounded-lg shadow-md"
                         alt="berita-utama">
                </div>

                {{-- Thumbnail --}}
                <div class="flex gap-4 md:gap-6 justify-center flex-wrap">
                    @foreach (['image2', 'image3', 'image4'] as $img)
                        @if ($news->$img)
                            <img src="{{ asset('storage/' . $news->$img) }}"
                                 class="md:w-24 md:h-24 w-48 h-48 object-cover rounded-lg shadow"
                                 alt="thumbnail">
                        @endif
                    @endforeach
                </div>

                {{-- Sumber Berita Desktop --}}
                <div class="hidden md:block space-y-2 text-center">
                    <p class="text-sm font-semibold text-center">Sumber</p>
                    <a href="{{ $news->source }}" target="_blank"
                       class="block text-blue-500 underline border border-secondary py-3 px-3 rounded-lg hover:bg-blue-50">
                        Baca berita lengkap di sumber asli
                    </a>
                </div>
            </div>

            {{-- Kolom kanan --}}
            <div class="md:col-span-8 space-y-6">

                {{-- Judul Desktop --}}
                <h2 class="hidden md:block text-5xl md:text-4xl font-bold leading-snug">
                    {{ $news->title }}
                </h2>

                <div class="space-y-5 text-justify leading-relaxed text-4xl md:text-lg">
                    {!! nl2br(e($news->description)) !!}
                </div>

                {{-- Sumber Berita Mobile --}}
                <div class="block md:hidden mt-8 pt-6 space-y-2">
                    <p class="text-center text-2xl font-semibold">Sumber</p>
                    <a href="{{ $news->source }}" target="_blank"
                       class="block text-center text-2xl text-blue-500 underline border border-blue-400 py-3 px-4 rounded-lg hover:bg-blue-50 transition">
                        Baca berita lengkap di sumber asli
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection
