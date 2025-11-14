@extends('layouts.admin')

@section('title', 'Home')

@section('content')
    <div class="mt-7 px-15">
        <div class="flex gap-4 mt-4 justify-between items-center">
            <div>
                <h3 class="font-bold text-2xl text-secondary">Setting</h3>
            </div>

        </div>

        <!-- Wrapper utama -->
        <div class="w-full bg-white rounded-lg shadow-md mt-6 overflow-hidden">
            <!-- Tab Header -->
            <div class="flex bg-gray-200 border-b border-gray-300 text-sm font-medium text-gray-600 rounded-t-lg">
                <a href="{{ route('superadmin.setting') }}"
                    class="px-6 py-3 border-b-2 transition-all duration-200 
                    hover:border-primary hover:text-primary
                    {{ request()->routeIs('superadmin.setting') ? 'border-primary text-primary font-semibold' : 'border-transparent' }}">
                    General
                </a>

                <a href="{{ route('superadmin.kategori') }}"
                    class="px-6 py-3 border-b-2 transition-all duration-200 
                    hover:border-primary hover:text-primary
                    {{ request()->routeIs('superadmin.kategori') || request()->routeIs('superadmin.satuan') ? 'border-primary text-primary font-semibold' : 'border-transparent' }}">
                    Manajemen
                </a>

                <a href="{{ route('superadmin.account') }}"
                    class="px-6 py-3 border-b-2 transition-all duration-200 
                    hover:border-primary hover:text-primary
                    {{ request()->routeIs('superadmin.account') ? 'border-primary text-primary font-semibold' : 'border-transparent' }}">
                    Account
                </a>
            </div>

            <!-- Tab Content -->
            <div class="p-6 text-sm bg-white rounded-b-lg">
                <p class="text-secondary text-xl font-bold">Informasi Akun</p>
                <p class="text-xs font-medium text-gray-300">
                    Perbaharui Informasi Pribadi Anda
                </p>
                <form action="{{ route('superadmin.account.update') }}" method="POST" class="space-y-4 mt-4">
                    @csrf
                    @method('PUT')
                    <div class="flex gap-4">
                        <div class="text-left">
                            <label class="block text-sm font-medium text-gray-500 mb-1">Nama Depan</label>
                            <input type="text" id="first_name" name="first_name" required
                                value="{{ explode(' ', $user->name)[0] ?? '' }}"
                                class="w-57 border text-gray-500 border-gray-300 rounded-xl px-4 py-1 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        </div>
                        <div class="text-left">
                            <label class="block text-sm font-medium text-gray-500 mb-1">Nama Belakang</label>
                            <input type="text" id="last_name" name="last_name" required
                                value="{{ explode(' ', $user->name)[1] ?? '' }}"
                                class="w-57 border text-gray-500 border-gray-300 rounded-xl px-4 py-1 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        </div>
                    </div>
                    <div class="text-left">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Lahir</label>
                        <input type="date" id="date_of_birth" name="date_of_birth" required
                            value="{{ $user->date_of_birth ?? '' }}"
                            class="w-57 border text-gray-500 border-gray-300 rounded-xl px-4 py-1 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                    <div class="text-left">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Alamat Email</label>
                        <input type="email" id="email" name="email" required value="{{ $user->email }}"
                            class="w-57 border text-gray-500 border-gray-300 rounded-xl px-4 py-1 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                    <div class="text-left">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Password (kosongkan jika tidak
                            diubah)</label>
                        <input type="password" name="password"
                            class="w-57 border text-gray-700 border-gray-300 rounded-xl px-4 py-1 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                    <button type="submit" class="mt-6 px-13 py-2 bg-secondary text-white font-bold text-sm rounded-lg">
                        Update
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
