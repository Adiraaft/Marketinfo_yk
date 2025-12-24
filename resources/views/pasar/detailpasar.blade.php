@extends('layouts.home')

@section('title', $market->name_market)

@section('navbar')
    <x-navbar-color />
@endsection

@section('content')
    <div class="mx-15 mt-5 mb-20">
        <a href="{{ route('pasar.pasar') }}" class="text-blue-500 hover:underline mt-3 inline-block">
            ← Kembali
        </a>

        {{-- Judul Pasar --}}
        <h2 class="text-5xl font-bold mt-4">{{ $market->name_market }}</h2>

        <div
            class="grid grid-cols-12 sm:grid sm:grid-cols-1 md:grid md:grid-cols-1 lg:grid lg:grid-cols-1 xl:grid xl:grid-cols-1 2xl:grid 2xl:grid-cols-12 mt-6 gap-8">

            {{-- Kiri (gambar) --}}
            <div class="col-span-12 md:col-span-4 space-y-6">
                <img src="{{ asset('storage/' . $market->image) }}" class="w-full h-135 object-cover rounded-lg"
                    alt="{{ $market->name_market }}">
            </div>

            {{-- Kanan (detail) --}}
            <div class="col-span-12 md:col-span-8 space-y-4">
                <h2 class="text-2xl font-bold">Detail</h2>

                <div class="space-y-4 text-justify leading-relaxed">
                    {{-- Deskripsi --}}
                    <p>{{ $market->description }}</p>

                    {{-- Jam Buka --}}
                    <h2 class="text-2xl font-bold">Jam Buka</h2>
                    <h2 class="text-lg">{{ $market->opening_hours }}</h2>

                    {{-- Lokasi --}}
                    <h2 class="text-2xl font-bold">Lokasi</h2>

                    <div class="space-y-2">
                        <a href="{{ $market->maps_link }}" target="_blank"
                            class="flex items-center gap-2 text-blue-500 underline border border-secondary py-3 px-3 rounded-lg">
                            <i data-lucide="navigation" class="w-4 h-4 text-black"></i>
                            {{ $market->address }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- SECTION HARGA KOMODITAS --}}
        <div class="my-7 py-6 border rounded-lg bg-white border-gray-300">
            <form id="filterFormPasar" action="{{ route('pasar.detail', $market->id_market) }}" class="flex justify-between"
                method="GET">
                <div
                    class="commodity-filter flex gap-4 mx-12 text-xl sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl">
                    <div>
                        <label for="kategori" class="block">Pilih Kategori</label>
                        <select name="kategori"
                            class="category-select border border-gray-400 bg-gray-100 rounded-lg p-1 md:w-60 w-auto focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $c)
                                <option value="{{ $c->id_category }}"
                                    {{ request('kategori') == $c->id_category ? 'selected' : '' }}>
                                    {{ $c->name_category }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="p-2 w-10 h-10 rounded-lg bg-secondary self-end cursor-pointer">
                        <i data-lucide="search" class="w-5 h-5 text-white"></i>
                    </button>
                </div>

                <div
                    class="flex text-lg sm:text-xs md:text-sm xl:text-base 2xl:text-lg gap-4 items-center justify-center mr-10">
                    <button type="button" class="flex items-center gap-1 text-red-500">
                        <i data-lucide="move-up" class="w-4 h-4"></i>
                        <p>Harga Naik</p>
                    </button>
                    <div class="flex items-center gap-1 text-green-500">
                        <i data-lucide="move-down" class="w-4 h-4"></i>
                        <p>Harga Turun</p>
                    </div>
                    <div class="flex items-center gap-1">
                        <i data-lucide="minus" class="w-4 h-4"></i>
                        <p>Harga Tetap</p>
                    </div>
                </div>
            </form>

            <hr class="mt-6 opacity-20 mb-6">

            <div id="commodity-wrapper-pasar">
                {{-- Card Grid --}}
                <div
                    class="mx-12 mb-6 grid grid-cols-3 sm:grid md:grid md:grid-cols-2 lg:grid lg:grid-cols-3 xl:grid xl:grid-cols-3 2xl:grid 2xl:grid-cols-3 gap-9 sm:gap-4 md:gap-6 lg:gap-9 xl:gap-9 2xl:gap-9">
                    @forelse ($commodities as $item)
                        @include('components.card-market', ['item' => $item])
                    @empty
                        <div class="col-span-3 text-center py-12">
                            <i data-lucide="package-open" class="w-16 h-16 text-gray-300 mx-auto mb-4"></i>
                            <p class="text-gray-500 text-lg">Belum ada data komoditas untuk pasar ini</p>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                @if ($commodities->hasPages())
                    <div
                        class="flex gap-2 text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs justify-center">
                        @if ($commodities->onFirstPage())
                            <button class="p-2 rounded-lg border-2 border-gray-300 opacity-40 cursor-not-allowed">
                                Sebelumnya
                            </button>
                        @else
                            <button onclick="goToPagePasar('{{ $commodities->previousPageUrl() }}')"
                                class="p-2 rounded-lg border-2 border-gray-300 hover:bg-gray-300">
                                Sebelumnya
                            </button>
                        @endif

                        @foreach ($commodities->getUrlRange(1, $commodities->lastPage()) as $page => $url)
                            @if ($page == $commodities->currentPage())
                                <button class="py-2 px-3 rounded-lg border-2 border-gray-300 bg-slate-500 text-white">
                                    {{ $page }}
                                </button>
                            @else
                                <button onclick="goToPagePasar('{{ $url }}')"
                                    class="py-2 px-3 rounded-lg border-2 border-gray-300 hover:bg-slate-500 hover:text-white">
                                    {{ $page }}
                                </button>
                            @endif
                        @endforeach

                        @if ($commodities->hasMorePages())
                            <button onclick="goToPagePasar('{{ $commodities->nextPageUrl() }}')"
                                class="p-2 rounded-lg border-2 border-gray-300 hover:bg-gray-300">
                                Selanjutnya
                            </button>
                        @else
                            <button class="p-2 rounded-lg border-2 border-gray-300 opacity-40 cursor-not-allowed">
                                Selanjutnya
                            </button>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- JavaScript untuk AJAX --}}
    <script>
        function loadCommoditiesPasar(url, skipPush = false) {
            const wrapper = document.getElementById('commodity-wrapper-pasar');

            wrapper.style.opacity = '0.5';
            wrapper.style.pointerEvents = 'none';

            fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.text())
                .then(html => {
                    const doc = new DOMParser().parseFromString(html, 'text/html');
                    const newWrapper = doc.getElementById('commodity-wrapper-pasar');

                    if (!newWrapper) return;

                    wrapper.innerHTML = newWrapper.innerHTML;

                    // ⛔ JANGAN pushState kalau dari popstate
                    if (!skipPush) {
                        window.history.pushState({}, '', url);
                    }

                    wrapper.style.opacity = '1';
                    wrapper.style.pointerEvents = 'auto';

                    if (window.lucide) lucide.createIcons();
                    if (window.initSparklineCharts) initSparklineCharts();
                })
                .catch(() => {
                    wrapper.style.opacity = '1';
                    wrapper.style.pointerEvents = 'auto';
                });
        }


        // Handle form submit
        document.getElementById('filterFormPasar').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const params = new URLSearchParams(formData).toString();
            const url = this.action + '?' + params;

            loadCommoditiesPasar(url);
        });

        // Go to pagination page
        function goToPagePasar(url) {
            loadCommoditiesPasar(url);
        }

        // Handle browser back/forward buttons
        window.addEventListener('popstate', () => {
            loadCommoditiesPasar(window.location.href, true);
        });
    </script>
@endsection
