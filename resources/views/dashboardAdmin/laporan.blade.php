@extends('layouts.admin')

@section('title', 'Home')

@section('content')
    <div class="mt-7 px-15">
        <h3 class="font-bold text-2xl text-secondary">Laporan Harga Komoditas Pasar</h3>
        <h2 class="text-secondary mt-2">Silakan pilih komoditas dan periode waktu untuk melihat laporan.</h2>
        <div class="flex gap-4 mt-4">
            <div class="text-sm">
                <label for="kategori" class="block mb-1 text-gray-700">Pilih Kategori</label>
                <select id="kategori" name="kategori"
                    class="border border-gray-300 bg-white rounded-md p-1 w-40 text-xs focus:ring-blue-400 focus:border-blue-400">
                    <option value="#">Semua Kategori</option>
                    <option value="beras">Beras</option>
                    <option value="cabai">Cabai</option>
                    <option value="telur">Telur</option>
                </select>
            </div>

            <div class="text-sm">
                <label for="kategori" class="block mb-1 text-gray-700">Pilih Komoditas</label>
                <select id="kategori" name="kategori"
                    class="border border-gray-300 bg-white rounded-md p-1 w-40 text-xs focus:ring-blue-400 focus:border-blue-400">
                    <option value="#">Semua Komoditas</option>
                    <option value="beras">Beras</option>
                    <option value="cabai">Cabai</option>
                    <option value="telur">Telur</option>
                </select>
            </div>
            <div class="text-sm">
                <label for="kategori" class="block mb-1 text-gray-700">Pilih Tanggal</label>
                <select id="kategori" name="kategori"
                    class="border border-gray-300 rounded-md bg-white p-1 w-40 text-xs focus:ring-blue-400 focus:border-blue-400">
                    <option value="#">Pilih</option>
                    <option value="beras">7 Hari Terakhir</option>
                    <option value="cabai">30 Hari Terakhir</option>
                    <option value="telur">1 Tahun Terakhir</option>
                </select>
            </div>
            <div class="flex w-full gap-2 items-end">
                <button class="py-1.5 px-3 rounded-md bg-secondary cursor-pointer">
                    <p class="text-white text-xs font-medium">Tampilkan</p>
                </button>
            </div>
            <div class="flex w-full gap-2 items-end justify-end">
                <button class="py-1.5 px-3 rounded-md bg-green-500 cursor-pointer">
                    <p class="text-white text-xs font-medium">Export Excel</p>
                </button>
                <button class="py-1.5 px-3 rounded-md bg-red-500 cursor-pointer">
                    <p class="text-white text-xs font-medium">Export PDF</p>
                </button>
            </div>

        </div>


        <div class="mt-6 bg-white rounded-lg shadow-md overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="text-gray-400 border-b border-gray-200">
                    <tr>
                        <th class="py-3 px-4 font-medium text-sm">Tanggal</th>
                        <th class="py-3 px-4 font-medium text-sm">Nama Komoditas</th>
                        <th class="py-3 px-4 font-medium text-sm">Pasar</th>
                        <th class="py-3 px-4 font-medium text-sm">Harga</th>
                        <th class="py-3 px-4 font-medium text-sm">Update Oleh</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <tr class="border-t border-gray-200 hover:bg-gray-50 text-sm font-medium">
                        <td class="py-2 px-4"></td>
                        <td class="py-2 px-4"></td>
                        <td class="py-2 px-4"></td>
                        <td class="py-2 px-4"></td>
                        <td class="py-2 px-4"></td>
                    </tr>
                </tbody>
            </table>
        </div>




    </div>



@endsection
