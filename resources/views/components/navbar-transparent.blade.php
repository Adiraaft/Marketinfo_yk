<header class="absolute top-0 left-0 w-full z-50">
    <div class="flex items-center mx-15 my-4 justify-between">
        <img src="{{ asset('images/logo.png') }}" alt="logo" class="h-15 w-auto">
        <nav>
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
    </div>
</header>
