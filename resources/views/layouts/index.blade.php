<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-gray-100">

    {{-- Tempat untuk navbar --}}
    @yield('navbar')

    {{-- Konten halaman --}}
    <main class="container mx-auto p-6">
        @yield('content')
    </main>

    <x-footer />
</body>

</html>
