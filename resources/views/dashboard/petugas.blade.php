@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

    <div class="mt-7 px-15">
        <div class="flex gap-4 mt-4 justify-between items-center">
            <div>
                <h3 class="font-bold text-2xl text-secondary">Daftar Petugas</h3>
            </div>
            <a href="{{ route('superadmin.petugas.create') }}">
                <button class="gap-1 px-4 py-2 rounded-lg bg-secondary cursor-pointer flex items-center justify-center">
                    <i data-lucide="plus" class="w-4 h-4 text-white"></i>
                    <p class="text-white">Tambah</p>
                </button>
            </a>
        </div>

        <div class="mt-6 bg-white rounded-lg shadow-md overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="text-gray-400 border-b border-gray-200">
                    <tr>
                        <th class="py-3 px-4 font-medium text-sm">No</th>
                        <th class="py-3 px-4 font-medium text-sm">Nama Petugas</th>
                        <th class="py-3 px-4 font-medium text-sm">Username / Email</th>
                        <th class="py-3 px-4 font-medium text-sm">Pasar Tugas</th>
                        <th class="py-3 px-4 font-medium text-sm">Status</th>
                        <th class="py-3 px-4 font-medium text-sm">Aksi</th>
                    </tr>
                </thead>

                <tbody class="text-gray-700">
                    @foreach ($petugas as $index => $p)
                        <tr class="border-t border-gray-200 hover:bg-gray-50 text-sm font-medium">
                            <td class="py-2 px-4">{{ $index + 1 }}</td>
                            <td class="py-2 px-4">{{ $p->name }}</td>
                            <td class="py-2 px-4">{{ $p->email }}</td>
                            <td class="py-2 px-4">{{ $p->market ? $p->market->name_market : '-' }}</td>
                            <td class="py-2 px-4">{{ ucfirst($p->status) }}</td>
                            <td class="gap-1 items-end py-2 px-4">
                                <a href="{{ route('superadmin.petugas.edit', $p->id_user) }}" class="text-blue-500">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @if (session('success'))
        <script type="module">
            Swal.fire({
                title: "Berhasil!",
                text: "{{ session('success') }}",
                icon: "success",
                confirmButtonText: "OK"
            });
        </script>
    @endif
    
@endsection
