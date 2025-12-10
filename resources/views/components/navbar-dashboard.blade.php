@php
    use Illuminate\Support\Str;
@endphp

<nav class="bg-white/80 backdrop-blur-md flex justify-end items-center px-10 py-5 shadow-md sticky top-0 z-50 gap-8">

    <!-- Notifikasi -->
    <div class="relative">
        <button id="notifIcon" class="relative">
            <i data-lucide="bell" class="w-7 h-7 text-gray-700 hover:text-blue-600 transition"></i>

            <!-- Red Dot Notif -->
            <span class="absolute top-0 right-0 w-3 h-3 bg-red-500 rounded-full"></span>
        </button>

        <!-- Notif Dropdown -->
        <div id="notifModal"
            class="hidden absolute right-0 mt-3 bg-white shadow-xl rounded-lg w-72 p-4 border border-gray-100 animate-fade">
            <h3 class="font-semibold mb-2">Notifikasi</h3>

            <div class="flex items-center gap-3 p-2 hover:bg-gray-50 rounded-lg cursor-pointer">
                <i data-lucide="info" class="w-5 h-5 text-blue-600"></i>
                <p class="text-sm text-gray-600">Belum ada notifikasi.</p>
            </div>
        </div>
    </div>

    <!-- User -->
    <div class="relative">
        <button id="userIcon" class="flex items-center gap-3">
            <!-- Avatar -->
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}"
                class="w-9 h-9 rounded-full shadow-lg" />

            <i data-lucide="chevron-down" class="w-5 h-5 text-gray-600"></i>
        </button>

        <!-- User Dropdown -->
        <div id="userModal"
            class="hidden absolute right-0 mt-3 bg-white shadow-xl rounded-lg w-52 p-4 border border-gray-100 animate-fade">

            <div class="mb-3">
                <h3 class="font-semibold">Hey, {{ Str::title(Auth::user()->name) }}</h3>
                <p class="text-xs text-gray-500">Akses: {{ ucfirst(Auth::user()->role) }}</p>
            </div>

            <ul class="text-sm text-gray-600 flex-col space-y-3">

                <!-- Setting -->
                <a href="{{ auth()->user()->role === 'superadmin'
                    ? route('superadmin.account')
                    : route('admin.account.edit', auth()->user()->id_user) }}"
                    class="cursor-pointer flex items-center gap-2">
                    <li class="hover:text-blue-600 cursor-pointer flex items-center gap-2">
                        <i data-lucide="settings" class="w-5"></i> Setting
                    </li>
                </a>

                <!-- Logout -->
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="flex cursor-pointer items-center gap-2 text-gray-600 hover:text-blue-600 w-full text-left">
                            <i data-lucide="log-out"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

</nav>

<script>
    function confirmLogout() {
        Swal.fire({
            title: 'Yakin ingin logout?',
            text: 'Kamu akan keluar dari dashboard.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, logout!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logoutForm').submit();
            }
        });
    }
</script>
