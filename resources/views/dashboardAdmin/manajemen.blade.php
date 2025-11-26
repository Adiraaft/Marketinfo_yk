@extends('layouts.admin')

@section('title', 'Home')

@section('content')
    <div class="mt-7 px-15">
        <h3 class="font-bold text-2xl text-secondary">Daftar Komoditas</h3>
        <div class="flex gap-4 mt-4">
            <div>
                <label for="kategori" class="block">Pilih Kategori</label>
                <select id="kategori" name="kategori"
                    class="border border-gray-300 rounded-lg p-1 w-60 bg-white focus:ring-blue-500 focus:border-blue-500">
                    <option value="#">Semua Kategori</option>
                    <option value="beras">Beras</option>
                    <option value="cabai">Daging</option>
                    <option value="telur">Sayuran</option>
                </select>
            </div>
            <div>
                <label for="kategori" class="block">Pilih Komoditas</label>
                <select id="kategori" name="kategori"
                    class="border border-gray-300 rounded-lg p-1 w-60 bg-white focus:ring-blue-500 focus:border-blue-500">
                    <option value="#">Semua Komoditas</option>
                    <option value="beras">Beras</option>
                    <option value="cabai">Cabai</option>
                    <option value="telur">Telur</option>
                </select>
            </div>
            <div class="flex w-full justify-between items-end">
                <button class="py-2 px-4 rounded-lg bg-secondary self-end cursor-pointer">
                    <p class="text-white">Tampilkan</p>
                </button>
            </div>
        </div>

        <div class="mt-6 bg-white rounded-lg shadow-md overflow-hidden">
            <div class="max-h-[550px] overflow-y-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="text-gray-400 border-b border-gray-200">
                        <tr>
                            <th class="py-3 px-4 font-medium text-sm">No</th>
                            <th class="py-3 px-4 font-medium text-sm">Nama Barang</th>
                            <th class="py-3 px-4 font-medium text-sm">Kategori</th>
                            <th class="py-3 px-4 font-medium text-sm">Satuan</th>
                            <th class="py-3 px-4 font-medium text-sm">Terakhir Update</th>
                            <th class="py-3 px-4 font-medium text-sm">Status</th>
                            <th class="py-3 px-4 font-medium text-sm">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="text-gray-700">
                        @foreach ($commodities as $c)
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
                                <td class="py-2 px-4">{{ $c->unit->name }}</td>

                                <td class="py-2 px-4">
                                    {{ $c->updated_at ? $c->updated_at->format('d F Y') : '-' }}
                                </td>

                                @php
                                    $pivot = $c->commodityMarkets->firstWhere('market_id', auth()->user()->market_id);
                                @endphp

                                <td class="py-2 px-4">
                                    <span
                                        class="px-3 py-1 rounded-lg text-white text-xs
                                        {{ $pivot && $pivot->status === 'aktif' ? 'bg-green-500' : 'bg-red-500' }}">
                                        {{ $pivot ? ($pivot->status === 'aktif' ? 'Aktif' : 'Tidak Aktif') : '-' }}
                                    </span>
                                </td>
                                <td class="py-2 px-4">
                                    @if ($pivot)
                                        <button onclick="openStatusModal({{ $pivot->id }}, '{{ $pivot->status }}')"
                                            class="text-blue-600 hover:underline">
                                            Edit
                                        </button>
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
    </div>

    <!-- Modal Background -->
    <div id="statusModal" class="fixed inset-0 bg-black/40 hidden justify-center items-center z-50">

        <!-- Modal Box -->
        <div class="bg-white w-96 rounded-lg shadow-lg p-6">
            <h2 class="text-lg font-bold mb-4 text-gray-800">Ubah Status Komoditas</h2>

            <form method="POST" id="statusForm">
                @csrf
                <input type="hidden" id="commodityId" name="commodityId">

                <label class="block mb-2 text-sm font-medium">Status Barang</label>

                <select id="statusSelect"
                    class="border border-gray-300 rounded-lg p-2 w-full focus:ring-blue-500 focus:border-blue-500">
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Tidak aktif</option>
                </select>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeStatusModal()"
                        class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 text-sm">
                        Batal
                    </button>

                    <button type="submit" class="px-4 py-2 bg-secondary text-white rounded-lg hover:opacity-90 text-sm">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openStatusModal(id, currentStatus) {
            document.getElementById('commodityId').value = id;
            document.getElementById('statusSelect').value = currentStatus;

            const modal = document.getElementById('statusModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeStatusModal() {
            const modal = document.getElementById('statusModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Submit status update
        document.getElementById('statusForm').addEventListener('submit', function(e) {
            e.preventDefault();

            let id = document.getElementById('commodityId').value;
            let status = document.getElementById('statusSelect').value;

            let formData = new FormData();
            formData.append("status", status);
            formData.append("_token", "{{ csrf_token() }}");

            fetch(`/admin/manajemen/${id}/status`, {
                    method: "POST",
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        closeStatusModal();

                        Swal.fire({
                            title: "Berhasil!",
                            text: "data berhasil diubah",
                            icon: "success",
                            confirmButtonText: "OK"
                        });

                        setTimeout(() => location.reload(), 1400);
                    }
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Gagal mengirim data ke server.'
                    });
                });
        });
    </script>

@endsection
