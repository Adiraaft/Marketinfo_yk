@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="mt-7 px-15">
        <div class="flex gap-4 mt-4 justify-between items-center">
            <div>
                <h3 class="font-bold text-2xl text-secondary">Setting</h3>
            </div>
        </div>

        <!-- Wrapper utama -->
        <div class="w-full bg-white rounded-lg shadow-md mt-6 overflow-hidden">

            <!-- Tab Header -->
            <div class="flex bg-gray-200 border-b border-gray-300 text-sm font-medium text-gray-600 rounded-t-lg">
                <!-- General -->
                <a href="{{ route('superadmin.setting') }}"
                    class="px-6 py-3 border-b-2 transition-all duration-200 
                    hover:border-primary hover:text-primary
                    {{ request()->routeIs('superadmin.setting') ? 'border-primary text-primary font-semibold' : 'border-transparent' }}">
                    General
                </a>

                <!-- Manajemen -->
                <a href="{{ route('superadmin.kategori') }}"
                    class="px-6 py-3 border-b-2 transition-all duration-200 
                    hover:border-primary hover:text-primary
                    {{ request()->routeIs('superadmin.kategori') || request()->routeIs('superadmin.satuan') ? 'border-primary text-primary font-semibold' : 'border-transparent' }}">
                    Manajemen
                </a>

                <!-- Account -->
                <a href="{{ route('superadmin.kategori') }}"
                    class="px-6 py-3 border-b-2 transition-all duration-200 
                    hover:border-primary hover:text-primary
                    {{ request()->routeIs('superadmin.account') ? 'border-primary text-primary font-semibold' : 'border-transparent' }}">
                    Account
                </a>
            </div>

            <!-- Tab Content -->
            <div class="p-6 text-sm bg-white rounded-b-lg">
                
                <div class="flex gap-4 mb-6">
                    <!-- Manajemen Kategori -->
                    <a href="{{ route('superadmin.kategori') }}">
                        <button
                            class="py-3 px-5 rounded-md text-sm font-bold transition-all duration-200 
                            {{ request()->routeIs('superadmin.kategori') ? 'bg-primary text-white' : 'bg-primary/60 text-white hover:bg-gray-400' }}">
                            Manajemen Kategori
                        </button>
                    </a>

                    <!-- Manajemen Satuan -->
                    <a href="{{ route('superadmin.satuan') }}">
                        <button
                            class="py-3 px-5 rounded-md text-sm font-bold transition-all duration-200 
                            {{ request()->routeIs('superadmin.satuan') ? 'bg-primary text-white' : 'bg-primary/60 text-white hover:bg-gray-400' }}">
                            Manajemen Satuan
                        </button>
                    </a>
                </div>

                <!-- Form tambah satuan -->
                <p class="text-secondary text-2xl font-medium mb-4">Formulir Penambahan Satuan</p>

                <form action="{{ route('superadmin.satuan.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Nama Satuan</label>
                        <input type="text" id="name_unit" name="name_unit" required
                            class="w-75 border text-gray-600 border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none">
                    </div>

                    <button type="submit"
                        class="mt-2 bg-primary text-white font-semibold py-3 px-10 rounded-lg hover:bg-primary/80 transition-all duration-200 shadow-sm">
                        Tambah
                    </button>
                </form>

                <!-- Tabel Daftar Satuan -->
                <div class="mt-8 w-3/4">
                    <h4 class="text-secondary text-lg font-semibold mb-3">Daftar Satuan</h4>

                    <div class="overflow-x-auto rounded-lg">
                        <table class="w-[480px] text-sm text-gray-700 border border-gray-200">
                            <thead class="bg-primary/10 text-primary font-semibold">
                                <tr>
                                    <th class="py-3 px-6 text-left border-r border-gray-300">Nama Satuan</th>
                                    <th class="py-3 px-6 text-center w-[120px]">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($satuans as $satuan)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="py-3 px-6 border-r border-gray-200">{{ $satuan->name_unit }}</td>
                                        <td class="py-3 px-6 flex justify-center gap-3">
                                            <!-- Tombol Edit -->
                                            <button onclick="openEditModal('{{ $satuan->id }}', '{{ $satuan->name_unit }}')"
                                                class="text-blue-500 hover:text-blue-700 transition">
                                                <i data-lucide="edit" class="w-5 h-5"></i>
                                            </button>

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('superadmin.satuan.destroy', $satuan->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus satuan ini?')"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 transition">
                                                    <i data-lucide="trash-2" class="w-5 h-5"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center py-4 text-gray-500">Belum ada data satuan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div id="editModal" class="hidden fixed inset-0 bg-gray-900/40 flex justify-center items-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-96 p-6 relative">
            <h3 class="text-lg font-semibold text-secondary mb-4">Edit Satuan</h3>

            <form id="editForm" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm text-gray-500 mb-1">Nama Satuan</label>
                    <input type="text" id="edit_name" name="name_unit" required
                        class="w-full border text-gray-600 border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none">
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeEditModal()"
                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">Batal</button>
                    <button type="submit"
                        class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/80">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, name_unit) {
            const modal = document.getElementById('editModal');
            const form = document.getElementById('editForm');
            const input = document.getElementById('edit_name');

            form.action = `/superadmin/satuan/${id}`;
            input.value = name_unit;

            modal.classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>
@endsection
