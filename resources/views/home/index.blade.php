@extends('layouts.home')

@section('title', 'Home')

@section('navbar')
    <x-navbar-transparent />
@endsection

@section('jumbotron')
    <div class="relative w-full h-screen bg-center bg-no-repeat bg-cover"
        style="background-image: url('{{ asset('images/wallpaper2.png') }}')">
        <div class="absolute inset-0 bg-black/40"></div>

        <div class="relative z-10 flex flex-col items-center justify-center h-full  text-white text-center px-5">
            <h1 class="text-4xl sm:text-2xl md:text-3xl lg:text-4xl xl:text-5xl 2xl:5xl font-extrabold">
                Harga Komoditas Bahan <br> Pangan
                <span class="text-[#FB7A29]">Kota Yogyakarta</span>
            </h1>

            <p class="mt-2 font-medium text-xl sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl">
                Hadirkan data harga pangan terkini dari seluruh pasar Yogyakarta. <br>
                Bantu masyarakat dan pelaku usaha mengambil keputusan yang lebih bijak.
            </p>
            <a href="#hargaKomoditas"
                class="mt-4 bg-[#FB7A29] text-white px-12 py-4 rounded-xl font-bold text-xl sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl 
                      hover:bg-[#e86c21] transition-all shadow-md">
                Lihat Harga
            </a>
        </div>

    </div>
@endsection


@section('content')
    <div class="mt-8 px-15">
        <h3 id="hargaKomoditas" class="font-bold text-2xl sm:text-lg md:text-xl lg:2xl xl:3xl 2xl:4xl">Harga Barang
            Komoditas
            Bahan Pangan Kota
            Yogyakarta</h3>
        <div class="my-7 py-6 border rounded-lg border-gray-300">
            <form action="{{ route('home.index') }}#commodity-section" class="flex justify-between" method="GET">
                <div
                    class="commodity-filter flex gap-4 mx-12 text-xl sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl">
                    <div>
                        <label for="kategori" class="block">Pilih Kategori</label>
                        <select name="kategori"
                            class="category-select border border-gray-300 rounded-lg p-1 md:w-60 w-auto focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $c)
                                <option value="{{ $c->id_category }}"
                                    {{ request('kategori') == $c->id_category ? 'selected' : '' }}>{{ $c->name_category }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="commodity" class="block">Pilih Bahan Komoditas</label>
                        <select name="commodity"
                            class="commodity-select border border-gray-300 rounded-lg p-1 md:w-60 w-auto focus:ring-blue-500 focus:border-blue-500">
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
                        <label for="market" class="block">Pilih Pasar</label>
                        <select name="market" id="marketSelect"
                            class="border border-gray-300 rounded-lg p-1 md:w-60 w-auto
                            focus:ring-blue-500 focus:border-blue-500">

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
                    <input type="hidden" name="trend" value="{{ request('trend', 'all') }}">
                    <button type="submit" class="p-2 w-10 h-10 rounded-lg bg-secondary self-end cursor-pointer">
                        <i data-lucide="search" class="w-5 h-5 text-white"></i>
                    </button>
                </div>

                <div class="flex text-lg sm:text-xs md:text-sm xl:text-base 2xl:text-lg gap-4 items-center justify-center mr-10">
                    <button class="flex items-center gap-1 text-red-500">
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
            <hr id="commodity-section" class="mt-6 opacity-20">

            <div class="my-6 mx-12">
                {{-- INFO MODE AVG --}}
                @if (!request('commodity'))
                    <div
                        class="flex items-center gap-2 p-2
                   text-xl sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl
                   border-2 bg-gray-200 w-fit rounded-lg border-secondary">
                        <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                        <p>
                            Menampilkan harga rata-rata di Kota Yogyakarta,
                            pilih pasar dan barang untuk harga yang lebih akurat
                        </p>
                    </div>
                @endif

                {{-- FILTER HARGA --}}
                @if (request('commodity'))
                    <div class="flex gap-5
                text-lg sm:text-xs md:text-sm xl:text-base 2xl:text-lg">

                        {{-- HARGA TERENDAH --}}
                        <a href="{{ route('home.index', request()->except('trend') + ['trend' => 'down']) }}#commodity-section"
                            class="py-2 px-6 rounded-lg border-2
                   border-green-500 text-green-600
                   {{ request('trend') === 'down' ? 'bg-green-200' : '' }}">
                            Harga Terendah
                        </a>

                        {{-- HARGA TERTINGGI --}}
                        <a href="{{ route('home.index', request()->except('trend') + ['trend' => 'up']) }}#commodity-section"
                            class="py-2 px-6 rounded-lg border-2
                   border-red-500 text-red-600
                   {{ request('trend') === 'up' ? 'bg-red-200' : '' }}">
                            Harga Tertinggi
                        </a>

                    </div>
                @endif
            </div>

            <div id="commodity-wrapper">
                {{-- card --}}
                <div
                    class="mx-12 mb-6 grid grid-cols-3 sm:grid md:grid md:grid-cols-2 lg:grid lg:grid-cols-3 xl:grid xl:grid-cols-3 2xl:grid 2xl:grid-cols-3 gap-9 sm:gap-4 md:gap-6 lg:gap-9 xl:gap-9 2xl:gap-9">
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
                            @foreach ($item->market_prices as $market)
                                @include('components.card-market-compare', compact('item', 'market'))
                            @endforeach
                        @endforeach
                    @endif

                    @if ($mode === 'ONE_ONE_MARKET')
                        @foreach ($commodities as $item)
                            @include('components.card-market', ['item' => $item])
                        @endforeach
                    @endif
                </div>


                <div class="flex gap-2 text-base sm:text-xs md:text-xs lg:text-xs xl:text-xs 2xl:text-xs justify-center">
                    @if ($commodities->onFirstPage())
                        <button class="p-2 rounded-lg border-2 border-gray-300 opacity-40 cursor-not-allowed"> Sebelumnya
                        </button>
                    @else
                        <a href="{{ $commodities->previousPageUrl() }}#commodity-section"> <button
                                class="p-2 rounded-lg border-2 border-gray-300 hover:bg-gray-300"> Sebelumnya </button>
                        </a>
                        @endif {{-- Generate nomor halaman --}} @foreach ($commodities->getUrlRange(1, $commodities->lastPage()) as $page => $url)
                            @if ($page == $commodities->currentPage())
                                {{-- Halaman aktif --}} <button
                                    class="py-2 px-3 rounded-lg border-2 border-gray-300 bg-slate-500 text-white">
                                    {{ $page }} </button>
                            @else
                                <a href="{{ $url }}#commodity-section"> <button
                                        class="py-2 px-3 rounded-lg border-2 border-gray-300 hover:bg-slate-500 hover:text-white">
                                        {{ $page }} </button> </a>
                            @endif
                            @endforeach {{-- Tombol Next --}} @if ($commodities->hasMorePages())
                                <a href="{{ $commodities->nextPageUrl() }}#commodity-section"> <button
                                        class="p-2 rounded-lg border-2 border-gray-300 hover:bg-gray-300"> Selanjutnya
                                    </button> </a>
                            @else
                                <button class="p-2 rounded-lg border-2 border-gray-300 opacity-40 cursor-not-allowed">
                                    Selanjutnya </button>
                            @endif
                </div>
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
                <div class="commodity-filter flex max-w-full gap-4 items-end">
                    <div>
                        <label for="pasar" class="block">Pilih Pasar</label>
                        <select id="pasar" name="pasar"
                            class="border border-gray-300 rounded-lg p-1 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Pasar</option>
                            @foreach ($markets as $m)
                                <option value="{{ $m->id_market }}">{{ $m->name_market }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="kategori" class="block">Pilih Kategori</label>
                        <select id="category_id" name="kategori"
                            class="category-select border border-gray-300 rounded-lg p-1 md:w-60 w-auto focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $c)
                                <option value="{{ $c->id_category }}">{{ $c->name_category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="commodity" class="block">Pilih Bahan Komoditas</label>
                        <select id="commodity_id" name="commodity"
                            class="commodity-select border border-gray-300 rounded-lg p-1 md:w-60 w-auto focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Komoditas</option>
                            @foreach ($commoditiesDropdown as $com)
                                <option value="{{ $com->id_commodity }}" data-category="{{ $com->category_id }}">
                                    {{ $com->name_commodity }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button class="p-2 w-8 h-8 rounded-lg bg-secondary cursor-pointer flex items-center justify-center">
                        <i data-lucide="search" class="w-4 h-4 text-white"></i>
                    </button>
                </div>

                <!-- Indikator Harga -->
                <div class="flex text-lg sm:text-xs md:text-sm xl:text-base 2xl:text-lg gap-4 items-center justify-center">
                    <button class="flex items-center gap-1 text-red-500">
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
            </div>

            <hr class="mt-6 opacity-20">
            <div
                class="flex text-xl sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl my-6 mx-12 gap-2 p-2 border-2 bg-gray-200 w-fit rounded-lg border-secondary">
                <i data-lucide="circle-alert" class="w-5 h-5 text-white bg-secondary rounded-full"></i>
                <p>Menampilkan harga rata-rata di Kota Yogyakarta, pilih pasar dan barang untuk harga yang lebih akurat</p>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            @foreach ($commodities as $item)
                @php
                    $chartId = $item->id_commodity ?? ($item->id ?? $loop->index);
                @endphp

                @if (!empty($item->chart_prices) && count($item->chart_prices) >= 2)
                    const el{{ $chartId }} = document.querySelector('#chart-{{ $chartId }}');

                    if (el{{ $chartId }}) {
                        new ApexCharts(el{{ $chartId }}, {
                            chart: {
                                type: 'area',
                                height: 70,
                                sparkline: {
                                    enabled: true
                                }
                            },
                            stroke: {
                                curve: 'smooth',
                                width: 2
                            },
                            fill: {
                                type: 'gradient',
                                gradient: {
                                    opacityFrom: 0.35,
                                    opacityTo: 0.05
                                }
                            },
                            series: [{
                                name: 'Harga',
                                data: @json($item->chart_prices)
                            }],
                            xaxis: {
                                type: 'datetime'
                            },
                            colors: [
                                '{{ isset($item->trend) && $item->trend === 'up' ? '#ef4444' : '#22c55e' }}'
                            ],
                            tooltip: {
                                x: {
                                    format: 'dd MMMM yyyy'
                                },
                                y: {
                                    formatter: val => 'Rp ' + val.toLocaleString('id-ID')
                                }
                            }
                        }).render();
                    }
                @endif
            @endforeach
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            document.querySelectorAll('.market-chart').forEach(el => {

                const data = JSON.parse(el.dataset.chart || '[]');
                if (!Array.isArray(data) || data.length < 2) return;

                data.sort((a, b) => new Date(a.x) - new Date(b.x));

                const first = Number(data[0].y);
                const last = Number(data[data.length - 1].y);

                console.log('FIRST:', first, 'LAST:', last);

                let color = '#9ca3af';
                if (last > first) color = '#ef4444'; // mahal
                else if (last < first) color = '#22c55e'; // murah

                el.innerHTML = '';

                new ApexCharts(el, {
                    chart: {
                        type: 'area',
                        height: 70,
                        sparkline: {
                            enabled: true
                        }
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 2
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            opacityFrom: 0.35,
                            opacityTo: 0.05
                        }
                    },
                    series: [{
                        name: 'Harga',
                        data: data
                    }],
                    xaxis: {
                        type: 'datetime'
                    },
                    tooltip: {
                        y: {
                            formatter: v => 'Rp ' + Number(v).toLocaleString('id-ID')
                        }
                    },
                    colors: [color] // ✅ FIX FINAL
                }).render();

            });

        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            document.querySelectorAll('.commodity-filter').forEach(wrapper => {

                const categorySelect = wrapper.querySelector('.category-select');
                const commoditySelect = wrapper.querySelector('.commodity-select');

                const allOptions = Array.from(commoditySelect.options);

                categorySelect.addEventListener('change', function() {
                    const selectedCategory = String(this.value);

                    commoditySelect.innerHTML = '';
                    commoditySelect.appendChild(allOptions[0]); // Semua Komoditas

                    allOptions.slice(1).forEach(option => {
                        if (
                            selectedCategory === '' ||
                            String(option.dataset.category) === selectedCategory
                        ) {
                            commoditySelect.appendChild(option);
                        }
                    });
                });
                if (categorySelect.value !== '') {
                    categorySelect.dispatchEvent(new Event('change'));
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const commoditySelect = document.querySelector('.commodity-select');
            const allMarketOption = document.getElementById('allMarketOption');
            const marketSelect = document.getElementById('marketSelect');

            function toggleAllMarket() {
                const hasCommodity = commoditySelect.value !== '';

                // tampilkan SEMUA PASAR hanya jika komoditas dipilih
                allMarketOption.hidden = !hasCommodity;

                // jika komoditas dikosongkan & posisi di ALL → reset ke AVG
                if (!hasCommodity && marketSelect.value === 'all') {
                    marketSelect.value = 'avg';
                }
            }

            commoditySelect.addEventListener('change', toggleAllMarket);
            toggleAllMarket(); // init
        });
    </script>


@endsection
