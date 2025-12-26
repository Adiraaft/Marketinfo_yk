@extends('layouts.admin')

@section('title', 'Dashboard Komoditas')

@section('content')

    <div class="my-7 px-15">
        <h3 class="font-bold text-2xl text-secondary">Daftar Komoditas</h3>
        <form action="{{ route('superadmin.komoditas') }}" method="GET" class="w-full">
            <div class="flex gap-4 mt-4">
                <div>
                    <label for="kategori" class="block">Pilih Kategori</label>
                    <select id="kategori" name="kategori"
                        class="border bg-white border-gray-300 rounded-lg p-1 w-60 focus:ring-blue-500 focus:border-blue-500">
                        <option value="#">Semua Kategori</option>
                        @foreach ($categories as $c)
                            <option value="{{ $c->id_category }}"
                                {{ request('kategori') == $c->id_category ? 'selected' : '' }}>
                                {{ $c->name_category }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex w-full justify-between items-end">
                    <button class="py-2 px-4 rounded-lg bg-secondary self-end cursor-pointer">
                        <p class="text-white">Tampilkan</p>
                    </button>
                    <div class="flex items-center gap-4">
                        <button type="button" class="border-gray-300 border-2 bg-white rounded-lg py-2 pl-3 pr-45">
                            search
                        </button>
                        <button class="p-3 rounded-lg bg-secondary cursor-pointer flex items-center justify-center">
                            <i data-lucide="search" class="w-4 h-4 text-white"></i>
                        </button>
                        <button type="button"
                            class="btn-add-commodity gap-1 px-4 py-2 rounded-lg bg-secondary cursor-pointer flex items-center justify-center">
                            <i data-lucide="plus" class="w-4 h-4 text-white"></i>
                            <p class="text-white">Tambah</p>
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <div class="mt-6 bg-white rounded-lg shadow-md overflow-hidden">
            <div class="max-h-[550px] overflow-y-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="text-gray-400 border-b border-gray-200">
                        <tr>
                            <th class="py-3 px-4 font-medium text-sm">No</th>
                            <th class="py-3 px-4 font-medium text-sm">Nama Barang</th>
                            <th class="py-3 px-4 font-medium text-sm">Kategori</th>
                            <th class="py-3 px-4 font-medium text-sm">Satuan</th>
                            <th class="py-3 px-4 font-medium text-sm">Rata-Rata Harga</th>
                            <th class="py-3 px-4 font-medium text-sm">Terakhir Update</th>
                            <th class="py-3 px-4 font-medium text-sm">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="text-gray-700">
                        @forelse ($commodities as $index => $c)
                            <tr class="border-t border-gray-200 hover:bg-gray-50 text-sm font-medium">

                                {{-- No --}}
                                <td class="py-2 px-4">{{ $index + 1 }}</td>

                                {{-- Nama + Gambar --}}
                                <td class="py-2 px-4">
                                    <div class="flex items-center gap-3">

                                        {{-- Jika tidak punya gambar --}}
                                        @php
                                            $img = $c->image ?? 'default.png';
                                        @endphp

                                        <img src="{{ asset('storage/commodity_images/' . $img) }}"
                                            alt="{{ $c->name_commodity }}"
                                            class="w-8 h-8 rounded-full object-cover border border-gray-300">

                                        <span>{{ $c->name_commodity }}</span>
                                    </div>
                                </td>

                                {{-- Kategori --}}
                                <td class="py-2 px-4">
                                    {{ $c->category->name_category ?? '-' }}
                                </td>

                                {{-- Satuan --}}
                                <td class="py-2 px-4">
                                    {{ $c->unit->name_unit ?? '-' }}
                                </td>

                                {{-- Rata-rata Harga (jika belum ada → '-') --}}
                                <td class="py-2 px-4">
                                    @if (isset($c->average_price))
                                        Rp {{ number_format($c->average_price, 0, ',', '.') }}
                                    @else
                                        -
                                    @endif
                                </td>

                                {{-- Terakhir Update --}}
                                <td class="py-2 px-4">
                                    {{ $c->updated_at ? $c->updated_at->format('d M Y') : '-' }}
                                </td>

                                {{-- Aksi --}}
                                <td class="gap-1 items-end py-2 px-4">
                                    <button class="text-blue-600 hover:underline"
                                        onclick="openDetail({{ $c->id_commodity }})">
                                        Detail <span class="text-black">|</span>
                                    </button>

                                    <button class="text-blue-600 hover:underline"
                                        onclick="openEdit({{ $c->id_commodity }})">
                                        Edit <span class="text-black">|</span>
                                    </button>

                                    <form action="{{ route('superadmin.komoditas.destroy', $c->id_commodity) }}"
                                        method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn-delete text-red-600 hover:underline">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-gray-500">Belum ada komoditas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Create Komoditas -->
    <div id="modalCreate"
        class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 hidden opacity-0 transition-opacity duration-150">
        <div class="bg-white w-[500px] rounded-xl shadow-lg p-6">

            <h2 class="text-xl font-bold text-secondary mb-4">Tambah Komoditas</h2>

            <form action="{{ route('superadmin.komoditas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Nama Komoditas -->
                <div class="mb-4">
                    <label class="block font-medium mb-1">Nama Komoditas</label>
                    <input type="text" name="name_commodity"
                        class="border border-gray-300 rounded-lg p-2 w-full focus:ring-secondary focus:border-secondary"
                        placeholder="Contoh: Beras Premium" value="{{ old('name_commodity') }}" required>
                </div>

                <!-- Kategori (Dinamis) -->
                <div class="mb-4">
                    <label class="block font-medium mb-1">Kategori</label>
                    <select name="category_id"
                        class="border border-gray-300 rounded-lg p-2 w-full focus:ring-secondary focus:border-secondary"
                        required>
                        <option value="">Pilih Kategori</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id_category }}"
                                {{ old('category_id') == $cat->id_category ? 'selected' : '' }}>
                                {{ $cat->name_category }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <!-- Satuan (Dinamis) -->
                <div class="mb-4">
                    <label class="block font-medium mb-1">Satuan</label>
                    <select name="unit_id"
                        class="border border-gray-300 rounded-lg p-2 w-full focus:ring-secondary focus:border-secondary"
                        required>
                        <option value="">Pilih Satuan</option>
                        @foreach ($units as $unit)
                            <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                {{ $unit->name_unit }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Upload Gambar -->
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Gambar Komoditas</label>
                    <div class="flex items-center gap-4">
                        <input type="file" name="image" id="create_image" accept="image/*"
                            class="block w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-lg file:border-0
                            file:text-sm file:font-semibold
                            file:bg-blue-600 file:text-white
                            hover:file:bg-blue-700">
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" id="closeModalCreate"
                        class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300">
                        Batal
                    </button>

                    <button type="submit" class="px-4 py-2 rounded-lg bg-secondary text-white hover:bg-secondary/90">
                        Simpan
                    </button>
                </div>
            </form>

        </div>
    </div>
    <!-- Modal Edit Komoditas -->
    <div id="modalEdit"
        class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 hidden opacity-0 transition-opacity duration-150">

        <div class="bg-white w-[500px] rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-bold text-secondary mb-4">Edit Komoditas</h2>

            <form id="formEdit" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Nama Komoditas -->
                <div class="mb-4">
                    <label class="block font-medium mb-1">Nama Komoditas</label>
                    <input type="text" id="edit_name" name="name_commodity"
                        class="border border-gray-300 rounded-lg p-2 w-full focus:ring-secondary focus:border-secondary">
                </div>

                <!-- Kategori -->
                <div class="mb-4">
                    <label class="block font-medium mb-1">Kategori</label>
                    <select id="edit_category" name="category_id"
                        class="border border-gray-300 rounded-lg p-2 w-full focus:ring-secondary focus:border-secondary">
                    </select>
                </div>

                <!-- Unit -->
                <div class="mb-4">
                    <label class="block font-medium mb-1">Satuan</label>
                    <select id="edit_unit" name="unit_id"
                        class="border border-gray-300 rounded-lg p-2 w-full focus:ring-secondary focus:border-secondary">
                    </select>
                </div>

                <!-- Gambar -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-500 mb-1">Gambar Komoditas</label>
                    <div class="flex items-center gap-4">
                        <input type="file" id="edit_image" name="image" accept="image/*"
                            class="block w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-lg file:border-0
                            file:text-sm file:font-semibold
                            file:bg-blue-600 file:text-white
                            hover:file:bg-blue-700">
                    </div>
                </div>


                <!-- Tombol -->
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeEdit()"
                        class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300">
                        Batal
                    </button>

                    <button type="submit" class="px-4 py-2 rounded-lg bg-secondary text-white hover:bg-secondary/90">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- sweetalert --}}
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
        document.addEventListener('DOMContentLoaded', () => {
            // --- OPEN modal Create ---
            document.querySelector(".btn-add-commodity")?.addEventListener("click", () => {
                const modal = document.getElementById("modalCreate");
                modal.classList.remove("hidden");
                setTimeout(() => modal.classList.remove("opacity-0"), 10);
            });

            // --- CLOSE modal Create ---
            document.getElementById("closeModalCreate")?.addEventListener("click", () => {
                const modal = document.getElementById("modalCreate");
                modal.classList.add("opacity-0");
                setTimeout(() => modal.classList.add("hidden"), 150);

                // Reset form
                const form = modal.querySelector("form");
                if (form) form.reset();
            });
        });

        // --- EDIT modal functions ---
        function openEdit(id) {
            fetch(`/superadmin/komoditas/${id}/edit`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(res => {
                    if (!res.ok) throw new Error('Network response was not ok');
                    return res.json();
                })
                .then(data => {
                    // form action
                    const form = document.getElementById('formEdit');
                    form.action = `/superadmin/komoditas/${id}`;

                    // set fields
                    document.getElementById('edit_name').value = data.commodity.name_commodity ?? '';

                    // category
                    document.getElementById('edit_category').innerHTML = data.categories.map(c => {
                        const sel = (data.commodity.category_id == c.id_category) ? 'selected' : '';
                        return `<option value="${c.id_category}" ${sel}>${c.name_category}</option>`;
                    }).join('');

                    // unit
                    document.getElementById('edit_unit').innerHTML = data.units.map(u => {
                        const sel = (data.commodity.unit_id == u.id) ? 'selected' : '';
                        return `<option value="${u.id}" ${sel}>${u.name_unit}</option>`;
                    }).join('');

                    // open modal
                    const modal = document.getElementById('modalEdit');
                    modal.classList.remove('hidden');
                    setTimeout(() => modal.classList.remove('opacity-0'), 10);
                })
                .catch(err => {
                    console.error(err);
                    alert('Gagal memuat data edit. Cek console untuk detail.');
                });
        }

        function closeEdit() {
            const modal = document.getElementById("modalEdit");
            modal.classList.add("opacity-0");
            setTimeout(() => modal.classList.add("hidden"), 150);

            // Reset form
            const form = modal.querySelector("form");
            if (form) form.reset();
        }
    </script>


    <script>
        // --- CONFIRM DELETE ---
        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault(); // prevent default form submit
                const form = this.closest('form');
                Swal.fire({
                    title: 'Yakin ingin hapus?',
                    text: "Data komoditas akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // --- CONFIRM UPDATE ---
        const formEdit = document.getElementById('formEdit');
        formEdit?.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Yakin ingin update?',
                text: "Data komoditas akan diperbarui!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Ya, update!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    formEdit.submit();
                }
            });
        });
    </script>


@endsection
