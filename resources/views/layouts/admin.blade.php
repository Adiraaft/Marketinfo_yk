<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-gray-100 flex">

    {{-- Sidebar di kiri --}}
    <x-sidebar />

    {{-- Area kanan berisi navbar + konten --}}
    <div class="flex-1 flex flex-col min-h-screen">

        {{-- Navbar di atas (bagian start konten) --}}
        <x-navbar-dashboard/>

        {{-- Konten halaman --}}
        <main class="flex-1">
            @yield('content')
        </main>

    </div>

</body>

@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2000
        });
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            showConfirmButton: false,
            timer: 2000
        });
    </script>
@endif

</html>
