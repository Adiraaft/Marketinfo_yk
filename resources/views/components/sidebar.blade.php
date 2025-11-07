<div class="bg-primary pt-8 px-9 gap-14 flex flex-col items-center">
    <img src="{{ asset('images/logo.png') }}" class="w-14" alt="logo">
    <div class="space-y-3">
        <div>
            <a href="{{ route('dashboard') }}"
                class="flex gap-2 py-3 px-7 rounded-lg transition-all {{ request()->routeIs('dashboard') ? 'bg-white text-secondary' : 'text-white hover:text-secondary hover:bg-white' }}">
                <i data-lucide="layout-dashboard"></i>
                <p class="font-bold text-lg ">Dashboard</p>
            </a>
        </div>
        <div>
            <a href="{{ route('petugas') }}"
                class="flex gap-2 py-3 px-7 rounded-lg transition-all {{ request()->routeIs('petugas') ? 'bg-white text-secondary' : 'text-white hover:text-secondary hover:bg-white' }}">
                <i data-lucide="user-round-pen"></i>
                <p class="font-bold text-lg">Petugas</p>
            </a>
        </div>
        <div>
            <a href="{{ route('market') }}"
                class="flex gap-2 py-3 px-7 rounded-lg transition-all {{ request()->routeIs('market') ? 'bg-white text-secondary' : 'text-white hover:text-secondary hover:bg-white' }}">
                <i data-lucide="store"></i>
                <p class="font-bold text-lg">Pasar</p>
            </a>
        </div>
        <div>
            <a href="{{ route('komoditas') }}"
                class="flex gap-2 py-3 px-7 rounded-lg transition-all {{ request()->routeIs('komoditas') ? 'bg-white text-secondary' : 'text-white hover:text-secondary hover:bg-white' }}">
                <i data-lucide="shopping-bag"></i>
                <p class="font-bold text-lg">Komoditas</p>
            </a>
        </div>
        <div>
            <a href="{{ route('laporan') }}"
                class="flex gap-2 py-3 px-7 rounded-lg transition-all {{ request()->routeIs('laporan') ? 'bg-white text-secondary' : 'text-white hover:text-secondary hover:bg-white' }}">
                <i data-lucide="file-chart-line"></i>
                <p class="font-bold text-lg">Laporan</p>
            </a>
        </div>
        <div>
            <a href="{{ route('setting') }}"
                class="flex gap-2 py-3 px-7 rounded-lg transition-all {{ request()->routeIs('setting') ? 'bg-white text-secondary' : 'text-white hover:text-secondary hover:bg-white' }}">
                <i data-lucide="wrench"></i>
                <p class="font-bold text-lg">Setting</p>
            </a>
        </div>
    </div>
</div>
