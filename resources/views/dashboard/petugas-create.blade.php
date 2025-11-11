@extends('layouts.admin')

@section('content')
    <div class="mx-15 mt-6 mb-10">
        <a href="{{ route('superadmin.petugas') }}" class="text-blue-500 hover:underline mt-3 inline-block">
            ← Kembali
        </a>

        <h3 class="text-2xl font-bold text-secondary my-6">
            {{ isset($petugas) ? 'Edit Operator' : 'Tambah Operator' }}
        </h3>

        <div class="w-full bg-white py-6 pl-9 shadow rounded-lg">
            <p class="text-secondary text-xl font-bold">Informasi Akun</p>
            <p class="text-xs font-medium text-gray-300">
                {{ isset($petugas) ? 'Edit Informasi Petugas' : 'Tambah Informasi Petugas' }}
            </p>

            <form id="petugasForm"
                action="{{ isset($petugas) ? route('superadmin.petugas.update', $petugas->id_user) : route('superadmin.petugas.store') }}"
                enctype="multipart/form-data" method="POST" class="space-y-4 mt-10 relative">
                @csrf
                @if (isset($petugas))
                    @method('PUT')
                @endif

                <div class="flex justify-between items-start">
                    <div class="flex-1 space-y-4">
                        {{-- Nama Depan & Belakang --}}
                        <div class="flex gap-4">
                            <div class="text-left">
                                <label class="block text-sm font-medium text-gray-500 mb-1">Nama Depan</label>
                                <input type="text" id="first_name" name="first_name" required
                                    value="{{ isset($petugas) ? explode(' ', $petugas->name)[0] : old('first_name') }}"
                                    class="w-57 border text-gray-500 border-gray-300 rounded-xl px-4 py-1 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            </div>
                            <div class="text-left">
                                <label class="block text-sm font-medium text-gray-500 mb-1">Nama Belakang</label>
                                <input type="text" id="last_name" name="last_name" required
                                    value="{{ isset($petugas) ? explode(' ', $petugas->name)[1] ?? '' : old('last_name') }}"
                                    class="w-57 border text-gray-500 border-gray-300 rounded-xl px-4 py-1 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            </div>
                        </div>

                        {{-- Tanggal Lahir & Phone --}}
                        <div class="flex gap-4">
                            <div class="text-left">
                                <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Lahir</label>
                                <input type="date" id="date_of_birth" name="date_of_birth" required
                                    value="{{ isset($petugas) ? $petugas->date_of_birth : old('date_of_birth') }}"
                                    class="w-57 border text-gray-500 border-gray-300 rounded-xl px-4 py-1 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            </div>
                            <div class="text-left">
                                <label class="block text-sm font-medium text-gray-500 mb-1">No Handphone</label>
                                <input type="text" id="phone" name="phone" required
                                    value="{{ isset($petugas) ? $petugas->phone : old('phone') }}"
                                    class="w-57 border text-gray-500 border-gray-300 rounded-xl px-4 py-1 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="text-left">
                            <label class="block text-sm font-medium text-gray-500 mb-1">Alamat Email</label>
                            <input type="email" id="email" name="email" required
                                value="{{ isset($petugas) ? $petugas->email : old('email') }}"
                                class="w-57 border text-gray-500 border-gray-300 rounded-xl px-4 py-1 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        </div>

                        {{-- Pasar --}}
                        <div class="text-left">
                            <label for="market_id" class="block text-sm font-medium text-gray-500 mb-1">Pasar Tugas</label>
                            <select id="market_id" name="market_id" required
                                class="w-57 border text-gray-500 border-gray-300 rounded-xl px-4 py-1 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                <option value="">Pilih Pasar</option>
                                @foreach ($markets as $market)
                                    <option value="{{ $market->id_market }}"
                                        {{ isset($petugas) && $petugas->market_id == $market->id_market ? 'selected' : '' }}>
                                        {{ $market->name_market }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Status --}}
                        <div class="text-left">
                            <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                            <select id="status" name="status"
                                class="w-57 border text-gray-500 border-gray-300 rounded-xl px-4 py-1 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                <option value="aktif"
                                    {{ isset($petugas) && $petugas->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="tidak aktif"
                                    {{ isset($petugas) && $petugas->status == 'tidak aktif' ? 'selected' : '' }}>Nonaktif
                                </option>
                            </select>
                        </div>

                        {{-- Password --}}
                        <div class="text-left">
                            <label class="block text-sm font-medium text-gray-500 mb-1">Password</label>
                            <input type="password" id="password" name="password"
                                placeholder="{{ isset($petugas) ? 'Kosongkan jika tidak ingin ganti password' : '' }}"
                                class="w-57 border text-gray-500 border-gray-300 rounded-xl px-4 py-1 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        </div>

                        {{-- Tombol Simpan --}}
                        <button type="button" id="submitBtn"
                            class="px-13 py-2 bg-secondary text-white font-bold text-sm rounded-lg">
                            {{ isset($petugas) ? 'Update' : 'Tambah' }}
                        </button>
                    </div>

                    {{-- Gambar --}}
                    <div class="relative mr-16">
                        <label for="image" class="cursor-pointer">
                            <div id="imagePreview"
                                class="h-48 w-48 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden">
                                @if (isset($petugas) && $petugas->image)
                                    <img src="{{ asset('storage/' . $petugas->image) }}?{{ time() }}"
                                        class="h-full w-full object-cover rounded-full" id="currentImage">
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('petugasForm');
            const submitBtn = document.getElementById('submitBtn');
            const imageInput = document.getElementById('image');
            const imagePreview = document.getElementById('imagePreview');
            const currentImage = document.getElementById('currentImage');

            // Preview Gambar
            if (imageInput) {
                imageInput.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            imagePreview.innerHTML =
                                `<img src="${e.target.result}" class="h-full w-full object-cover rounded-full">`;
                        }
                        reader.readAsDataURL(file);
                    } else {
                        if (currentImage) {
                            imagePreview.innerHTML =
                                `<img src="${currentImage.src}" class="h-full w-full object-cover rounded-full">`;
                        } else {
                            imagePreview.innerHTML =
                                `<i data-lucide="camera" class="text-gray-500 h-8 w-8"></i>`;
                        }
                    }
                });
            }

            // SweetAlert Konfirmasi Tambah/Update
            if (submitBtn) {
                submitBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: '{{ isset($petugas) ? 'Konfirmasi Perubahan' : 'Konfirmasi Penambahan' }}',
                        text: '{{ isset($petugas) ? 'Apakah kamu yakin ingin menyimpan perubahan data petugas ini?' : 'Apakah kamu yakin ingin menambahkan petugas baru?' }}',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '{{ isset($petugas) ? 'Ya, simpan perubahan!' : 'Ya, tambahkan!' }}',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            }
        });
    </script>
@endsection
