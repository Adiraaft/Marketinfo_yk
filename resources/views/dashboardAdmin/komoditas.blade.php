@extends('layouts.admin')

@section('title', 'Home')

@section('content')
    <div class="my-7 px-15">
        <h3 class="font-bold text-2xl text-secondary">Daftar Komoditas</h3>
        <form action="{{ route('admin.komoditas') }}" method="GET" class="w-full">
            <div class="flex gap-4 mt-4">
                <div>
                    <label for="kategori" class="block">Pilih Kategori</label>
                    <select id="kategori" name="kategori"
                        class="border bg-white border-gray-300 rounded-lg p-1 w-60 focus:ring-blue-500 focus:border-blue-500">
                        <option value="#">Semua Kategori</option>
                        @foreach ($category as $c)
                            <option value="{{ $c->id_category }}"
                                {{ request('kategori') == $c->id_category ? 'selected' : '' }}>
                                {{ $c->name_category }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="tanggal" class="block">Pilih Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal" value="{{ $selectedDate }}"
                        class="border bg-white border-gray-300 rounded-lg p-1 w-60 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="flex w-full justify-between items-end">
                    <button class="py-2 px-4 rounded-lg bg-secondary self-end cursor-pointer">
                        <p class="text-white">Tampilkan</p>
                    </button>
                    <div class="flex items-center gap-4">
                        <button class="border-gray-300 border-2 bg-white rounded-lg py-2 pl-3 pr-45">
                            search
                        </button>
                        <button class="p-3 rounded-lg bg-secondary cursor-pointer flex items-center justify-center">
                            <i data-lucide="search" class="w-4 h-4 text-white"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="w-full bg-white rounded-lg shadow-md mt-6">
                <div class="flex gap-6 bg-gray-200 border-b border-gray-300 text-sm font-medium text-gray-400 rounded-t-lg">
                    <!-- General -->
                    <a href="{{ route('admin.komoditas', 'all') }}?kategori={{ request('kategori') }}&tanggal={{ request('tanggal') }}"
                        class="px-6 py-4 border-b-2 transition-all hover:border-primary hover:text-primary
                    {{ $activeFilter == 'all' ? 'border-primary text-primary font-semibold' : 'border-transparent' }}">
                        Semua {{ $countAll }}
                    </a>

                    <a href="{{ route('admin.komoditas', 'belum-update') }}?kategori={{ request('kategori') }}&tanggal={{ request('tanggal') }}"
                        class="px-6 py-4 border-b-2 transition-all hover:border-primary hover:text-primary
                    {{ $activeFilter == 'belum-update' ? 'border-primary text-primary font-semibold' : 'border-transparent' }}">
                        Belum Update {{ $countBelum }}
                    </a>

                    <a href="{{ route('admin.komoditas', 'sudah-update') }}?kategori={{ request('kategori') }}&tanggal={{ request('tanggal') }}"
                        class="px-6 py-4 border-b-2 transition-all hover:border-primary hover:text-primary
                    {{ $activeFilter == 'sudah-update' ? 'border-primary text-primary font-semibold' : 'border-transparent' }}">
                        Sudah Update {{ $countSudah }}
                    </a>

                </div>
                <div class="max-h-[550px] overflow-y-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="text-gray-400 border-b border-gray-200">
                            <tr>
                                <th class="py-3 px-4 font-medium text-sm">No</th>
                                <th class="py-3 px-4 font-medium text-sm">Nama Barang</th>
                                <th class="py-3 px-4 font-medium text-sm">Kategori</th>
                                <th class="py-3 px-4 font-medium text-sm">Satuan</th>
                                <th class="py-3 px-4 font-medium text-sm">Rata-Rata Harga Per Tanggal</th>
                                <th class="py-3 px-4 font-medium text-sm">Total Input</th>
                                <th class="py-3 px-4 font-medium text-sm">Status</th>
                                <th class="py-3 px-4 font-medium text-sm">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @foreach ($commodities as $c)
                                @php
                                    $pivot = $c->commodityMarkets->first(); // ambil pivot market login
                                @endphp
                                <tr class="border-t border-gray-200 hover:bg-gray-50 text-sm font-medium">
                                    <td class="py-2 px-4">{{ $loop->iteration }}</td>
                                    <td class="py-2 px-4">
                                        <div class="flex items-center gap-3">

                                            @php
                                                $img = $c->image ?? 'default.png';
                                            @endphp

                                            <img src="{{ asset('storage/commodity_images/' . $img) }}"
                                                class="w-8 h-8 rounded-full object-cover border border-gray-300">

                                            <span>{{ $c->name_commodity }}</span>
                                        </div>
                                    </td>
                                    <td class="py-2 px-4">{{ $c->category->name_category ?? '-' }}</td>
                                    <td class="py-2 px-4">{{ $c->unit->name_unit ?? '-' }}</td>

                                    @php
                                        // Ambil semua price hari ini
                                        $todayPrices = optional(optional($pivot)->prices)->where('date', $selectedDate);

                                        // Hitung rata-rata harga hari ini
                                        $todayAverage = $todayPrices->avg('price');
                                    @endphp
                                    <td class="py-2 px-4">
                                        {{ $todayAverage ? number_format($todayAverage, 0, ',', '.') : '-' }}
                                    </td>

                                    @php
                                        $totalInput = optional(optional($pivot)->prices)
                                            ->where('date', $selectedDate)
                                            ->count();
                                    @endphp

                                    <td class="py-2 px-4 ">{{ $totalInput }}</td>

                                    @php
                                        $todayPrice = optional(optional($pivot)->prices)
                                            ->where('date', $selectedDate)
                                            ->first();
                                    @endphp

                                    <td class="py-2 px-4">
                                        @if ($todayPrice)
                                            <span class="text-green-400">
                                                Sudah Update
                                            </span>
                                        @else
                                            <span class="text-red-400">
                                                Belum Update
                                            </span>
                                        @endif
                                    </td>

                                    <td class="py-2 px-4">
                                        @if ($pivot)
                                            {{-- Jika hari ini sudah ada harga → tombol Edit --}}
                                            @if ($todayPrice)
                                                @php
                                                    $todayPricesArray = optional(optional($pivot)->prices)
                                                        ->where('date', $selectedDate)
                                                        ->pluck('price')
                                                        ->map(fn($p) => (int) $p)
                                                        ->toArray();

                                                    $editPayload = [
                                                        'id' => $pivot->id, // pivot id
                                                        'commodityId' => $pivot->commodity_id,
                                                        'marketId' => $pivot->market_id,
                                                        'name' => $c->name_commodity,
                                                        'prices' => $todayPricesArray,
                                                        'date' => $selectedDate,
                                                    ];
                                                @endphp

                                                <button type="button" class="text-blue-600 hover:underline"
                                                    onclick="openPriceModal('edit', JSON.parse(this.getAttribute('data-item')))"
                                                    data-item='{{ json_encode($editPayload, JSON_UNESCAPED_UNICODE) }}'>
                                                    Edit Harga
                                                </button>
                                            @else
                                                <button type="button"
                                                    onclick="openPriceModal('store', {
                                                    pivotId: {{ $pivot->id }},
                                                    commodityId: {{ $pivot->commodity_id }},
                                                    marketId: {{ $pivot->market_id }},
                                                    name: '{{ addslashes($c->name_commodity) }}'
                                                })"
                                                    class="text-blue-600 hover:underline">
                                                    Update Harga
                                                </button>
                                            @endif
                                        @else
                                            <span class="text-gray-400 text-xs">No Data</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal Update Harga -->
    <div id="priceModal" class="fixed inset-0 bg-black/40 hidden justify-center items-center z-50">
        <div class="bg-white w-96 rounded-lg shadow-lg p-6 relative">
            <button onclick="closePriceModal()"
                class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">&times;</button>
            <h2 class="text-xl font-bold mb-4 text-gray-800">Update Harga</h2>
            <p id="commodityName" class="mb-4 text-gray-700 font-medium"></p>

            <form method="POST" id="priceForm">
                @csrf
                <input type="hidden" name="_method" id="methodInput" value="POST">
                <input type="hidden" name="pivotId" id="pivotId">
                <input type="hidden" id="commodityId" name="commodityId">
                <input type="hidden" name="market_id" id="marketId">


                <div class="mb-4">
                    <label for="priceDate" class="block text-gray-700 mb-1 text-sm font-medium">Tanggal Harga</label>
                    <input type="date" id="priceDate" name="price_date" required
                        class="border border-gray-300 rounded-lg p-2 w-full">
                </div>

                <div id="priceInputs">
                    <div class="mb-2 flex gap-2 items-center">
                        <input type="text" name="price[]" placeholder="Harga 1" required
                            class="border border-gray-300 rounded-lg p-2 w-full">
                    </div>
                </div>

                <button type="button" id="addPriceBtn" onclick="addPriceInput()"
                    class="mb-4 px-3 py-1 bg-gray-200 rounded hover:bg-gray-300 text-sm">
                    + Tambah Harga
                </button>

                <div class="flex justify-end gap-3 mt-2">
                    <button type="button" onclick="closePriceModal()"
                        class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 text-sm">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-secondary text-white rounded-lg hover:opacity-90 text-sm">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            let priceCount = 1;

            // --- OPEN MODAL ---
            window.openPriceModal = function(mode, data) {
                const modal = document.getElementById('priceModal');
                const commodityNameText = document.getElementById('commodityName');
                const priceInputs = document.getElementById('priceInputs');
                const priceDate = document.getElementById('priceDate');
                const commodityIdInput = document.getElementById('commodityId');
                const form = document.getElementById('priceForm');
                const addBtn = document.getElementById('addPriceBtn');

                document.getElementById('methodInput').value = mode === 'edit' ? 'PUT' : 'POST';


                // Reset content
                priceInputs.innerHTML = "";
                priceCount = 1;

                // Mode store (Tambah Harga)
                if (mode === 'store') {
                    form.action = "{{ route('admin.komoditas.store') }}";
                    document.getElementById('methodInput').value = "POST";
                    addBtn.classList.remove('hidden'); // tampilkan tombol tambah harga
                    commodityIdInput.value = data.pivotId;
                    commodityNameText.textContent = data.name;
                    document.getElementById('pivotId').value = data.pivotId || '';
                    commodityIdInput.value = data.commodityId || '';
                    document.getElementById('marketId').value = data.marketId || '';

                    priceDate.value = "{{ $selectedDate }}";

                    priceInputs.innerHTML = `
                        <div class="mb-2 flex gap-2 items-center">
                            <input type="text" name="price[]" placeholder="Harga 1"
                                class="price-input border border-gray-300 rounded-lg p-2 w-full" required>
                        </div>
                    `;
                }

                // Mode edit (Edit Harga)
                if (mode === 'edit') {
                    form.action = "{{ url('admin/komoditas/update') }}/" + data.id;
                    document.getElementById('methodInput').value = "PUT"; // method spoofing
                    addBtn.classList.remove('hidden');
                    commodityNameText.textContent = data.name;
                    priceDate.value = data.date;
                    commodityIdInput.value = data.commodityId || '';
                    document.getElementById('marketId').value = data.marketId || '';

                    priceInputs.innerHTML = "";
                    data.prices.forEach((p, index) => {
                        const div = document.createElement('div');
                        div.classList.add("mb-2", "flex", "gap-2", "items-center");
                        div.innerHTML = `
                            <input type="text" name="price[]" 
                                value="${formatRupiah(p.toString())}"
                                placeholder="Harga ${index + 1}"
                                class="price-input border border-gray-300 rounded-lg p-2 w-full" required>
                            <button type="button" onclick="this.parentElement.remove()"
                                class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm">X</button>
                        `;
                        priceInputs.appendChild(div);
                    });
                }


                modal.classList.remove("hidden");
                modal.classList.add("flex");
            };


            // --- CLOSE MODAL ---
            window.closePriceModal = function() {
                const modal = document.getElementById("priceModal");
                if (!modal) return;
                modal.classList.add("hidden");
                modal.classList.remove("flex");
            }

            // --- TAMBAH INPUT HARGA ---
            window.addPriceInput = function() {
                const container = document.getElementById('priceInputs');

                const currentCount = container.querySelectorAll('.price-input').length;
                const nextNumber = currentCount + 1;

                const div = document.createElement('div');

                div.classList.add("mb-2", "flex", "gap-2", "items-center");
                div.innerHTML = `
                <input type="text" name="price[]" placeholder="Harga ${nextNumber}"
                class="price-input border border-gray-300 rounded-lg p-2 w-full" required>

                <button type="button" onclick="this.parentElement.remove(); updatePricePlaceholders()"
                class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm">X</button>`;

                container.appendChild(div);
            }

            window.updatePricePlaceholders = function() {
                const inputs = document.querySelectorAll('#priceInputs .price-input');
                inputs.forEach((input, index) => {
                    input.placeholder = `Harga ${index + 1}`;
                });
            };

            function formatRupiah(angka) {
                return angka.replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            // Format saat mengetik
            document.addEventListener("input", function(e) {
                if (e.target.classList.contains("price-input")) {

                    let cursor = e.target.selectionStart;
                    let before = e.target.value.length;

                    e.target.value = formatRupiah(e.target.value);

                    let after = e.target.value.length;
                    e.target.selectionEnd = cursor + (after - before);
                }
            });

            // Format sebelum submit → hilangkan titik
            document.getElementById("priceForm").addEventListener("submit", function() {
                document.querySelectorAll(".price-input").forEach(function(input) {
                    input.value = input.value.replace(/\./g, "");
                });
            });

        });
    </script>

@endsection
