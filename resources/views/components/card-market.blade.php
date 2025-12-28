@php
    $detailUrl = route('commodity.detail', $item->id_commodity);

    if (!empty($item->market_id)) {
        $detailUrl .= '?market=' . $item->market_id;
    }
@endphp

<a href="{{ $detailUrl }}">
    <div class="md:flex grid pb-4 min-w-full border border-gray-300 rounded-2xl shadow-md">
        {{-- Gambar & Trend Desktop --}}
        <div class="md:w-40 flex-shrink-0">
            <div class="p-4">
                <img src="{{ $item->image_url }}" alt="{{ $item->name_commodity }}"
                    class="w-40 h-32 md:w-36 md:h-28 xl:w-40 xl:h-24 rounded-lg object-cover">
            </div>

            @if (!empty($item->trend))
                <div
                    class="hidden md:flex items-center text-xs md:mx-4 md:mb-6 gap-1
                {{ $item->trend === 'up' ? 'text-red-500' : 'text-green-500' }}">

                    <i data-lucide="{{ $item->trend === 'up' ? 'move-up' : 'move-down' }}" class="h-4 w-4"></i>

                    <p class="text-xs">
                        {{ $item->price_percent }}%
                        (Rp {{ number_format($item->price_diff, 0, ',', '.') }})
                    </p>
                </div>
            @endif
        </div>

        {{-- Konten --}}
        <div class="md:mt-4 md:mr-4 md:pl-0 pl-4 flex-1">

            {{-- Nama Komoditas --}}
            <p class="font-bold text-xs md:text-sm lg:text-base md:mt-4">
                {{ $item->name_commodity }}
            </p>

            {{-- Nama Pasar --}}
            @if (!empty($item->market_name))
                <div class="flex gap-2 items-center text-sm text-gray-600 mt-1">
                    <i data-lucide="map-pin" class="w-4 h-4"></i>
                    <p>{{ $item->market_name }}</p>
                </div>
            @endif

            {{-- Harga MARKET --}}
            @if (!is_null($item->market_price))
                <div class="flex justify-start gap-2 items-center mt-1">
                    <p class="text-xs md:text-sm xl:text-base">
                        Rp{{ number_format($item->market_price, 0, ',', '.') }}
                        <span class="text-sm">
                            /{{ $item->unit->name_unit ?? '-' }}
                        </span>
                    </p>

                    {{-- Tooltip --}}
                    @if (!empty($item->price_date))
                        <div class="relative group">
                            <i data-lucide="circle-alert" tabindex="0"
                                class="w-5 h-5 text-white bg-secondary rounded-full cursor-pointer"></i>

                            <div
                                class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2
                            hidden group-hover:block group-focus-within:block
                            bg-gray-800 text-white text-xs px-3 py-1 rounded-lg
                            whitespace-nowrap shadow-lg z-50">
                                Terakhir Update:
                                {{ \Carbon\Carbon::parse($item->price_date)->translatedFormat('d F Y') }}
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            {{-- Chart --}}
            <div class="sparkline-chart mt-3 w-33 h-10 md:w-45 md:h-12 overflow-hidden"
                data-prices='@json($item->chart ?? [])' data-trend="auto">
            </div>
            <div id="chart-tooltip"
                class="absolute bg-white p-2 rounded-xl shadow-lg text-sm hidden z-50 transition-all duration-150 ease-in-out pointer-events-none">
            </div>

            {{-- Trend Mobile --}}
            @if (!empty($item->trend))
                <div
                    class="flex md:hidden items-center text-xs mt-4 gap-1
                {{ $item->trend === 'up' ? 'text-red-500' : 'text-green-500' }}">

                    <i data-lucide="{{ $item->trend === 'up' ? 'move-up' : 'move-down' }}" class="h-4 w-4"></i>

                    <p class="text-xs">
                        {{ $item->price_percent }}%
                        (Rp {{ number_format($item->price_diff, 0, ',', '.') }})
                    </p>
                </div>
            @endif
        </div>
    </div>
</a>
