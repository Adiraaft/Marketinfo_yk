@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

    <div class="mt-7 px-15">
        <h3 class="font-bold text-2xl text-secondary">Daftar Komoditas</h3>
        <div class="flex gap-4 mt-4">
            <div>
                <label for="kategori" class="block">Pilih Kategori</label>
                <select id="kategori" name="kategori"
                    class="border border-gray-300 rounded-lg p-1 w-60 focus:ring-blue-500 focus:border-blue-500">
                    <option value="#">Semua Kategori</option>
                    <option value="beras">Beras</option>
                    <option value="cabai">Cabai</option>
                    <option value="telur">Telur</option>
                </select>
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
                    <button class="gap-1 px-4 py-2 rounded-lg bg-secondary cursor-pointer flex items-center justify-center">
                        <i data-lucide="plus" class="w-4 h-4 text-white"></i>
                        <p class="text-white">Tambah</p>
                    </button>
                </div>
            </div>
        </div>

        <div class="mt-6 bg-white rounded-lg shadow-md overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="text-gray-400 border-b border-gray-200">
                    <tr>
                        <th class="py-3 px-4 font-medium text-sm">No</th>
                        <th class="py-3 px-4 font-medium text-sm">Nama Barang</th>
                        <th class="py-3 px-4 font-medium text-sm">Kategori</th>
                        <th class="py-3 px-4 font-medium text-sm">Status</th>
                        <th class="py-3 px-4 font-medium text-sm">Rata-Rata Harga</th>
                        <th class="py-3 px-4 font-medium text-sm">Aksi</th>
                    </tr>
                </thead>

                <tbody class="text-gray-700">
                    <tr class="border-t border-gray-200 hover:bg-gray-50 text-sm font-medium">
                        <td class="py-2 px-4">1</td>

                        <!-- Kolom Nama Barang -->
                        <td class="py-2 px-4">
                            <div class="flex items-center gap-3">
                                <!-- Gambar lingkaran kecil -->
                                <img src="{{ asset('images/tomat.png')}}" alt="Cabai Merah"
                                    class="w-8 h-8 rounded-full object-cover border border-gray-300">
                                <span>Cabai Merah</span>
                            </div>
                        </td>

                        <td class="py-2 px-4">Cabai</td>
                        <td class="py-2 px-4 text-green-600">Aktif</td>
                        <td class="py-2 px-4">Rp 25.000</td>
                        <td class="gap-1 items-end py-2 px-4">
                            <button class="text-blue-600 hover:underline">Edit <span class="text-black">|</span></button>
        
                            <button class="text-red-600 hove:underline">Hapus</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>




@endsection
