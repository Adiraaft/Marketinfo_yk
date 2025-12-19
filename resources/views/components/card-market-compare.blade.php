<div class="md:flex grid pb-4 min-w-full border border-gray-300 h-auto rounded-2xl">
    {{-- Gambar & Pasar --}}
    <div class="p-4 flex flex-col gap-5">
        <img src="{{ $item->image_url }}" alt="{{ $item->name_commodity }}" class="rounded-lg w-42 h-33 object-cover">

        <div class="flex gap-2 items-center">
            <i data-lucide="map-pin"></i>
            <p class="font-bold">{{ $market->market_name ?? '-' }}</p>
        </div>
    </div>

    {{-- Konten --}}
    <div class="md:mt-4 md:mr-4 md:pl-0 pl-4 flex-1">

        <p class="font-bold text-xl sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl md:mt-4">
            {{ $item->name_commodity }}
        </p>

        {{-- Harga --}}
        <div class="flex justify-start gap-2 items-center mt-1">
            <p class="text-lg sm:text-xs md:text-sm xl:text-base 2xl:text-lg">
                Rp{{ number_format($market->avg_price ?? 0, 0, ',', '.') }}
                <span class="text-sm">
                    /{{ $item->unit->name_unit ?? '-' }}
                </span>
            </p>

            {{-- Tooltip --}}
            <div class="relative group">
                <i data-lucide="circle-alert" tabindex="0"
                    class="w-5 h-5 text-white bg-secondary rounded-full cursor-pointer focus:outline-none"></i>

                <div
                    class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2
                    hidden group-hover:block group-focus-within:block
                    bg-gray-800 text-white text-xs px-3 py-1 rounded-lg
                    whitespace-nowrap shadow-lg z-50">
                    Terakhir Update:
                    {{ \Carbon\Carbon::parse($market->price_date ?? now())->translatedFormat('d F Y') }}
                </div>
            </div>
        </div>

        {{-- Chart --}}
        <div id="chart-market-{{ $item->id_commodity }}-{{ $market->market_id ?? '' }}"
            class="market-chart mt-4 w-full h-16" data-chart='@json($market->chart ?? [])'
            data-trend="{{ request('trend') }}">
        </div>

    </div>
</div>
