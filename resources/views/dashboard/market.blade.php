@extends('layouts.admin')

@section('title', 'Dashboard Pasar')

@section('content')

    <div class="mt-7 px-15">
        <div class="flex gap-4 mt-4 justify-between items-center">
            <div>
                <h3 class="font-bold text-2xl text-secondary">Daftar Pasar</h3>
            </div>
            <a href="{{ route('superadmin.market.create') }}">
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
                        <th class="py-3 px-4 font-medium text-sm">Nama Pasar</th>
                        <th class="py-3 px-4 font-medium text-sm">Alamat</th>
                        <th class="py-3 px-4 font-medium text-sm">Komoditas</th>
                        <th class="py-3 px-4 font-medium text-sm">Update terakhir</th>
                        <th class="py-3 px-4 font-medium text-sm">Status</th>
                        <th class="py-3 px-4 font-medium text-sm">Aksi</th>
                    </tr>
                </thead>

                <tbody class="text-gray-700">
                    @foreach ($markets as $index => $m)
                        <tr class="border-t border-gray-200 hover:bg-gray-50 text-sm font-medium">
                            <td class="py-2 px-4">{{ $index + 1 }}</td>
                            <td class="py-2 px-4">{{ $m->name_market }}</td>
                            <td class="py-2 px-4 max-w-[250px] truncate block">{{ $m->address }}</td>
                            <td class="py-2 px-4">12</td>
                            <td class="py-2 px-4">12-09-2025 | 09.40</td>
                            <td class="py-2 px-4">{{ ucfirst($m->status) }}</td>

                            <td class="gap-1 items-end py-2 px-4">
                                <a href="{{ route('superadmin.market.edit', $m->id_market) }}" class="text-blue-500">Edit
                                    <span class="text-black">|</span>
                                </a>
                                <form id="deleteForm{{ $m->id_market }}"
                                    action="{{ route('superadmin.market.destroy', $m->id_market) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="deleteBtn text-red-500 underline"
                                        data-id="{{ $m->id_market }}">
                                        Hapus
                                    </button>
                                </form>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.deleteBtn').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;
                    Swal.fire({
                        title: 'Apakah kamu yakin?',
                        text: "Data ini akan dihapus!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('deleteForm' + id).submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection
