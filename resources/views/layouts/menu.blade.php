<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">

    {{-- Tempat untuk navbar --}}
    @yield('navbar')

    {{-- Konten halaman --}}
    <main class="container mx-auto p-6">
        @yield('content')
    </main>

</body>

</html>
