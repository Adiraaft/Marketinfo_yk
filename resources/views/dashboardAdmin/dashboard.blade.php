@extends('layouts.admin')

@section('title', 'Dashboard Petugas Pasar')

@section('content')
    <div class="mt-7 mx-15 mb-10">
        <div class="grid grid-cols-3 auto-rows-min gap-6">
            <div class="flex items-center gap-10 bg-white pl-10 py-7 rounded-lg">
                <span class="p-3 bg-secondary rounded-full">
                    <i data-lucide="map-pinned" class="text-white"></i>
                </span>

                <div class="space-y-2">
                    <h3 class="text-2xl font-bold">
                        {{ auth()->user()->market->name_market ?? 'Tidak ada pasar' }}
                    </h3>
                </div>
            </div>

            <div class="flex items-center gap-10 bg-white pl-10 py-7 rounded-lg">
                <span class="p-3 bg-secondary rounded-full">
                    <i data-lucide="users-round" class="text-white"></i>
                </span>
                <div class="space-y-2">
                    <h3 class="text-2xl font-bold">
                        {{ $adminCount }}
                    </h3>
                    <p class="text-xs font-light">Petugas Pasar</p>
                </div>
            </div>
            <div class="flex items-center gap-10 bg-white pl-10 py-7 rounded-lg">
                <span class="p-3 bg-secondary rounded-full">
                    <i data-lucide="weight" class="text-white"></i>
                </span>
                <div class="space-y-2">
                    <h3 class="text-2xl font-bold">
                        {{ $commodityCount }}
                    </h3>
                    <p class="text-xs font-light">Komoditas Aktif</p>
                </div>
            </div>
            <div class="bg-white px-10 pb-10 pt-3 rounded-lg">
                <p class="text-lg font-bold text-center">Kalender</p>
                <div id="date-calendar" class="max-w-md mx-auto mt-4 bg-white rounded-2xl p-6">
                    <div class="flex justify-between items-center mb-4">
                        <button id="prevMonth" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">←</button>
                        <h2 id="monthYear" class="text-xl font-bold"></h2>
                        <button id="nextMonth" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">→</button>
                    </div>

                    <div class="grid grid-cols-7 text-center font-semibold pb-2 mb-2 text-xs">
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


            <!-- Tabel Harga Terbaru -->
            <div
                class="col-span-2 row-span-2 flex flex-col gap-6 bg-white pl-10 py-7 pr-10 rounded-lg shadow overflow-y-auto max-h-[780px]">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-bold text-gray-800">
                        Tabel Harga Terbaru
                    </h2>
                    <div class="text-sm text-gray-500">
                        📅 {{ \Carbon\Carbon::parse($selectedDate)->isoFormat('D MMMM YYYY') }}
                    </div>
                </div>

                <table class="w-full text-left border-collapse">
                    <thead class="text-gray-400 border-b border-gray-200">
                        <tr>
                            <th class="py-3 px-4 font-medium text-sm">No</th>
                            <th class="py-3 px-4 font-medium text-sm">Nama Barang</th>
                            <th class="py-3 px-4 font-medium text-sm">Harga Kemarin</th>
                            <th class="py-3 px-4 font-medium text-sm">Harga Hari Ini</th>
                            <th class="py-3 px-4 font-medium text-sm">Perubahan</th>
                            <th class="py-3 px-4 font-medium text-sm">Satuan</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($latestPrices as $item)
                            @php
                                $commodity = $item['commodity'];
                                $todayPrice = $item['today_price'];
                                $yesterdayPrice = $item['yesterday_price'];
                                $change = $item['change'];
                            @endphp
                            <tr class="border-t border-gray-200 hover:bg-gray-50">
                                <td class="py-3 px-4">{{ $loop->iteration }}</td>
                                <td class="py-3 px-4">{{ $commodity->name_commodity }}</td>
                                <td class="py-3 px-4">
                                    {{ $yesterdayPrice ? 'Rp ' . number_format($yesterdayPrice, 0, ',', '.') : '-' }}
                                </td>
                                <td class="py-3 px-4">
                                    Rp {{ number_format($todayPrice, 0, ',', '.') }}
                                </td>
                                <td
                                    class="py-3 px-4 {{ $change > 0 ? 'text-red-500' : ($change < 0 ? 'text-green-500' : '') }}">
                                    {{ $change > 0 ? '+' : '' }}{{ $change ? 'Rp ' . number_format($change, 0, ',', '.') : '-' }}
                                </td>
                                <td class="py-3 px-4">{{ $commodity->unit->name_unit ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-gray-400">
                                    Belum ada komoditas yang diupdate pada tanggal ini
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Komoditas Belum Update -->
            <div class="bg-white px-10 pb-10 pt-3 rounded-lg max-h-80 overflow-y-auto">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Komoditas Belum Update Hari Ini</h2>

                @forelse ($belumUpdate as $item)
                    <div class="py-2 border-b">
                        <p class="font-semibold">{{ $item['name'] }}</p>
                        <p class="text-xs text-gray-500">Belum mengisi harga hari ini</p>
                    </div>
                @empty
                    <p class="text-gray-400 text-sm">Semua komoditas sudah diupdate hari ini 🎉</p>
                @endforelse
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

        // Ambil tanggal yang dipilih dari URL atau gunakan hari ini
        const urlParams = new URLSearchParams(window.location.search);
        const selectedDateFromUrl = urlParams.get('tanggal');
        let currentDate = selectedDateFromUrl ? new Date(selectedDateFromUrl) : new Date();

        function renderCalendar(date) {
            calendarGrid.innerHTML = "";

            const year = date.getFullYear();
            const month = date.getMonth();
            const today = new Date();

            // Ambil tanggal yang sedang dipilih dari URL
            const selectedDate = selectedDateFromUrl ? new Date(selectedDateFromUrl) : today;

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

                // Check apakah ini tanggal yang sedang dipilih
                const isSelected = i === selectedDate.getDate() &&
                    month === selectedDate.getMonth() &&
                    year === selectedDate.getFullYear();

                // Check apakah ini hari ini
                const isToday = i === today.getDate() &&
                    month === today.getMonth() &&
                    year === today.getFullYear();

                day.className = "p-2 rounded-lg cursor-pointer hover:bg-blue-100 transition-colors text-sm " +
                    (isSelected ? "bg-secondary text-white font-bold" :
                        isToday ? "bg-blue-200 text-blue-800 font-semibold" : "");

                // Event listener untuk klik tanggal
                day.addEventListener("click", () => {
                    const clickedDate =
                        `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;

                    // Redirect ke URL dengan parameter tanggal
                    window.location.href = `{{ route('admin.dashboard') }}?tanggal=${clickedDate}`;
                });

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
@endsection
