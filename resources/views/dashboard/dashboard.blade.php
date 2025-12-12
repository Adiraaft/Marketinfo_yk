@extends('layouts.admin')

@section('title', 'Dashboard')

@section('navbar')
    <x-navbar-dashboard />

@endsection

@section('content')
    <div class="mt-7 mx-15 mb-10">
        <div class="grid grid-cols-3 gap-6">
            <div class="flex items-center gap-10 bg-white pl-10 py-7 rounded-lg shadow-sm">
                <span class="p-3 bg-secondary rounded-full">
                    <i data-lucide="map-pinned" class="text-white"></i>
                </span>
                <div class="space-y-2">
                    <h3 class="text-2xl font-bold">{{ $totalPasar }}</h3>
                    <p class="text-xs font-light">Pasar Aktif</p>
                </div>
            </div>
            <div class="flex items-center gap-10 bg-white pl-10 py-7 rounded-lg shadow-sm">
                <span class="p-3 bg-secondary rounded-full">
                    <i data-lucide="users-round" class="text-white"></i>
                </span>
                <div class="space-y-2">
                    <h3 class="text-2xl font-bold">{{ $totalPetugas }}</h3>
                    <p class="text-xs font-light">Petugas Aktif</p>
                </div>
            </div>
            <div class="flex items-center gap-10 bg-white pl-10 py-7 rounded-lg shadow-sm">
                <span class="p-3 bg-secondary rounded-full">
                    <i data-lucide="weight" class="text-white"></i>
                </span>
                <div class="space-y-2">
                    <h3 class="text-2xl font-bold">{{ $totalKomoditas }}</h3>
                    <p class="text-xs font-light">Komoditas Aktif</p>
                </div>
            </div>
            <div class="bg-white px-10 pb-10 pt-3 rounded-lg shadow-sm">
                <p class="text-sm font-bold text-center">Tanggalan</p>
                <div id="date-calendar" class="max-w-md mx-auto mt-4 bg-white rounded-2xl p-6">
                    <div class="flex justify-between items-center mb-4">
                        <button id="prevMonth" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">←</button>
                        <h2 id="monthYear" class="text-xl font-bold"></h2>
                        <button id="nextMonth" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">→</button>
                    </div>

                    <div class="grid grid-cols-7 text-center font-semibold pb-2 mb-2">
                        <div>Min</div>
                        <div>Sen</div>
                        <div>Sel</div>
                        <div>Rab</div>
                        <div>Kam</div>
                        <div>Jum</div>
                        <div>Sab</div>
                    </div>

                    <div id="calendarGrid" class="grid grid-cols-7 text-center gap-2"></div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm col-span-2">
                <h3 class="text-xl font-semibold text-gray-700 mb-4">
                    Grafik Harga Komoditas
                </h3>

                <div class="flex items-center gap-4 mb-6">
                    <!-- Pilihan Komoditas -->
                    <div>
                        <label class="text-sm font-medium text-gray-600">Komoditas : </label>
                        <select id="selectKomoditas" class="border rounded-lg p-2 text-sm">
                            @foreach ($commodity as $c)
                                <option value="{{ $c->id_commodity }}">{{ $c->name_commodity }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Pilihan Waktu -->
                    <div>
                        <label class="text-sm font-medium text-gray-600">Periode : </label>
                        <select id="selectWaktu" class="border rounded-lg p-2 text-sm">
                            <option value="7">7 Hari</option>
                            <option value="30">30 Hari</option>
                            <option value="365">1 Tahun</option>
                        </select>
                    </div>

                    <button id="btnTampilkan" class="px-5 py-2 bg-secondary text-white rounded-lg shadow">
                        Tampilkan
                    </button>
                </div>

                <div class="col-span-2 flex items-center gap-10 pl-10 py-7">
                    <div id="chartHarga" class="w-full"></div>
                </div>
            </div>

            <div class="col-span-3 grid grid-cols-3 gap-6">
                <!-- CARD 1: MANAJEMEN PASAR -->
                <a href='{{ route('superadmin.market') }}'
                    class="flex flex-col justify-center items-center py-16 gap-2 text-gray-400 bg-white rounded-lg border border-gray-200 hover:bg-gray-50 hover:text-secondary transition cursor-pointer shadow-sm">
                    <i data-lucide="map" class="h-10 w-10"></i>
                    <p class="font-bold text-gray-600 text-lg">Manajemen Pasar</p>
                    <p class="text-xs text-gray-400">Kelola daftar dan status pasar</p>
                </a>

                <!-- CARD 2: MANAJEMEN KOMODITAS -->
                <a href='{{ route('superadmin.komoditas') }}'
                    class="flex flex-col justify-center items-center py-16 gap-2 text-gray-400 bg-white rounded-lg border border-gray-200 hover:bg-gray-50 hover:text-secondary transition cursor-pointer shadow-sm">
                    <i data-lucide="package" class="h-10 w-10"></i>
                    <p class="font-bold text-gray-600 text-lg">Manajemen Komoditas</p>
                    <p class="text-xs text-gray-400">Tambah & kelola komoditas aktif</p>
                </a>

                <!-- CARD 3: LAPORAN HARGA -->
                <a href='{{ route('superadmin.laporan') }}'
                    class="flex flex-col justify-center items-center py-16 gap-2 text-gray-400 bg-white rounded-lg border border-gray-200 hover:bg-gray-50 hover:text-secondary transition cursor-pointer shadow-sm">
                    <i data-lucide="bar-chart-3" class="h-10 w-10"></i>
                    <p class="font-bold text-gray-600 text-lg">Laporan Harga</p>
                    <p class="text-xs text-gray-400">Lihat laporan bulanan</p>
                </a>

            </div>
        </div>
    </div>

    <!-- SweetAlert Success (optional) -->
    @if (session('success'))
        <script type="module">
            Swal.fire({
                title: "Berhasil!",
                text: "{{ session('success') }}",
                icon: "success",
                confirmButtonText: "Ok",
            });
        </script>
    @endif

    <script>
        const monthYear = document.getElementById("monthYear");
        const calendarGrid = document.getElementById("calendarGrid");
        const prevBtn = document.getElementById("prevMonth");
        const nextBtn = document.getElementById("nextMonth");

        const monthNames = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];

        let currentDate = new Date();

        function renderCalendar(date) {
            calendarGrid.innerHTML = "";

            const year = date.getFullYear();
            const month = date.getMonth();

            monthYear.textContent = `${monthNames[month]} ${year}`;

            const firstDay = new Date(year, month, 1).getDay();
            const totalDays = new Date(year, month + 1, 0).getDate();

            // Buat slot kosong sebelum tanggal 1
            for (let i = 0; i < firstDay; i++) {
                const empty = document.createElement("div");
                calendarGrid.appendChild(empty);
            }

            // Isi tanggal
            for (let i = 1; i <= totalDays; i++) {
                const day = document.createElement("div");
                day.textContent = i;
                day.className =
                    "p-2 rounded-lg cursor-pointer hover:bg-blue-100 " +
                    (i === new Date().getDate() && month === new Date().getMonth() && year === new Date().getFullYear() ?
                        "bg-secondary text-white font-bold" :
                        "");
                calendarGrid.appendChild(day);
            }
        }

        prevBtn.addEventListener("click", () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar(currentDate);
        });

        nextBtn.addEventListener("click", () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar(currentDate);
        });

        renderCalendar(currentDate);
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            window.chartHarga = new ApexCharts(document.querySelector("#chartHarga"), {
                chart: {
                    type: 'area',
                    height: 320,
                    toolbar: {
                        show: false
                    }
                },
                series: [{
                    name: "Harga",
                    data: []
                }],
                xaxis: {
                    categories: []
                },

                yaxis: {
                    labels: {
                        formatter: function(val) {
                            return val.toLocaleString("id-ID"); // ← memberi format 12.000
                        }
                    }
                },

                tooltip: {
                    y: {
                        formatter: function(val) {
                            return "Rp " + val.toLocaleString("id-ID");
                        }
                    }
                }
            });

            chartHarga.render();

            document.getElementById("btnTampilkan").addEventListener("click", function() {

                const komoditas = document.getElementById("selectKomoditas").value;
                const periode = document.getElementById("selectWaktu").value;

                // Hitung tanggal
                const endDate = new Date();
                const startDate = new Date();
                startDate.setDate(endDate.getDate() - periode);

                const start = startDate.toISOString().split("T")[0];
                const end = endDate.toISOString().split("T")[0];

                fetch(`/superadmin/dashboard/data-harga?komoditas=${komoditas}&start=${start}&end=${end}`)
                    .then(res => res.json())
                    .then(res => {

                        const labels = res.data.map(i => i.label);
                        const values = res.data.map(i => i.harga);

                        chartHarga.updateOptions({
                            xaxis: {
                                categories: labels
                            }
                        });

                        chartHarga.updateSeries([{
                            name: "Harga",
                            data: values
                        }]);
                    })
                    .catch(err => console.log(err));

            });

        });
    </script>

@endsection
