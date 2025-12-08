@extends('layouts.admin')

@section('title', 'Dashboard')

@section('navbar')
    <x-navbar-dashboard />

@endsection

@section('content')
    <div class="mt-7 mx-15 mb-10">
        <div class="grid grid-cols-3 gap-6">
            <div class="flex items-center gap-10 bg-white pl-10 py-7 rounded-lg">
                <span class="p-3 bg-secondary rounded-full">
                    <i data-lucide="map-pinned" class="text-white"></i>
                </span>
                <div class="space-y-2">
                    <h3 class="text-2xl font-bold">{{ \App\Models\Market::where('status', 'aktif')->count() }}</h3>
                    <p class="text-xs font-light">Pasar Aktif</p>
                </div>
            </div>
            <div class="flex items-center gap-10 bg-white pl-10 py-7 rounded-lg">
                <span class="p-3 bg-secondary rounded-full">
                    <i data-lucide="users-round" class="text-white"></i>
                </span>
                <div class="space-y-2">
                    <h3 class="text-2xl font-bold">{{ \App\Models\User::where('role', 'admin')->count() }}</h3>
                    <p class="text-xs font-light">Petugas Aktif</p>
                </div>
            </div>
            <div class="flex items-center gap-10 bg-white pl-10 py-7 rounded-lg">
                <span class="p-3 bg-secondary rounded-full">
                    <i data-lucide="weight" class="text-white"></i>
                </span>
                <div class="space-y-2">
                    <h3 class="text-2xl font-bold">{{ \App\Models\Commodity::where('status', 'aktif')->count() }}</h3>
                    <p class="text-xs font-light">Komoditas Aktif</p>
                </div>
            </div>
            <div class="bg-white px-10 pb-10 pt-3 rounded-lg">
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
            <div class="col-span-2 flex items-center gap-10 bg-white pl-10 py-7 rounded-lg">

            </div>
            <a href="{{ route('superadmin.berita.index') }}"
                class="col-span-3 flex flex-col justify-center items-center py-32 gap-2 text-gray-300 bg-white rounded-lg border-2 border-dashed border-gray-200 hover:bg-gray-50 hover:text-secondary transition cursor-pointer shadow-sm">
                <i data-lucide="upload" class="h-12 w-12"></i>
                <p class="font-bold text-gray-500">Upload Berita</p>
                <p class="text-xs text-gray-400">Klik untuk mengelola berita</p>
            </a>
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
