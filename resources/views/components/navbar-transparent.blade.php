<div x-data="{ open: false }" class="bg-transparent absolute top-0 left-0 w-full z-50">
    <div class="flex items-center px-4 md:px-15 py-6 justify-between">
        {{-- Logo --}}
        <img src="{{ asset('images/logo.png') }}" alt="logo" class="h-32 ml-8 lg:h-20 w-auto">

        {{-- Menu --}}
        <nav class="hidden md:block">
            <ul class="flex gap-16 text-white">
                <li>
                    <a href="{{ route('home.index') }}" class="hover:text-[#FB7A29]">Beranda</a>
                </li>
                <li>
                    <a href="{{ route('pasar.pasar') }}" class="hover:text-[#FB7A29]">Pasar</a>
                </li>
                <li>
                    <a href="{{ route('berita.berita') }}" class="hover:text-[#FB7A29]">Berita</a>
                </li>
            </ul>
        </nav>

        {{-- Tombol Hamburger di Mobile --}}
        <button @click="open = !open" class="md:hidden text-white focus:outline-none relative z-50 mr-8">
            <template x-if="!open">
                <i data-lucide="menu" class="w-18 h-18"></i>
            </template>
            <template x-if="open">
                <i data-lucide="x" class="w-8 h-8"></i>
            </template>
        </button>
    </div>

    {{-- Dropdown Menu di Mobile --}}
    <div x-show="open" x-transition 
         class="md:hidden bg-primary text-white border-t border-[#FB7A29] h-full">
        <ul class="flex flex-col px-6 py-3 space-y-3 text-right">
            <li><a href="{{ route('home.index') }}" class="hover:text-[#FB7A29] text-4xl">Beranda</a></li>
            <li><a href="{{ route('pasar.pasar') }}" class="hover:text-[#FB7A29] text-4xl">Pasar</a></li>
            <li><a href="{{ route('berita.berita') }}" class="hover:text-[#FB7A29] text-4xl">Berita</a></li>
        </ul>
    </div>
</div>
