@extends('layouts.admin')

@section('title', 'Home')

@section('content')
    <div class="mt-7 mx-15 mb-10">
        <div class="grid grid-cols-3 gap-6">
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
                    <h3 class="text-2xl font-bold">{{ \App\Models\User::where('role', 'admin')->count() }}</h3>
                    <p class="text-xs font-light">Petugas Pasar</p>
                </div>
            </div>
            <div class="flex items-center gap-10 bg-white pl-10 py-7 rounded-lg">
                <span class="p-3 bg-secondary rounded-full">
                    <i data-lucide="weight" class="text-white"></i>
                </span>
                <div class="space-y-2">
                    <h3 class="text-2xl font-bold">134</h3>
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
            <div class="col-span-2 row-span-2 flex flex-col gap-6 bg-white pl-10 py-7 pr-10 rounded-lg shadow">
                <h2 class="text-lg font-bold text-gray-800">
                    Tabel Harga Terbaru
                </h2>

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
                                $pivot = $item->commodityMarkets->first();
                                $today = $pivot->prices->where('date', now()->toDateString())->first();
                                $yesterday = $pivot->prices->where('date', now()->subDay()->toDateString())->first();
                                $change = $today && $yesterday ? $today->price - $yesterday->price : 0;
                            @endphp

                            <tr class="border-b text-sm">
                                <td class="py-2 px-4">{{ $loop->iteration }}</td>
                                <td class="py-2 px-4">{{ $item->name }}</td>
                                <td class="py-2 px-4">{{ $yesterday->price ?? '-' }}</td>
                                <td class="py-2 px-4">{{ $today->price ?? '-' }}</td>
                                <td
                                    class="py-2 px-4 {{ $change > 0 ? 'text-red-500' : ($change < 0 ? 'text-green-500' : '') }}">
                                    {{ $change > 0 ? '+' : '' }}{{ $change }}
                                </td>
                                <td class="py-2 px-4">{{ $item->unit->name_unit ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-10 text-gray-400">
                                    Belum ada harga terbaru hari ini
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="bg-white px-10 pb-10 pt-3 rounded-lg max-h-80 overflow-y-auto">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Komoditas Belum Update Hari Ini</h2>

                @forelse ($belumUpdate as $item)
                    <div class="py-2 border-b">
                        <p class="font-semibold">{{ $item->name }}</p>
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
@endsection
