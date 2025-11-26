@extends('layouts.admin')

@section('title', 'Home')


@section('content')
    <div class="my-7 px-15">
        <h3 class="font-bold text-2xl text-secondary">Daftar Komoditas</h3>
        <div class="flex gap-4 mt-4">
            <div>
                <label for="kategori" class="block">Pilih Kategori</label>
                <select id="kategori" name="kategori"
                    class="border bg-white border-gray-300 rounded-lg p-1 w-60 focus:ring-blue-500 focus:border-blue-500">
                    <option value="#">Semua Kategori</option>
                    <option value="beras">Beras</option>
                    <option value="cabai">Cabai</option>
                    <option value="telur">Telur</option>
                </select>
            </div>
            <div>
                <label for="" class="block">Pilih Tanggal</label>
                <input type="date"
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
                <a href="{{ route('superadmin.setting') }}"
                    class="px-6 py-4 border-b-2 transition-all duration-200 
               hover:border-primary hover:text-primary
               {{ request()->routeIs('admin.komoditas') ? 'border-primary text-primary font-semibold' : 'border-transparent' }}">
                    Semua 118
                </a>

                <!-- Manajemen -->
                <a href=""
                    class="px-6 py-4 border-b-2 transition-all duration-200 
               hover:border-primary hover:text-primary
               {{ request()->routeIs('') ? 'border-primary text-primary font-semibold' : 'border-transparent' }}">
                    Belum Update 39
                </a>

                <!-- Account -->
                <a href=""
                    class="px-6 py-4 border-b-2 transition-all duration-200 
               hover:border-primary hover:text-primary
               {{ request()->routeIs('') ? 'border-primary text-primary font-semibold' : 'border-transparent' }}">
                    Sudah Update 79
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
                                <td class="py-2 px-4">{{ $c->name_commodity }}</td>
                                <td class="py-2 px-4">{{ $c->category->name_category ?? '-' }}</td>
                                <td class="py-2 px-4">{{ $c->unit->name ?? '-' }}</td>
                                <td class="py-2 px-4">-</td> {{-- nanti diisi rata-rata harga --}}
                                <td class="py-2 px-4">Belum Update</td>
                                <td class="py-2 px-4">
                                    @if ($pivot)
                                        <button type="button"
                                            onclick="openPriceModal({{ $pivot->id }}, '{{ addslashes($c->name_commodity) }}')"
                                            class="text-blue-600 hover:underline">
                                            Update
                                        </button>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
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
                <input type="hidden" id="commodityId" name="commodityId">

                <div id="priceInputs">
                    <div class="mb-2 flex gap-2 items-center">
                        <input type="number" name="price[]" placeholder="Harga 1" required
                            class="border border-gray-300 rounded-lg p-2 w-full">
                    </div>
                </div>

                <button type="button" onclick="addPriceInput()"
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

            window.openPriceModal = function(pivotId, commodityName) {
                priceCount = 1;
                const commodityIdInput = document.getElementById('commodityId');
                const commodityNameText = document.getElementById('commodityName');
                const priceInputs = document.getElementById('priceInputs');
                const modal = document.getElementById('priceModal');

                if (!commodityIdInput || !commodityNameText || !priceInputs || !modal) {
                    console.error('Element modal tidak ditemukan!');
                    return;
                }

                commodityIdInput.value = pivotId;
                commodityNameText.innerText = commodityName;

                priceInputs.innerHTML = `
            <div class="mb-2 flex gap-2 items-center">
                <input type="number" name="price[]" placeholder="Harga 1" required
                    class="border border-gray-300 rounded-lg p-2 w-full">
            </div>
        `;

                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            window.closePriceModal = function() {
                const modal = document.getElementById('priceModal');
                if (!modal) return;
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }

            window.addPriceInput = function() {
                const container = document.getElementById('priceInputs');
                // Hitung jumlah input saat ini
                const currentCount = container.querySelectorAll('input[name="price[]"]').length + 1;

                const div = document.createElement('div');
                div.classList.add('mb-2', 'flex', 'gap-2', 'items-center');
                div.innerHTML = `
        <input type="number" name="price[]" placeholder="Harga ${currentCount}" required
            class="border border-gray-300 rounded-lg p-2 w-full">
        <button type="button" onclick="this.parentElement.remove()"
            class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm">X</button>
    `;
                container.appendChild(div);
            }

        });
    </script>


@endsection
