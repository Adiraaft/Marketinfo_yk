@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="mx-15 mt-6 mb-10">
        <a href="{{ route('superadmin.market') }}" class="text-blue-500 hover:underline mt-3 inline-block">
            ← Kembali
        </a>

        <h3 class="text-2xl font-bold text-secondary my-6">
            {{ isset($market) ? 'Edit Data Pasar' : 'Tambah Data Pasar' }}
        </h3>

        <div class="w-full bg-white py-6 pl-9 shadow rounded-lg">
            <p class="text-secondary text-xl font-bold">
                {{ isset($market) ? 'Formulir Edit Pasar' : 'Formulir Tambah Pasar' }}
            </p>

            <form id="marketForm"
                action="{{ isset($market) ? route('superadmin.market.update', $market->id_market) : route('superadmin.market.store') }}"
                method="POST" enctype="multipart/form-data" class="space-y-3 mt-2">

                @csrf
                @if (isset($market))
                    @method('PUT')
                @endif

                <!-- Input Nama Pasar -->
                <div class="text-left">
                    <label class="block text-sm font-medium text-gray-500 mb-1">Nama Pasar</label>
                    <input type="text" id="name_market" name="name_market"
                        value="{{ old('name_market', $market->name_market ?? '') }}" required
                        class="w-90 border text-gray-500 border-gray-300 rounded-xl px-4 py-1 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <!-- Input Alamat -->
                <div class="text-left">
                    <label class="block text-sm font-medium text-gray-500 mb-1">Alamat</label>
                    <input type="text" id="address" name="address" value="{{ old('address', $market->address ?? '') }}"
                        required
                        class="w-90 border text-gray-500 border-gray-300 rounded-xl px-4 py-1 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <!-- Input Maps Link -->
                <div class="text-left">
                    <label class="block text-sm font-medium text-gray-500 mb-1">Link Google Maps</label>
                    <input type="text" id="maps_link" name="maps_link"
                        value="{{ old('maps_link', $market->maps_link ?? '') }}"
                        class="w-90 border text-gray-500 border-gray-300 rounded-xl px-4 py-1 focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                </div>

                <!-- Input Deskripsi -->
                <div class="text-left">
                    <label class="block text-sm font-medium text-gray-500 mb-1">Deskripsi Pasar</label>
                    <textarea id="description" name="description" rows="4" required
                        class="w-150 border text-gray-500 border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none resize-none"
                        placeholder="Tuliskan deskripsi singkat tentang pasar...">{{ old('description', $market->description ?? '') }}</textarea>
                </div>

                <!-- Input Jam Buka -->
                <div class="text-left">
                    <label class="block text-sm font-medium text-gray-500 mb-1">Jam Buka</label>
                    <input type="text" id="opening_hours" name="opening_hours"
                        value="{{ old('opening_hours', $market->opening_hours ?? '') }}" required
                        class="w-90 border text-gray-500 border-gray-300 rounded-xl px-4 py-1 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <!-- Input Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                    <select name="status"
                        class="w-90 border border-gray-300 rounded-xl px-4 py-2 focus:ring-blue-500 focus:outline-none"
                        required>
                        <option value="aktif" {{ old('status', $market->status ?? '') == 'aktif' ? 'selected' : '' }}>Aktif
                        </option>
                        <option value="tidak aktif"
                            {{ old('status', $market->status ?? '') == 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif
                        </option>
                    </select>
                </div>

                <!-- Input Gambar -->
                <div class="text-left">
                    <label class="block text-sm font-medium text-gray-500 mb-1">Gambar Pasar</label>
                    <label for="image" class="cursor-pointer">
                        <div id="imagePreview"
                            class="h-21 w-28 bg-gray-200 rounded-lg flex items-center justify-center overflow-hidden border border-gray-300">
                            @if (isset($market) && $market->image)
                                <img src="{{ asset('storage/' . $market->image) }}" class="h-full w-full object-cover"
                                    alt="Preview">
                            @else
                                <i data-lucide="upload" class="text-gray-500 w-6 h-6"></i>
                            @endif
                        </div>
                    </label>
                    <input type="file" id="image" name="image" class="hidden" accept="image/*">
                </div>

                <!-- Tombol Tambah/Update dan Hapus -->
                <div class="mt-6 flex gap-2">
                    <!-- Tombol Tambah/Update dengan SweetAlert -->
                    <button type="button" id="submitBtn"
                        class="px-13 py-2 bg-secondary text-white font-bold text-sm rounded-lg">
                        {{ isset($market) ? 'Update' : 'Tambah' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('marketForm');
            const submitBtn = document.getElementById('submitBtn');
            const imageInput = document.getElementById('image');
            const imagePreview = document.getElementById('imagePreview');

            // Preview gambar
            if (imageInput) {
                imageInput.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            imagePreview.innerHTML =
                                `<img src="${e.target.result}" class="h-full w-full object-cover rounded-lg">`;
                        };
                        reader.readAsDataURL(file);
                    } else {
                        imagePreview.innerHTML =
                            `<i data-lucide="upload" class="text-gray-500 w-6 h-6"></i>`;
                    }
                });
            }

            // SweetAlert konfirmasi tambah/update
            if (submitBtn) {
                submitBtn.addEventListener('click', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: '{{ isset($market) ? 'Konfirmasi Perubahan' : 'Konfirmasi Penambahan' }}',
                        text: '{{ isset($market) ? 'Apakah kamu yakin ingin menyimpan perubahan data pasar ini?' : 'Apakah kamu yakin ingin menambahkan pasar baru?' }}',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '{{ isset($market) ? 'Ya, simpan!' : 'Ya, tambahkan!' }}',
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
