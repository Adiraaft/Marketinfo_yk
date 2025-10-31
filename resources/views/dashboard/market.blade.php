@extends('layouts.admin')

@section('title', 'Dashboard')



@section('content')

    <div class="mt-7 px-15">
        <div class="flex gap-4 mt-4 justify-between items-center">
            <div>
                <h3 class="font-bold text-2xl text-secondary">Daftar Pasar</h3>
            </div>
            <button class="gap-1 px-4 py-2 rounded-lg bg-secondary cursor-pointer flex items-center justify-center">
                <i data-lucide="plus" class="w-4 h-4 text-white"></i>
                <p class="text-white">Tambah</p>
            </button>
            
        </div>
        
        <div class="mt-6 bg-white rounded-lg shadow-md overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="text-gray-400 border-b border-gray-200">
                    <tr>
                        <th class="py-3 px-4 font-medium text-sm">No</th>
                        <th class="py-3 px-4 font-medium text-sm">Nama Pasar</th>
                        <th class="py-3 px-4 font-medium text-sm">Alamat</th>
                        <th class="py-3 px-4 font-medium text-sm">Komoditas</th>
                        <th class="py-3 px-4 font-medium text-sm">Update terakhir</th>
                        <th class="py-3 px-4 font-medium text-sm">Status</th>
                        <th class="py-3 px-4 font-medium text-sm">Aksi</th>
                    </tr>
                </thead>

                <tbody class="text-gray-700">
                    <tr class="border-t border-gray-200 hover:bg-gray-50 text-sm font-medium">
                        <td class="py-2 px-4">1</td>
                        <td class="py-2 px-4">Pasar Prawirotaman</td>
                        <td class="py-2 px-4">Jln.Pegangsaan Timur No 56</td>
                        <td class="py-2 px-4">12</td>
                         <td class="py-2 px-4">12-09-2025 | 09.40</td>
                        <td class="py-2 px-4 text-green-600">Aktif</td>
                       
                        <td class="gap-1 items-end py-2 px-4">
                            <button class="text-black">
                                Edit <span class="text-black">|</span>
                            </button>
                            <button class="text-red-600 hover:underline">Hapus</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>


    </div>




@endsection
