@extends('layouts.home')

@section('title', 'Detail Pasar')

@section('navbar')
    <x-navbar-color />

@endsection

@section('content')
    <div class="mx-15 mt-5 mb-20">
        <a href="{{ route('home.index') }}" class="text-blue-500 hover:underline mt-3 inline-block">
            ← Kembali
        </a>
        <h2 class="text-4xl font-bold mt-4 text-center">Grafik Harga</h2>
        <h2 class="text-4xl font-bold mt-4 text-center">Telur Ayam</h2>
        <div class="grid grid-cols-12 mt-10 gap-8">
            {{-- kiri (4 kolom) --}}
            <div class="col-span-12 md:col-span-4 space-y-5">
                <img src="{{ asset('images/telur.jpg') }}" class="w-full h-100 object-cover rounded-lg" alt="berita1">
            </div>

            {{-- kanan (8 kolom) --}}
            <div class="col-span-12 md:col-span-8 space-y-4">
                <h2 class="text-xl font-bold">Harga Telur Ayam per Hari ini</h2>
                <div class="mt-2 bg-white rounded-lg shadow-md overflow-hidden inline-block">
                    <table class="w-auto text-left border-collapse">
                        <thead class="text-gray-400 border-b border-gray-200">
                            <tr>
                                <th class="py-3 px-20 font-medium text-sm">Nama Bahan</th>
                                <th class="py-3 px-20 font-medium text-sm">Berat</th>
                                <th class="py-3 px-20 font-medium text-sm">Harga</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            <tr class="border-t border-gray-200 hover:bg-gray-50 text-sm font-medium">
                                <td class="py-2 px-20">Telur Ayam</td>
                                <td class="py-2 px-20">1 kg (1000 g)</td>
                                <td class="py-2 px-20">Rp 25.000</td>
                            </tr>
                            <tr class="border-t border-gray-200 hover:bg-gray-50 text-sm font-medium">
                                <td class="py-2 px-20">Telur Ayam</td>
                                <td class="py-2 px-20">¼ kg (500 g)</td>
                                <td class="py-2 px-20">Rp 13.000</td>
                            </tr>
                            <tr class="border-t border-gray-200 hover:bg-gray-50 text-sm font-medium">
                                <td class="py-2 px-20">Telur Ayam</td>
                                <td class="py-2 px-20">1 kg (250 g)</td>
                                <td class="py-2 px-20">Rp 7.000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


        </div>

        <div class="flex gap-4 mt-12 justify-center w-full">
            <div class="text-sm">
                <label for="kategori" class="block mb-1 text-gray-700">Pilih Tanggal</label>
                <select id="kategori" name="kategori"
                    class="border border-gray-300 rounded-md p-1 w-40 text-xs focus:ring-blue-400 focus:border-blue-400">
                    <option value="#">Pilih</option>
                    <option value="beras">7 Hari Terakhir</option>
                    <option value="cabai">30 Hari Terakhir</option>
                    <option value="telur">1 Tahun Terakhir</option>
                </select>
            </div>
            <div class="text-sm">
                <label for="kategori" class="block mb-1 text-gray-700">Pilih Pasar</label>
                <select id="kategori" name="kategori"
                    class="border border-gray-300 rounded-md p-1 w-40 text-xs focus:ring-blue-400 focus:border-blue-400">
                    <option value="#">Semua Pasar</option>
                    <option value="beras">Malioboro</option>
                    <option value="cabai">Prawirotaman</option>
                    <option value="telur">Beringharjo</option>
                </select>
            </div>
            <div class="flex gap-2 items-end mr-60">
                <button class="py-1.5 px-3 rounded-md bg-secondary cursor-pointer">
                    <p class="text-white text-xs font-medium">Tampilkan</p>
                </button>
            </div>
            <div class="flex gap-2 items-end justify-end">
                <button class="py-1.5 px-3 rounded-md bg-green-900 cursor-pointer">
                    <p class="text-white text-xs font-medium">Export Excel</p>
                </button>
                <button class="py-1.5 px-3 rounded-md bg-red-900 cursor-pointer">
                    <p class="text-white text-xs font-medium">Export PDF</p>
                </button>
            </div>
        </div>
        <div class="bg-white w-250 p-6 rounded-lg shadow-md mt-6 mx-auto">
            <div
                class="w-full h-80 border border-dashed border-gray-300 rounded-md flex items-center justify-center text-gray-400">
                Area Grafik
            </div>
        </div>


        <h2 class="text-xl font-bold mt-6">Bandingkan Harga Pasar Anda dengan Pasar Lain</h2>
        <div class="flex flex-col md:flex-row gap-4 mt-6">
            <!-- KIRI: Menu Dropdown -->
            <div class="flex flex-col gap-4 w-full md:w-1/3">
                <div class="flex flex-col gap-4 w-full">
                    <!-- Dropdown Pilih Tanggal -->
                    <div class="text-sm">
                        <label for="tanggal" class="block mb-1 text-gray-700">Pilih Tanggal</label>
                        <select id="tanggal" name="tanggal"
                            class="border border-gray-300 rounded-md p-1 w-80 h-8 text-md focus:ring-blue-400 focus:border-blue-400">
                            <option value="#">Pilih</option>
                            <option value="7hari">7 Hari Terakhir</option>
                            <option value="30hari">30 Hari Terakhir</option>
                            <option value="1tahun">1 Tahun Terakhir</option>
                        </select>
                    </div>

                    <!-- Baris Pilih Pasar + Tombol -->
                    <div class="flex items-end gap-3 text-sm">
                        <div>
                            <label for="pasar" class="block mb-1 text-gray-700">Pilih Pasar</label>
                            <select id="pasar" name="pasar"
                                class="border border-gray-300 rounded-md p-1 w-80 h-8 text-md focus:ring-blue-400 focus:border-blue-400">
                                <option value="#">Semua Pasar</option>
                                <option value="malioboro">Malioboro</option>
                                <option value="prawirotaman">Prawirotaman</option>
                                <option value="beringharjo">Beringharjo</option>
                            </select>
                        </div>

                        <button class="p-2 w-8 h-8 rounded-lg bg-secondary cursor-pointer flex items-center justify-center">
                            <i data-lucide="search" class="w-4 h-4 text-white"></i>
                        </button>
                    </div>
                </div>
            </div>


            <!-- KANAN: Tabel Harga -->
            <div class="col-span-12 md:col-span-8 space-y-4 w-full md:w-2/3">
                <div class="mt-2 bg-white rounded-lg shadow-md overflow-hidden">
                    <table class="w-full text-left border-collapse table-auto">
                        <thead class="text-gray-400 border-b border-gray-200">
                            <tr>
                                <th class="py-3 px-6 font-medium text-sm text-center w-1/4">Harga Pasar Anda</th>
                                <th class="py-3 px-6 font-medium text-sm text-center w-1/4">Selisih</th>
                                <th class="py-3 px-6 font-medium text-sm text-center w-1/4">Harga</th>
                                <th class="py-3 px-6 font-medium text-sm text-center w-1/4">Pasar lain</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            <tr class="border-t border-gray-200 hover:bg-gray-50 text-sm font-medium text-center">
                                <td class="py-2 px-6">24.000</td>
                                <td class="py-2 px-6">3.000</td>
                                <td class="py-2 px-6">Rp 27.000</td>
                                <td class="py-2 px-6">Giwangan</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


        </div>






    </div>
@endsection
