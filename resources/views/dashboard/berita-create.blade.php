@extends('layouts.admin')

@section('content')
    <div class="mx-15 mt-6 mb-10">
        <a href="{{ route('superadmin.berita.index') }}" class="text-blue-500 hover:underline mt-3 inline-block">
            ← Kembali
        </a>

        <h3 class="text-2xl font-bold text-secondary my-6">
            {{ isset($berita) ? 'Edit Berita' : 'Tambah Berita' }}
        </h3>

        <div class="w-full bg-white py-8 px-10 shadow rounded-lg">
            <p class="text-secondary text-xl font-bold">Informasi Berita</p>
            <p class="text-xs font-medium text-gray-400">
                {{ isset($berita) ? 'Edit Informasi Berita' : 'Tambah Informasi Berita' }}
            </p>

            {{-- FORM UTAMA (TAMBAH / EDIT) --}}
            <form
                action="{{ isset($berita) ? route('superadmin.berita.update', $berita->id) : route('superadmin.berita.store') }}"
                enctype="multipart/form-data" method="POST" class="space-y-6 mt-8">
                @csrf
                @if (isset($berita))
                    @method('PUT')
                @endif

                <div class="flex gap-10 items-start">
                    {{-- UPLOAD GAMBAR --}}
                    <div class="w-75">
                        <div class="relative mb-2">
                            <label for="image1" class="cursor-pointer">
                                <div id="imagePreview1"
                                    class="h-60 w-full rounded-xl bg-gray-100 flex items-center justify-center overflow-hidden border border-gray-300 hover:border-blue-400 transition">
                                    @if (isset($berita) && $berita->image1)
                                        <img src="{{ asset('storage/' . $berita->image1) }}?{{ time() }}"
                                            class="h-full w-full object-cover" id="currentImage1">
                                    @else
                                        <i data-lucide="camera" class="text-gray-400 h-10 w-10"></i>
                                    @endif
                                </div>
                            </label>
                            <input type="file" id="image1" name="image1" class="hidden" accept="image/*">
                        </div>

                        <div class="grid grid-cols-3 gap-2">
                            @for ($i = 2; $i <= 4; $i++)
                                <div class="relative">
                                    <label for="image{{ $i }}" class="cursor-pointer">
                                        <div id="imagePreview{{ $i }}"
                                            class="h-20 w-full rounded-xl bg-gray-100 flex items-center justify-center overflow-hidden border border-gray-300 hover:border-blue-400 transition">
                                            @if (isset($berita) && $berita->{'image' . $i})
                                                <img src="{{ asset('storage/' . $berita->{'image' . $i}) }}?{{ time() }}"
                                                    class="h-full w-full object-cover"
                                                    id="currentImage{{ $i }}">
                                            @else
                                                <i data-lucide="camera" class="text-gray-400 h-8 w-8"></i>
                                            @endif
                                        </div>
                                    </label>
                                    <input type="file" id="image{{ $i }}" name="image{{ $i }}"
                                        class="hidden" accept="image/*">
                                </div>
                            @endfor
                        </div>
                    </div>

                    {{-- FORM INPUT --}}
                    <div class="flex-1 space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Judul Berita</label>
                            <input type="text" id="title" name="title" required
                                value="{{ isset($berita) ? $berita->title : old('title') }}"
                                class="w-full border text-gray-600 border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Deskripsi</label>
                            <textarea id="description" name="description" required rows="8"
                                class="w-full border text-gray-600 border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ isset($berita) ? $berita->description : old('description') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Sumber</label>
                            <input type="text" id="source" name="source"
                                value="{{ isset($berita) ? $berita->source : old('source') }}"
                                placeholder="Contoh: Kompas, Detik, atau sumber internal"
                                class="w-full border text-gray-600 border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        </div>

                        {{-- Tombol Submit + Hapus --}}
                        <div class="flex gap-4 items-center">
                            <button type="submit"
                                class="px-10 py-2 bg-secondary text-white font-bold text-sm rounded-lg hover:bg-blue-600 transition">
                                {{ isset($berita) ? 'Update Berita' : 'Tambah' }}
                            </button>

                            @if (isset($berita))
                                <button type="button" id="deleteButton"
                                    class="px-10 py-2 bg-red-500 text-white font-bold text-sm rounded-lg hover:bg-red-600 transition">
                                    Hapus
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </form>

            {{-- FORM HAPUS (disembunyikan) --}}
            @if (isset($berita))
                <form id="deleteForm" action="{{ route('superadmin.berita.destroy', $berita->id) }}" method="POST"
                    style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            @endif
        </div>
    </div>

    {{-- Script Preview Gambar --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            for (let i = 1; i <= 4; i++) {
                const imageInput = document.getElementById('image' + i);
                const imagePreview = document.getElementById('imagePreview' + i);
                const currentImage = document.getElementById('currentImage' + i);

                if (imageInput) {
                    imageInput.addEventListener('change', function() {
                        const file = this.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                imagePreview.innerHTML =
                                    `<img src="${e.target.result}" class="h-full w-full object-cover rounded-xl">`;
                            }
                            reader.readAsDataURL(file);
                        } else {
                            if (currentImage) {
                                imagePreview.innerHTML =
                                    `<img src="${currentImage.src}" class="h-full w-full object-cover rounded-xl">`;
                            } else {
                                imagePreview.innerHTML =
                                    `<i data-lucide="camera" class="text-gray-400 h-8 w-8"></i>`;
                            }
                        }
                    });
                }
            }

            // Tombol Hapus dengan SweetAlert
            const deleteBtn = document.getElementById('deleteButton');
            if (deleteBtn) {
                deleteBtn.addEventListener('click', function() {
                    Swal.fire({
                        title: 'Apakah kamu yakin?',
                        text: "Berita ini akan dihapus permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('deleteForm').submit();
                        }
                    });
                });
            }
        });
    </script>
@endsection
