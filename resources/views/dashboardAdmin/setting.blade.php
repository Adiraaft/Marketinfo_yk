@extends('layouts.admin')

@section('title', 'Dashboard Setting Petugas')

@section('content')
    <div class="mx-15 mt-6 mb-10">

        <a href="{{ url()->previous() }}" class="text-blue-500 hover:underline mt-3 inline-block">
            ← Kembali
        </a>

        <h3 class="text-2xl font-bold text-secondary my-6">
            Pengaturan Akun Admin
        </h3>

        <div class="w-full bg-white py-6 pl-9 shadow rounded-lg">
            <p class="text-secondary text-xl font-bold">Informasi Akun</p>
            <p class="text-xs font-medium text-gray-300">Perbarui data pribadi Anda.</p>

            @php
                // Pecah nama menjadi first_name & last_name jika user hanya punya "name"
                $split = explode(' ', $petugas->name ?? '');
                $first_name = $split[0] ?? '';
                $last_name = implode(' ', array_slice($split, 1)) ?: '';
            @endphp

            <form id="petugasForm" enctype="multipart/form-data" method="POST"
                action="{{ route('admin.account.update', $petugas->id_user) }}" class="space-y-4 mt-10 relative">

                @csrf
                @method('PUT')

                <div class="flex justify-between items-start">

                    <div class="flex-1 space-y-4">

                        {{-- Nama Depan & Belakang --}}
                        <div class="flex gap-4">
                            <div class="text-left">
                                <label class="block text-sm font-medium text-gray-500 mb-1">Nama Depan</label>
                                <input type="text" name="first_name" required
                                    value="{{ old('first_name', $first_name) }}"
                                    class="w-64 border text-gray-700 border-gray-300 rounded-xl px-4 py-2 capitalize">
                            </div>

                            <div class="text-left">
                                <label class="block text-sm font-medium text-gray-500 mb-1">Nama Belakang</label>
                                <input type="text" name="last_name" required value="{{ old('last_name', $last_name) }}"
                                    class="w-64 border text-gray-700 border-gray-300 rounded-xl px-4 py-2 capitalize">
                            </div>
                        </div>

                        {{-- Tanggal Lahir & Phone --}}
                        <div class="flex gap-4">
                            <div class="text-left">
                                <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Lahir</label>
                                <input type="date" name="date_of_birth" required value="{{ $petugas->date_of_birth }}"
                                    class="w-64 border text-gray-700 border-gray-300 rounded-xl px-4 py-2">
                            </div>

                            <div class="text-left">
                                <label class="block text-sm font-medium text-gray-500 mb-1">No Handphone</label>
                                <input type="text" name="phone" required value="{{ $petugas->phone }}"
                                    class="w-64 border text-gray-700 border-gray-300 rounded-xl px-4 py-2">
                            </div>
                        </div>

                        {{-- Email (Locked) --}}
                        <div class="text-left">
                            <label class="block text-sm font-medium text-gray-500 mb-1">Alamat Email (Terkunci)</label>
                            <input type="email" value="{{ $petugas->email }}" disabled
                                class="w-64 border text-gray-400 bg-gray-100 rounded-xl px-4 py-2 cursor-not-allowed">
                            <input type="hidden" name="email" value="{{ $petugas->email }}">
                        </div>

                        {{-- Pasar (Locked) --}}
                        <div class="text-left">
                            <label class="block text-sm font-medium text-gray-500 mb-1">Pasar Tugas (Terkunci)</label>
                            <input type="text" value="{{ $petugas->market->name_market }}" disabled
                                class="w-64 border text-gray-400 bg-gray-100 rounded-xl px-4 py-2 cursor-not-allowed">
                            <input type="hidden" name="market_id" value="{{ $petugas->market_id }}">
                        </div>

                        {{-- Status Akun (Locked) --}}
                        <div class="text-left">
                            <label class="block text-sm font-medium text-gray-500 mb-1">Status Akun (Terkunci)</label>
                            <input type="text" value="{{ ucfirst($petugas->status) }}" disabled
                                class="w-64 border text-gray-400 bg-gray-100 rounded-xl px-4 py-2 cursor-not-allowed">
                            <input type="hidden" name="status" value="{{ $petugas->status }}">
                        </div>

                        {{-- Password --}}
                        <div class="text-left">
                            <label class="block text-sm font-medium text-gray-500 mb-1">Password Baru (Opsional)</label>
                            <input type="password" name="password" placeholder="Kosongkan jika tidak ganti"
                                class="w-64 border text-gray-700 border-gray-300 rounded-xl px-4 py-2">
                        </div>

                        {{-- Tombol Simpan --}}
                        <button type="button" id="submitBtn"
                            class="px-14 py-2 bg-secondary text-white font-bold text-sm rounded-lg">
                            Simpan Perubahan
                        </button>
                    </div>

                    {{-- Foto --}}
                    <div class="relative mr-16">
                        <label for="image" class="cursor-pointer">
                            <div id="imagePreview"
                                class="h-48 w-48 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden">
                                @if ($petugas->image)
                                    <img src="{{ asset('storage/' . $petugas->image) }}?{{ time() }}"
                                        class="h-full w-full object-cover rounded-full">
                                @else
                                    <i data-lucide="camera" class="text-gray-500 h-8 w-8"></i>
                                @endif
                            </div>
                        </label>
                        <input type="file" id="image" name="image" class="hidden" accept="image/*">
                    </div>
                </div>

            </form>
        </div>
    </div>

    {{-- Script Konfirmasi --}}
    <script>
        document.getElementById('submitBtn').addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Simpan Perubahan?',
                text: 'Perubahan data akun admin akan disimpan.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('petugasForm').submit();
                }
            });
        });
    </script>
@endsection
