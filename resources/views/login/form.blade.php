<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <script>
        Swal("Test", "Ini SweetAlert jalan", "success");
    </script>
    <div class="min-h-screen flex flex-col items-center justify-center">
        <div class="p-8 rounded-2xl text-center">
            <img src="{{ asset('images/logo.png') }}" alt="logo" class="w-39 h-55 mx-auto mb-4">
            <h3 class="text-2xl font-bold text-gray-800 leading-tight mb-3">
                Dashboard Harga Komoditas <br> Kota Yogyakarta
            </h3>
            <p class="text-sm text-gray-600 mb-10">Selamat datang kembali! Silakan masuk</p>

            <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                @csrf
                <!-- Login Gagal -->
                @if ($errors->has('loginError'))
                    <p class="text-red-500 text-sm">{{ $errors->first('loginError') }}</p>
                @endif
                <!-- Username -->
                <div class="text-left">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        class="w-full border border-gray-300
                        rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        placeholder="Masukkan email anda">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="text-left">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" id="password" name="password"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        placeholder="Masukkan password anda">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Button -->
                <button type="submit" name="submit"
                    class="w-full bg-secondary text-white font-semibold rounded-xl py-3 transition cursor-pointer">
                    Login
                </button>
            </form>
        </div>
    </div>
    <!-- SweetAlert Error -->
    @if ($errors->has('loginError'))
        <script type="module">
            // pastikan ini pakai type="module" agar import JS modern bisa jalan
            Swal.fire({
                title: "Login Gagal",
                text: "{{ $errors->first('loginError') }}",
                icon: "error",
                confirmButtonText: "Ok"
            });
        </script>
    @endif

    @error('email')
        <script type="module">
            Swal.fire({
                title: "Gagal!",
                text: "{{ $message }}",
                icon: "warning",
                confirmButtonText: "Ok"
            });
        </script>
    @enderror

    @error('password')
        <script type="module">
            Swal.fire({
                title: "Gagal!",
                text: "{{ $message }}",
                icon: "warning",
                confirmButtonText: "Ok"
            });
        </script>
    @enderror

    @if (session('success'))
        <script type="module">
            Swal.fire({
                title: "Berhasil!",
                text: "Logout Berhasil",
                icon: "success",
                confirmButtonText: "Ok",
            });
        </script>
    @endif

</body>

</html>
