@extends('layouts.home')

@section('title', 'Home')

@section('navbar')
    <x-navbar-transparent />
@endsection

@section('jumbotron')
    <div class="relative w-full h-svh bg-center bg-no-repeat bg-cover"
        style="background-image: url('{{ asset('images/wallpaper2.png') }}')">

        <div class="absolute inset-0 bg-black/50"></div>

        <div
            class="relative z-10 flex flex-col items-center justify-center h-full
               text-white text-center px-4 sm:px-6 lg:px-8">

            {{-- JUDUL --}}
            <h1 class="font-extrabold leading-tight
                   text-2xl sm:text-3xl md:text-3xl xl:text-3xl">
                Harga Komoditas Bahan
                <span class="hidden sm:inline"><br></span>
                Pangan
                <span class="text-[#FB7A29] block sm:inline">
                    Kota Yogyakarta
                </span>
            </h1>

            {{-- DESKRIPSI --}}
            <p class="mt-3 max-w-xl font-medium leading-relaxed
                  text-sm md:text-base">
                Hadirkan data harga pangan terkini dari seluruh pasar Yogyakarta.
                <span class="hidden sm:inline"><br></span>
                Bantu masyarakat dan pelaku usaha mengambil keputusan yang lebih bijak.
            </p>

            {{-- BUTTON --}}
            <button onclick="scrollToSection()"
                class="mt-6 bg-[#FB7A29] hover:bg-[#e86c21]
                   text-white font-bold rounded-xl shadow-md transition
                   px-6 py-3 text-sm md:text-base">
                Lihat Harga
            </button>

        </div>
    </div>
@endsection

