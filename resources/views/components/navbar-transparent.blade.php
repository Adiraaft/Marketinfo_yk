<div x-data="{ open: false }" class="bg-transparent absolute top-0 left-0 w-full z-50">
    <div class="flex items-center px-4 md:px-10 py-6 justify-between">
        {{-- Logo --}}
        <img src="{{ asset('images/logo.png') }}" alt="logo" class="h-12 sm:h-14 lg:h-16 w-auto">

        {{-- Menu --}}
        <nav class="hidden md:block">
            <ul class="flex gap-16 text-white">
                <li>
                    <a href="{{ route('home.index') }}" class="hover:text-[#FB7A29] text-sm">Beranda</a>
                </li>
                <li>
                    <a href="{{ route('pasar.pasar') }}" class="hover:text-[#FB7A29] text-sm">Pasar</a>
                </li>
                <li>
                    <a href="{{ route('berita.index') }}" class="hover:text-[#FB7A29] text-sm">Berita</a>
                </li>
            </ul>
        </nav>

        {{-- Tombol Hamburger di Mobile --}}
        <button @click="open = !open" class="md:hidden text-white focus:outline-none relative z-50 mr-8">
            <template x-if="!open">
                <i data-lucide="menu" class="w-7 h-7"></i>
            </template>
        </button>
    </div>

    <!-- OVERLAY -->
    <div x-show="open" x-transition.opacity @click="open = false" class="fixed inset-0 bg-black/50 md:hidden"></div>

    <!-- MOBILE MENU (½ layar, tinggi penuh) -->
    <div x-show="open" x-transition:enter="transition transform duration-300"
        x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transition transform duration-300" x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed top-0 right-0 h-screen w-1/2 bg-primary md:hidden z-50 flex flex-col">

        <!-- Close Button -->
        <div class="flex items-center justify-between px-5 py-4 border-b border-white/10">
            <!-- Logo kecil -->
            <img src="{{ asset('images/logo.png') }}" alt="logo" class="h-10 w-auto">

            <!-- Close -->
            <button @click="open = false" class="text-white">
                <i data-lucide="x" class="w-7 h-7"></i>
            </button>
        </div>

        <!-- Menu Items -->
        <ul class="flex flex-col gap-4 mt-10 px-6 text-white text-lg">
            <li>
                <a href="{{ route('home.index') }}"
                    class="group flex items-center gap-3 px-4 py-3 rounded-xl
                  transition-all duration-200
                  hover:bg-white/10 hover:translate-x-1">
                    <span class="w-1 h-6 bg-[#FB7A29] rounded-full opacity-0 group-hover:opacity-100"></span>
                    Beranda
                </a>
            </li>

            <li>
                <a href="{{ route('pasar.pasar') }}"
                    class="group flex items-center gap-3 px-4 py-3 rounded-xl
                  transition-all duration-200
                  hover:bg-white/10 hover:translate-x-1">
                    <span class="w-1 h-6 bg-[#FB7A29] rounded-full opacity-0 group-hover:opacity-100"></span>
                    Pasar
                </a>
            </li>

            <li>
                <a href="{{ route('berita.index') }}"
                    class="group flex items-center gap-3 px-4 py-3 rounded-xl
                  transition-all duration-200
                  hover:bg-white/10 hover:translate-x-1">
                    <span class="w-1 h-6 bg-[#FB7A29] rounded-full opacity-0 group-hover:opacity-100"></span>
                    Berita
                </a>
            </li>
        </ul>
    </div>
</div>
