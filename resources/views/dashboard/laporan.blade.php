@extends('layouts.admin')

@section('title', 'Dashboard Laporan')

@section('content')

    <div class="my-7 px-15">
        <h3 class="font-bold text-2xl text-secondary">Laporan Harga Komoditas</h3>
        <h2 class="text-secondary mt-2">Silakan pilih komoditas, pasar, dan periode waktu untuk melihat laporan.</h2>
        <div class="flex gap-4 mt-4">
            <div class="text-sm">
                <label for="kategori" class="block mb-1 text-gray-700">Pilih Kategori</label>
                <select id="kategori" name="kategori"
                    class="bg-white border border-gray-300 rounded-md p-1 w-40 text-xs focus:ring-blue-400 focus:border-blue-400">
                    <option value="">Pilih Kategori</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id_category }}">{{ $cat->name_category }}</option>
                    @endforeach
                </select>
            </div>

            <div class="text-sm">
                <label for="komoditas" class="block mb-1 text-gray-700">Pilih Komoditas</label>
                <select id="komoditas" name="komoditas"
                    class="bg-white border border-gray-300 rounded-md p-1 w-40 text-xs focus:ring-blue-400 focus:border-blue-400">
                    <option value="">Pilih kategori dulu</option>
                </select>
            </div>

            <div class="text-sm">
                <label for="date" class="block mb-1 text-gray-700">Pilih Tanggal</label>
                <select id="date" name="date"
                    class="bg-white border border-gray-300 rounded-md p-1 w-40 text-xs focus:ring-blue-400 focus:border-blue-400">
                    <option value="">Pilih Tanggal</option>
                    <option value="today">Hari Ini</option>
                    <option value="7days">7 Hari Terakhir</option>
                    <option value="30days">30 Hari Terakhir</option>
                    <option value="1year">1 Tahun Terakhir</option>
                    <option value="custom">Custom</option>
                </select>
            </div>

            <!-- Input Custom Date (disembunyikan dulu) -->
            <div id="customDateWrapper" class="text-sm hidden">
                <div class="flex gap-2">
                    <div>
                        <label class="block mb-1 text-gray-700">Pilih Rentang Tanggal</label>
                        <input type="date" id="start_date" name="start_date"
                            class="bg-white border border-gray-300 rounded-md p-1 w-40 text-xs focus:ring-blue-400 focus:border-blue-400">
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700">Sampai Dengan</label>
                        <input type="date" id="end_date" name="end_date"
                            class="bg-white border border-gray-300 rounded-md p-1 w-40 text-xs focus:ring-blue-400 focus:border-blue-400">
                    </div>
                </div>
            </div>

            <div class="text-sm">
                <label for="market" class="block mb-1 text-gray-700">Pilih Pasar</label>
                <select id="market" name="market"
                    class="bg-white border border-gray-300 rounded-md p-1 w-40 text-xs focus:ring-blue-400 focus:border-blue-400">
                    <option value="all">Semua pasar</option>
                    @foreach ($markets as $cat)
                        <option value="{{ $cat->id_market }}">{{ $cat->name_market }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex w-full gap-2 items-end">
                <button id="btnShow" class="py-1.5 px-3 rounded-md bg-secondary cursor-pointer">
                    <p class="text-white text-xs font-medium">Tampilkan</p>
                </button>
            </div>
            <div class="flex w-full gap-2 items-end justify-end">
                <a id="btnExportExcel" href="{{ url()->full() . '&export=true&type=excel' }}">
                    <button class="py-1.5 px-3 rounded-md bg-green-500 cursor-pointer">
                        <p class="text-white text-xs font-medium">Export Excel</p>
                    </button>
                </a>

                <a id="btnExportPDF" href="{{ route('superadmin.laporan.export.pdf', request()->query()) }}">
                    <button class="py-1.5 px-3 rounded-md bg-red-500 cursor-pointer">
                        <p class="text-white text-xs font-medium">Export PDF</p>
                    </button>
                </a>
            </div>
        </div>


        <div class="mt-6 bg-white rounded-lg shadow-md overflow-hidden">
            <div class="max-h-[550px] overflow-y-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="text-gray-400 border-b border-gray-200">
                        <tr>
                            <th class="py-3 px-4 font-medium text-sm">Tanggal</th>
                            <th class="py-3 px-4 font-medium text-sm">Nama Komoditas</th>
                            <th class="py-3 px-4 font-medium text-sm">Pasar</th>
                            <th class="py-3 px-4 font-medium text-sm">Perubahan (±%)</th>
                            <th class="py-3 px-4 font-medium text-sm">Harga</th>
                            <th class="py-3 px-4 font-medium text-sm">Update Oleh</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        <tr>
                            <td colspan="6" class="py-6 text-center text-gray-400">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <i data-lucide="scroll-text"></i>
                                    <p>Pilih filter terlebih dahulu untuk menampilkan data</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('kategori').addEventListener('change', function() {
            const categoryId = this.value;
            const komoditasSelect = document.getElementById('komoditas');

            console.log("Selected Category:", categoryId);

            komoditasSelect.innerHTML = '<option value="">Loading...</option>';

            if (!categoryId) {
                komoditasSelect.innerHTML = '<option value="">Semua Komoditas</option>';
                return;
            }

            // gunakan url blade agar path benar meskipun app berjalan di subfolder
            const url = "{{ url('superadmin/laporan/by-category') }}/" + categoryId;

            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log("API Response:", data);
                    komoditasSelect.innerHTML = '<option value="">Pilih Komoditas</option>';

                    if (!data || data.length === 0) {
                        komoditasSelect.innerHTML = '<option value="">Tidak ada komoditas</option>';
                        return;
                    }

                    data.forEach(item => {
                        komoditasSelect.innerHTML +=
                            `<option value="${item.id}">${item.name_commodity}</option>`;
                    });
                })
                .catch(err => {
                    console.error('Fetch error:', err);
                    komoditasSelect.innerHTML = '<option value="">Gagal memuat komoditas</option>';
                });
        });
    </script>

    <script>
        const dateSelect = document.getElementById('date');
        const customDateWrapper = document.getElementById('customDateWrapper');

        dateSelect.addEventListener('change', function() {
            if (this.value === 'custom') {
                customDateWrapper.classList.remove('hidden');
            } else {
                customDateWrapper.classList.add('hidden');
                document.getElementById('start_date').value = "";
                document.getElementById('end_date').value = "";
            }
        });
    </script>

    <script>
        document.getElementById('btnShow').addEventListener('click', function() {

            const category = document.getElementById('kategori').value;
            const komoditas = document.getElementById('komoditas').value;
            let market = document.getElementById('market').value;
            const date = document.getElementById('date').value;
            const start = document.getElementById('start_date').value;
            const end = document.getElementById('end_date').value;

            if (!market) {
                market = "all";
            }


            // ============================
            // VALIDASI INPUT   
            // ============================
            document.querySelectorAll(".error-msg").forEach(e => e.remove()); // hapus error lama
            let valid = true;

            function showError(id, message) {
                let el = document.getElementById(id);
                let wrapper = el.parentElement;

                // pastikan wrapper posisi relative
                wrapper.style.position = "relative";

                let errorArea = wrapper.querySelector(".error-area");

                if (!errorArea) {
                    errorArea = document.createElement("div");
                    errorArea.className = "error-area";
                    errorArea.style.position = "absolute";
                    errorArea.style.left = "0";
                    errorArea.style.bottom = "-16px"; // muncul di bawah input tapi TIDAK mendorong layout
                    errorArea.style.fontSize = "12px";
                    errorArea.style.color = "red";
                    wrapper.appendChild(errorArea);
                }

                errorArea.textContent = message;
            }


            if (!category) {
                showError("kategori", "Kategori harus dipilih");
                valid = false;
            }

            if (!komoditas) {
                showError("komoditas", "Komoditas harus dipilih");
                valid = false;
            }

            if (!date) {
                showError("date", "Tanggal harus dipilih");
                valid = false;
            }

            if (date === "custom") {
                if (!start || !end) {
                    showError("start_date", "Tanggal mulai & akhir harus diisi");
                    valid = false;
                }
            }

            if (!valid) return;


            // Update URL agar parameter filter masuk ke URL (untuk export)
            const params = new URLSearchParams({
                category,
                komoditas,
                market,
                date,
                start,
                end
            });
            history.pushState({}, "", "?" + params.toString());

            // Update URL Export Excel & PDF
            document.getElementById("btnExportExcel").href =
                `{{ url('superadmin/laporan/export/excel') }}?category=${category}&komoditas=${komoditas}&market=${market}&date=${date}&start=${start}&end=${end}`;

            document.getElementById("btnExportPDF").href =
                `{{ url('superadmin/laporan/export/pdf') }}?category=${category}&komoditas=${komoditas}&market=${market}&date=${date}&start=${start}&end=${end}`;


            // URL backend
            const url =
                `{{ url('superadmin/laporan/filter') }}?category=${category}&komoditas=${komoditas}&market=${market}&date=${date}&start=${start}&end=${end}`;


            fetch(url)
                .then(res => res.json())
                .then(data => {
                    const tbody = document.querySelector("tbody");
                    tbody.innerHTML = "";

                    if (data.length === 0) {
                        tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="py-3 text-center text-gray-500">Tidak ada data ditemukan</td>
                    </tr>`;
                        return;
                    }

                    data.forEach(row => {
                        tbody.innerHTML += `
                    <tr class="border-t border-gray-200 hover:bg-gray-50 text-sm font-medium">
                        <td class="py-2 px-4">${row.tanggal}</td>
                        <td class="py-2 px-4">${row.nama_commodity}</td>
                        <td class="py-2 px-4">${row.nama_pasar ?? '-'}</td>
                        <td class="py-2 px-4 ${row.perubahan > 0 ? 'text-green-600' : (row.perubahan < 0 ? 'text-red-600' : 'text-gray-600')}">
                            ${row.perubahan}%
                        </td>
                        <td>
                        ${row.harga_rata !== null ? 'Rp ' + Number(row.harga_rata).toLocaleString("id-ID") : '-'}
                        </td>
                        <td class="py-2 px-4">${row.admin}</td>
                    </tr>`;
                    });
                })
                .catch(err => {
                    console.error(err);
                    alert("Gagal memuat data laporan!");
                });
        });
    </script>

    <script>
        // Hapus error saat user memilih dropdown atau mengubah input
        ["kategori", "komoditas", "date", "start_date", "end_date"].forEach(id => {
            let el = document.getElementById(id);
            el.addEventListener("change", () => {
                let wrapper = el.parentElement;
                let err = wrapper.querySelector(".error-area");
                if (err) err.remove();
            });
        });
    </script>


@endsection
