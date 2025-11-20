@php
    $prefix = auth()->user()->role === 'superadmin' ? 'superadmin.' : 'admin.';
@endphp

<div class="bg-primary pt-8 px-9 gap-14 flex flex-col items-center">
    <img src="{{ asset('images/logo.png') }}" class="w-14" alt="logo">
    <div class="space-y-3">
        <div>
            <a href="{{ route($prefix . 'dashboard') }}"
                class="flex gap-2 py-3 px-7 rounded-lg transition-all {{ request()->routeIs('superadmin.dashboard','admin.dashboard') ? 'bg-white text-secondary' : 'text-white hover:text-secondary hover:bg-white' }}">
                <i data-lucide="layout-dashboard"></i>
                <p class="font-bold text-lg ">Dashboard</p>
            </a>
        </div>
        <div>
            <a href="{{ route($prefix . 'komoditas') }}"
                class="flex gap-2 py-3 px-7 rounded-lg transition-all {{ request()->routeIs('superadmin.komoditas','admin.komoditas') ? 'bg-white text-secondary' : 'text-white hover:text-secondary hover:bg-white' }}">
                <i data-lucide="shopping-bag"></i>
                <p class="font-bold text-lg">Komoditas</p>
            </a>
        </div>
        @if (auth()->user()->role === 'admin')
            <div>
                <a href="{{ route('admin.manajemen') }}"
                    class="flex gap-2 py-3 px-7 rounded-lg transition-all {{ request()->routeIs('admin.manajemen') ? 'bg-white text-secondary' : 'text-white hover:text-secondary hover:bg-white' }}">
                    <i data-lucide="settings-2"></i>
                    <p class="font-bold text-lg">Manajemen</p>
                </a>
            </div>
        @endif
        <div>
            <a href="{{ route($prefix . 'laporan') }}"
                class="flex gap-2 py-3 px-7 rounded-lg transition-all {{ request()->routeIs('superadmin.laporan','admin.laporan') ? 'bg-white text-secondary' : 'text-white hover:text-secondary hover:bg-white' }}">
                <i data-lucide="file-chart-line"></i>
                <p class="font-bold text-lg">Laporan</p>
            </a>
        </div>

        @if (auth()->user()->role === 'superadmin')
            <div>
                <a href="{{ route('superadmin.petugas') }}"
                    class="flex gap-2 py-3 px-7 rounded-lg transition-all {{ request()->routeIs('superadmin.petugas', 'superadmin.petugas.create', 'superadmin.petugas.edit') ? 'bg-white text-secondary' : 'text-white hover:text-secondary hover:bg-white' }}">
                    <i data-lucide="user-round-pen"></i>
                    <p class="font-bold text-lg">Petugas</p>
                </a>
            </div>
            <div>
                <a href="{{ route('superadmin.market') }}"
                    class="flex gap-2 py-3 px-7 rounded-lg transition-all {{ request()->routeIs('superadmin.market', 'superadmin.market.create', 'superadmin.market.edit') ? 'bg-white text-secondary' : 'text-white hover:text-secondary hover:bg-white' }}">
                    <i data-lucide="store"></i>
                    <p class="font-bold text-lg">Pasar</p>
                </a>
            </div>
            <div>
                <a href="{{ route('superadmin.berita.index') }}"
                    class="flex gap-2 py-3 px-7 rounded-lg transition-all {{ request()->routeIs('superadmin.berita.index', 'superadmin.berita.create', 'superadmin.berita.edit') ? 'bg-white text-secondary' : 'text-white hover:text-secondary hover:bg-white' }}">
                    <i data-lucide="newspaper"></i>
                    <p class="font-bold text-lg">Berita</p>
                </a>
            </div>
            <div>
                <a href="{{ route('superadmin.setting') }}"
                    class="flex gap-2 py-3 px-7 rounded-lg transition-all {{ request()->routeIs('superadmin.setting', 'superadmin.kategori', 'superadmin.satuan', 'superadmin.account') ? 'bg-white text-secondary' : 'text-white hover:text-secondary hover:bg-white' }}">
                    <i data-lucide="wrench"></i>
                    <p class="font-bold text-lg">Setting</p>
                </a>
            </div>
        @endif
    </div>
</div>
