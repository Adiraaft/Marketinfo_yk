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
                    <tr class="border-t border-gray-200 hover:bg-gray-50 text-sm font-medium">
                        <td class="py-2 px-4">1</td>
                        <!-- Kolom Nama Barang -->
                        <td class="py-2 px-4">
                            <div class="flex items-center gap-3">
                                <!-- Gambar lingkaran kecil -->
                                <img src="{{ asset('images/tomat.png') }}" alt="Cabai Merah"
                                    class="w-8 h-8 rounded-full object-cover border border-gray-300">
                                <span>Cabai Merah</span>
                            </div>
                        </td>
                        <td class="py-2 px-4">Sayuran</td>
                        <td class="py-2 px-4">kg</td>
                        <td class="py-2 px-4">24 Oktober 2025</td>
                        <td class="py-2 px-4">Aktif</td>
                        <td class="gap-1 items-end py-2 px-4">
                            <button onclick="openStatusModal()" class="text-blue-600 hover:underline">Edit</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Background -->
    <div id="statusModal" class="fixed inset-0 bg-black/40 hidden justify-center items-center z-50">

        <!-- Modal Box -->
        <div class="bg-white w-96 rounded-lg shadow-lg p-6">
            <h2 class="text-lg font-bold mb-4 text-gray-800">Ubah Status Komoditas</h2>

            <form id="statusForm">
                <label class="block mb-2 text-sm font-medium">Status Barang</label>

                <select id="statusSelect"
                    class="border border-gray-300 rounded-lg p-2 w-full focus:ring-blue-500 focus:border-blue-500">
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
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
        function openStatusModal() {
            document.getElementById('statusModal').classList.remove('hidden');
            document.getElementById('statusModal').classList.add('flex');
        }

        function closeStatusModal() {
            document.getElementById('statusModal').classList.add('hidden');
            document.getElementById('statusModal').classList.remove('flex');
        }

        // Ketika modal dikirimkan (submit)
        document.getElementById('statusForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const status = document.getElementById('statusSelect').value;

            // TEMPORER (bisa ganti AJAX atau form submit ke server)
            alert("Status berhasil diubah menjadi: " + status);

            closeStatusModal();
        });
    </script>



@endsection
