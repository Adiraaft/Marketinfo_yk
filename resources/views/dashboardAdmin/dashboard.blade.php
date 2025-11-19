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

                <div class="flex items-center text-sm font-semibold text-gray-400">
                    <div class="px-4 w-12">No</div>
                    <div class="px-16 text-center">Nama Barang</div>
                    <div class="px-4 w-36 text-left">Harga Kemarin</div>
                    <div class="px-4 w-36 text-center">Harga Hari Ini</div>
                    <div class="px-4 w-28 text-center">Perubahan</div>
                    <div class="px-4 w-24 text-center">Satuan</div>
                </div>
                <div class="border-b border-gray-200 w-full"></div>

                <div class="w-full flex flex-col items-center justify-center py-40 text-center text-gray-400">
                    <i data-lucide="upload" class="h-8 w-8"></i>
                    <p class="text-gray-400 text-sm">Belum ada harga terbaru</p>
                    <p class="text-gray-300 text-xs">(Silahkan update harga di menu komoditas)</p>
                </div>
            </div>
            <div class="bg-white px-10 pb-10 pt-3 rounded-lg">
                <h2 class="text-lg font-bold text-gray-800">History</h2>
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