@section('content')
    <div class="mt-16 sm:mt-20 lg:mt-24 px-4 sm:px-6 lg:px-10">
        <h3 id="hargaKomoditas" class="font-bold leading-tight
           text-lg sm:text-xl md:text-2xl lg:text-2xl">
            Harga Barang Komoditas
            Bahan Pangan Kota
            Yogyakarta
        </h3>
        <div class="my-8 py-4 sm:py-6 border rounded-lg bg-white border-gray-300">
            <form id="filterForm" action="{{ route('home.index') }}"
                class="flex flex-col gap-4 xl:flex-row xl:justify-between" method="GET">
                <div
                    class="commodity-filter flex flex-col gap-4 px-4 text-sm md:text-base xl:items-end lg:flex-row xl:px-8">
                    <div>
                        <label for="kategori" class="block lg:text-sm">Pilih Kategori</label>
                        <select name="kategori"
                            class="category-select border border-gray-400 bg-gray-100 rounded-lg p-1 w-full md:w-50 lg:text-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $c)
                                <option value="{{ $c->id_category }}"
                                    {{ request('kategori') == $c->id_category ? 'selected' : '' }}>{{ $c->name_category }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="commodity" class="block lg:text-sm">Pilih Bahan Komoditas</label>
                        <select name="commodity"
                            class="commodity-select border border-gray-400 bg-gray-100 rounded-lg p-1 w-full md:w-50 lg:text-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Komoditas</option>
                            @foreach ($commoditiesDropdown as $com)
                                <option value="{{ $com->id_commodity }}" data-category="{{ $com->category_id }}"
                                    {{ request('commodity') == $com->id_commodity ? 'selected' : '' }}>
                                    {{ $com->name_commodity }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="market" class="block lg:text-sm">Pilih Pasar</label>
                        <select name="market" id="marketSelect"
                            class="border border-gray-400 bg-gray-100 rounded-lg p-1 w-full md:w-50 lg:text-sm focus:ring-blue-500 focus:border-blue-500">

                            {{-- MODE AVG --}}
                            <option value="avg" {{ request('market', 'avg') == 'avg' ? 'selected' : '' }}>
                                Rata-rata Kota Yogyakarta
                            </option>

                            {{-- SEMUA PASAR (BERAT → HANYA SAAT KOMODITAS DIPILIH) --}}
                            <option value="all" id="allMarketOption" {{ request('market') == 'all' ? 'selected' : '' }}>
                                Semua Pasar
                            </option>

                            {{-- PASAR TERTENTU (SELALU BOLEH) --}}
                            @foreach ($markets as $market)
                                <option value="{{ $market->id_market }}"
                                    {{ request('market') == $market->id_market ? 'selected' : '' }}>
                                    {{ $market->name_market }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <input type="hidden" name="trend" id="trendInput" value="{{ request('trend', 'all') }}">
                    <button type="submit"
                        class="mt-2 lg:mt-0 px-4 py-2 rounded-lg bg-secondary cursor-pointer text-white font-medium w-full xl:text-sm md:w-auto lg:px-3">
                        Tampilkan
                    </button>
                </div>

                <div class="flex mt-3 gap-2 items-center px-4 text-sm md:text-base justify-center">
                    <div class="flex items-center gap-2 text-red-500 xl:text-xs">
                        <i data-lucide="move-up" class="w-4 h-4"></i>
                        <p>Harga Naik</p>
                    </div>
                    <div class="flex items-center gap-2 text-green-500 xl:text-xs">
                        <i data-lucide="move-down" class="w-4 h-4"></i>
                        <p>Harga Turun</p>
                    </div>
                    <div class="flex items-center gap-2 xl:text-xs">
                        <i data-lucide="minus" class="w-4 h-4"></i>
                        <p>Harga Tetap</p>
                    </div>
                </div>
            </form>
            <hr id="commodity-section" class="mt-6 opacity-20">

            <div id="commodity-info-wrapper" class="my-6 mx-4 lg:mx-8">
                {{-- INFO MODE AVG --}}
                @if ($mode !== 'ONE_ALL_MARKET')
                    <div
                        class="flex items-center gap-2 p-2 text-xs sm:text-xs md:text-sm border-2 bg-gray-200 w-fit rounded-lg border-secondary">
                        <i data-lucide="circle-alert"
                            class="w-5 h-5 shrink-0 text-white bg-secondary rounded-full p-0.5"></i>
                        <p>
                            Menampilkan harga rata-rata di Kota Yogyakarta,
                            pilih pasar dan barang untuk harga yang lebih akurat
                        </p>
                    </div>
                @endif

                {{-- FILTER HARGA (KHUSUS ONE ALL MARKET) --}}
                @if ($mode === 'ONE_ALL_MARKET')
                    <div class="flex justify-center gap-2 md:gap-5 md:justify-start sm:text-xs md:text-sm">

                        {{-- HARGA TERENDAH --}}
                        <button type="button" onclick="applyTrendFilter('down')"
                            class="py-1 px-3 xl:py-2 xl:px-6 rounded-lg border-2
            border-green-500 text-green-600
            {{ request('trend') === 'down' ? 'bg-green-200' : '' }}">
                            Harga Terendah
                        </button>

                        {{-- HARGA TERTINGGI --}}
                        <button type="button" onclick="applyTrendFilter('up')"
                            class="py-1 px-3 xl:py-2 xl:px-6 rounded-lg border-2
            border-red-500 text-red-600
            {{ request('trend') === 'up' ? 'bg-red-200' : '' }}">
                            Harga Tertinggi
                        </button>
                    </div>
                @endif
            </div>

            <div id="commodity-wrapper">
                {{-- card --}}
                <div class="mx-4 xl:mx-8 mb-6 grid grid-cols-2 gap-3 lg:grid-cols-3 lg:gap-5">
                    @if (in_array($mode, ['ALL_AVG', 'ONE_AVG']))
                        @foreach ($commodities as $item)
                            @include('components.card-avg', ['item' => $item])
                        @endforeach
                    @endif

                    @if ($mode === 'ALL_ONE_MARKET')
                        @foreach ($commodities as $item)
                            @include('components.card-market', ['item' => $item])
                        @endforeach
                    @endif

                    @if ($mode === 'ONE_ALL_MARKET')
                        @foreach ($commodities as $item)
                            @include('components.card-market-compare', ['item' => $item])
                        @endforeach
                    @endif

                    @if ($mode === 'ONE_ONE_MARKET')
                        @foreach ($commodities as $item)
                            @include('components.card-market', ['item' => $item])
                        @endforeach
                    @endif
                </div>

                <div class="flex flex-wrap gap-2 text-xs justify-center overflow-x-auto mx-1">
                    @if ($commodities->onFirstPage())
                        <button class="p-2 rounded-lg border-2 border-gray-300 opacity-40 cursor-not-allowed"> Sebelumnya
                        </button>
                    @else
                        <button onclick="goToPage('{{ $commodities->previousPageUrl() }}')"
                            class="p-2 rounded-lg border-2 border-gray-300 hover:bg-gray-300"> Sebelumnya </button>
                    @endif

                    {{-- Generate nomor halaman --}}
                    @foreach ($commodities->getUrlRange(1, $commodities->lastPage()) as $page => $url)
                        @if ($page == $commodities->currentPage())
                            {{-- Halaman aktif --}}
                            <button class="py-2 px-3 rounded-lg border-2 border-gray-300 bg-slate-500 text-white">
                                {{ $page }}
                            </button>
                        @else
                            <button onclick="goToPage('{{ $url }}')"
                                class="py-2 px-3 rounded-lg border-2 border-gray-300 hover:bg-slate-500 hover:text-white">
                                {{ $page }}
                            </button>
                        @endif
                    @endforeach

                    {{-- Tombol Next --}}
                    @if ($commodities->hasMorePages())
                        <button onclick="goToPage('{{ $commodities->nextPageUrl() }}')"
                            class="p-2 rounded-lg border-2 border-gray-300 hover:bg-gray-300"> Selanjutnya </button>
                    @else
                        <button class="p-2 rounded-lg border-2 border-gray-300 opacity-40 cursor-not-allowed">
                            Selanjutnya
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Berita --}}
    <div class="bg-primary mt-16 lg:mt-24 mx-4 px-4 sm:px-6 lg:px-10 lg:mx-10 py-9 mb-7 rounded-lg">
        <p class="text-lg sm:text-xl md:text-2xl lg:text-2xl text-white text-center font-bold leading-tight">
            Berita Terbaru
        </p>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6 lg:mt-10 items-stretch">

            {{-- KIRI — SWIPER SLIDER --}}
            <div class="w-full">
                <div class="swiper mySwiper rounded-lg h-[300px] sm:h-[380px] md:h-[420px]">
                    <div class="swiper-wrapper">

                        {{-- Slide Utama --}}
                        <div class="swiper-slide relative overflow-hidden rounded-lg">
                            <img src="{{ asset('storage/' . $latest->image1) }}" class="w-full h-full object-cover"
                                alt="gambar berita">

                            <div class="absolute inset-0 bg-black/30"></div>

                            <div
                                class="absolute bottom-2 sm:bottom-4 left-2 sm:left-4 text-white px-2 sm:px-4 py-1 sm:py-2">
                                <h3 class="font-light mb-1 text-sm sm:text-base">{{ $latest->created_at->format('d F Y') }}
                                </h3>
                                <h3 class="font-bold lg:text-xl">{{ $latest->title }}</h3>
                            </div>
                        </div>

                        {{-- Slide Lainnya --}}
                        @foreach ($others as $item)
                            <div class="swiper-slide relative overflow-hidden rounded-lg">
                                <img src="{{ asset('storage/' . $item->image1) }}" class="w-full h-full object-cover"
                                    alt="gambar berita">

                                <div class="absolute inset-0 bg-black/30"></div>

                                <div
                                    class="absolute bottom-2 sm:bottom-4 left-2 sm:left-4 text-white px-2 sm:px-4 py-1 sm:py-2">
                                    <h3 class="font-light mb-1 text-sm sm:text-base">
                                        {{ $item->created_at->format('d F Y') }}</h3>
                                    <h3 class="font-bold sm:text-xl">{{ $item->title }}</h3>
                                </div>
                            </div>
                        @endforeach

                    </div>

                    <div class="swiper-button-prev !text-white"></div>
                    <div class="swiper-button-next !text-white"></div>
                </div>
            </div>

            {{-- KANAN — LIST BERITA --}}
            <div class="flex flex-col gap-5">
                @foreach ($others as $item)
                    <a href="{{ route('berita.detail', $item->id) }}"
                        class="flex flex-col sm:flex-row gap-3 sm:gap-5 bg-white p-4 rounded-lg hover:bg-gray-100 transition">

                        <img src="{{ asset('storage/' . $item->image1) }}"
                            class="w-full sm:w-32 h-32 sm:h-24 object-cover rounded-lg" alt="gambar berita">

                        <div class="flex flex-col justify-between gap-2">
                            <h3 class="text-sm lg:text-base font-semibold">{{ $item->title }}</h3>
                            <p class="text-sm text-gray-600 font-medium">{{ $item->created_at->format('d F Y') }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="flex justify-center lg:justify-end mt-6">
            <a href="{{ route('berita.index') }}"
                class="bg-[#FB7A29] py-3 px-8 sm:px-12 text-white rounded-lg text-sm lg:text-base">
                Berita Lainnya
            </a>
        </div>
    </div>

    <div id="comparison-root" data-url="{{ route('comparison.data') }}" class="mt-16 px-4 lg:mt-24 lg:px-10">
        <h3 class="font-bold text-lg lg:text-2xl">
            Komparasi Harga Antar Pasar
        </h3>

        <div class="my-7 flex flex-col lg:flex-row gap-6">
            <div class="lg:w-80 bg-white border border-gray-300 rounded-lg p-4 lg:p-6 shrink-0">
                <h4 class="font-bold lg:text-lg mb-4 text-gray-800">
                    Tentukan data yang ingin <br> ditampilkan
                </h4>

                {{-- PILIH PASAR --}}
                <div class="mb-6">
                    <label class="block font-semibold text-sm lg:text-base text-gray-700 mb-2">Pasar</label>
                    <div class="space-y-2 max-h-48 overflow-y-auto border border-gray-300 rounded-lg p-3">
                        @foreach ($markets as $market)
                            <label
                                class="flex items-center space-x-2 cursor-pointer hover:bg-blue-50 p-2 rounded transition">
                                <input type="checkbox" name="comparison_markets[]" value="{{ $market->id_market }}"
                                    data-market-name="{{ $market->name_market }}"
                                    class="comparison-market-checkbox w-4 h-4 text-blue-600 rounded text-sm lg:text-base">
                                <span class="text-sm text-gray-700">{{ $market->name_market }}</span>
                            </label>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        Pilih minimal 2 pasar (maksimal 5)
                    </p>
                </div>

                {{-- PILIH KOMODITAS --}}
                <div class="mb-6">
                    <label class="block font-semibold text-sm lg:text-base text-gray-700 mb-2">Komoditas</label>
                    <select id="comp_commodity"
                        class="w-full border text-sm lg:text-base border-gray-400 bg-gray-100 rounded-lg p-2">
                        <option value="">Pilih Komoditas</option>
                        @foreach ($commoditiesDropdown as $com)
                            <option value="{{ $com->id_commodity }}">
                                {{ $com->name_commodity }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- TANGGAL --}}
                <div class="mb-6">
                    <label class="block font-semibold text-sm lg:text-base text-gray-700 mb-2">Dari Tanggal</label>
                    <input type="date" id="comp_date_from" value="{{ now()->subDays(6)->format('Y-m-d') }}"
                        class="w-full border text-sm lg:text-base border-gray-400 bg-gray-100 rounded-lg p-2">
                </div>

                <div class="mb-6">
                    <label class="block font-semibold text-sm lg:text-base text-gray-700 mb-2">Sampai Tanggal</label>
                    <input type="date" id="comp_date_to" value="{{ now()->format('Y-m-d') }}"
                        class="w-full border text-sm lg:text-base border-gray-400 bg-gray-100 rounded-lg p-2">
                </div>

                <button id="btn-compare" class="w-full bg-secondary text-white font-semibold text-sm py-3 rounded-lg">
                    Tampilkan
                </button>
            </div>


            <div class="flex-1 bg-white border border-gray-300 rounded-lg p-8 min-h-[500px] relative">

                {{-- INITIAL STATE --}}
                <div id="comparison-initial"
                    class="absolute inset-0 flex flex-col items-center justify-center text-center">
                    <i data-lucide="bar-chart-3" class="w-14 h-14 text-gray-300 mb-4"></i>
                    <h4 class="font-semibold text-gray-600 mb-2">
                        Belum ada data yang ditampilkan
                    </h4>
                    <p class="text-gray-500 text-sm max-w-sm">
                        Pilih pasar dan komoditas di samping, lalu klik "Tampilkan"
                    </p>
                </div>

                {{-- LOADING STATE --}}
                <div id="comparison-loading" class="hidden absolute inset-0 flex flex-col items-center justify-center">
                    <i data-lucide="loader-2" class="w-12 h-12 text-blue-500 animate-spin mb-4"></i>
                    <p class="text-gray-600 font-medium">
                        Memuat data perbandingan...
                    </p>
                </div>

                {{-- RESULT STATE --}}
                <div id="comparison-result" class="hidden">

                    <div class="mb-6">
                        <h3 id="comparison-title" class="text-base lg:text-xl font-bold text-gray-800 mb-1"></h3>
                        <p id="comparison-date-range" class="text-sm text-gray-600"></p>
                    </div>


                    <div class="border border-gray-200 rounded-lg p-4 mb-6">
                        <div id="comparison-chart" class="h-[400px]"></div>
                    </div>


                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                        <div class="bg-green-50 border-2 border-green-500 rounded-lg p-4">
                            <p class="text-sm font-semibold text-green-700">Harga Termurah</p>
                            <p id="stat-min-price" class="text-2xl font-bold text-green-600">-</p>
                            <p id="stat-min-market" class="text-sm text-gray-700">-</p>
                        </div>


                        <div class="bg-red-50 border-2 border-red-500 rounded-lg p-4">
                            <p class="text-sm font-semibold text-red-700">Harga Termahal</p>
                            <p id="stat-max-price" class="text-2xl font-bold text-red-600">-</p>
                            <p id="stat-max-market" class="text-sm text-gray-700">-</p>
                        </div>


                        <div class="bg-blue-50 border-2 border-blue-500 rounded-lg p-4">
                            <p class="text-sm font-semibold text-blue-700">Selisih Harga</p>
                            <p id="stat-diff-price" class="text-2xl font-bold text-blue-600">-</p>
                            <p id="stat-diff-percent" class="text-sm text-gray-700">-</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!-- LIST PASAR -->
    <div class="bg-white border rounded-lg border-gray-300 pt-12 pb-4 lg:pb-12 px-4 lg:px-10 mt-16 mx-4 lg:mx-10 mb-10">
        <h3 class="text-xl lg:text-2xl font-bold mb-6 sm:mb-10 text-gray-800 text-center lg:text-left">
            Visualisasi Pasar Kota Yogyakarta
        </h3>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">

            <!-- MAP -->
            <div
                class="rounded-2xl overflow-hidden shadow-lg border border-gray-200 w-full h-[250px] sm:h-[350px] md:h-[400px] lg:h-[500px]">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.0526399756865!2d110.36608747469724!3d-7.784727177294295!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a578c00000000%3A0x9e3b99aafab678c7!2sPasar%20Beringharjo!5e0!3m2!1sid!2sid!4v1690800000000!5m2!1sid!2sid"
                    width="100%" height="100%" allowfullscreen="" loading="lazy" class="w-full h-full">
                </iframe>
            </div>

            <!-- LIST PASAR DINAMIS -->
            <div
                class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 border border-gray-200 overflow-y-auto max-h-[300px] sm:max-h-[400px] md:max-h-[500px]">
                <h3 class="text-lg lg:text-xl font-bold text-gray-800">Daftar Pasar</h3>
                <ul class="space-y-4">
                    @foreach ($markets as $pasar)
                        <li class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b pb-3">
                            <div class="mb-2 sm:mb-0">
                                <p class="font-bold lg:text-lg text-gray-800">{{ $pasar->name_market }}
                                </p>
                                <p class="text-sm lg:text-base text-gray-500">{{ $pasar->address }}</p>
                            </div>

                            <a href="{{ route('pasar.detail', $pasar->id_market) }}"
                                class="bg-secondary text-white px-3 py-2 sm:px-4 sm:py-2 rounded-lg hover:bg-secondary/80 flex items-center gap-1 text-sm lg:text-base">
                                <i data-lucide="map-pin" class="w-4 h-4"></i>
                                Detail
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    {{-- ============================================
         AJAX JAVASCRIPT - NO PAGE RELOAD
         ============================================ --}}
    <script>
        function loadCommodities(url) {
            const wrapper = document.getElementById('commodity-wrapper');
            const infoWrapper = document.getElementById('commodity-info-wrapper');

            wrapper.style.opacity = '0.5';
            wrapper.style.pointerEvents = 'none';

            fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => {
                    if (!res.ok) throw new Error('Fetch error');
                    return res.text();
                })
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');

                    const newWrapper = doc.getElementById('commodity-wrapper');
                    const newInfoWrapper = doc.getElementById('commodity-info-wrapper');

                    if (!newWrapper) return;

                    // replace DOM
                    wrapper.innerHTML = newWrapper.innerHTML;

                    if (newInfoWrapper && infoWrapper) {
                        infoWrapper.innerHTML = newInfoWrapper.innerHTML;
                    }

                    // update url
                    window.history.pushState({}, '', url);

                    wrapper.style.opacity = '1';
                    wrapper.style.pointerEvents = 'auto';

                    // 🔥 RE-INIT ICON
                    if (window.lucide) {
                        lucide.createIcons();
                    }

                    // 🔥 RE-INIT SPARKLINE (INI WAJIB)
                    if (window.initSparklineCharts) {
                        initSparklineCharts();
                    }
                })
                .catch(err => {
                    console.error(err);
                    wrapper.style.opacity = '1';
                    wrapper.style.pointerEvents = 'auto';
                    alert('Gagal memuat data');
                });
        }

        document.getElementById('filterForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const params = new URLSearchParams(new FormData(this)).toString();
            loadCommodities(`{{ route('home.index') }}?${params}`);
        });

        function goToPage(url) {
            loadCommodities(url);
        }

        window.addEventListener('popstate', () => {
            loadCommodities(window.location.href);
        });
    </script>

    <script>
        function applyTrendFilter(trend) {
            const url = new URL(window.location.href);

            url.searchParams.set('trend', trend);
            url.searchParams.delete('page');

            loadCommodities(url.toString());
        }
    </script>


@endsection
