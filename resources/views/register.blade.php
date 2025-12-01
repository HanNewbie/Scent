<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SCENT ATELIER - Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="bg-amber-50">
    <div class="absolute top-[-10px] sm:top-4 left-4">
        <a href="{{ url()->previous() }}" 
        class="flex items-center gap-2 text-amber-800 hover:text-amber-600 font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
    </div>

    <div class="min-h-screen flex flex-col items-center justify-center p-4">
        <div class="w-full max-w-md bg-white rounded-3xl shadow-xl p-8 space-y-6">
            <div class="text-center space-y-1">
                <h1 class="text-lg font-semibold text-amber-800 tracking-wider">SCENT ATELIER</h1>
                <p class="text-gray-700 text-sm">Buat akun baru Anda</p>
            </div>

            <form action="{{ route('register.submit') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-amber-800">Nama Lengkap</label>
                    <div class="relative mt-1">
                        <i class="fa fa-user absolute left-3 top-2.5 text-gray-400"></i>
                        <input type="text" id="name" name="name" required
                            class="w-full rounded-lg border border-gray-300 bg-gray-100 pl-10 pr-3 py-2 text-gray-900 placeholder:text-gray-500
                            hover:border-gray-500 focus:border-gray-500 focus:ring-1 focus:ring-gray-400 transition duration-200 text-sm"
                            placeholder="Nama lengkap">
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-amber-800 mt-3">Email</label>
                    <div class="relative mt-1">
                        <i class="fa fa-envelope absolute left-3 top-2.5 text-gray-400"></i>
                        <input type="email" id="email" name="email" required
                            class="w-full rounded-lg border border-gray-300 bg-gray-100 pl-10 pr-3 py-2 text-gray-900 placeholder:text-gray-500
                            hover:border-gray-500 focus:border-gray-500 focus:ring-1 focus:ring-gray-400 transition duration-200 text-sm"
                            placeholder="nama@email.com">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-amber-800 mt-3">Password</label>
                    <div class="relative mt-1">
                        <i class="fa fa-lock absolute left-3 top-2.5 text-gray-400"></i>
                        <input type="password" id="password" name="password" required
                            class="w-full rounded-lg border border-gray-300 bg-gray-100 pl-10 pr-10 py-2 text-gray-900 placeholder:text-gray-500
                            hover:border-gray-500 focus:border-gray-500 focus:ring-1 focus:ring-gray-400 transition duration-200 text-sm"
                            placeholder="********">
                        <i class="fa fa-eye absolute right-3 top-2.5 text-gray-400 cursor-pointer"></i>
                    </div>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-amber-800 mt-3">Konfirmasi Password</label>
                    <div class="relative mt-1">
                        <i class="fa fa-lock absolute left-3 top-2.5 text-gray-400"></i>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            class="w-full rounded-lg border border-gray-300 bg-gray-100 pl-10 pr-10 py-2 text-gray-900 placeholder:text-gray-500
                            hover:border-gray-500 focus:border-gray-500 focus:ring-1 focus:ring-gray-400 transition duration-200 text-sm"
                            placeholder="********">
                        <i class="fa fa-eye absolute right-3 top-2.5 text-gray-400 cursor-pointer"></i>
                    </div>
                </div>

                <button type="submit"
                    class="w-full py-2.5 rounded-lg shadow-sm text-sm font-medium text-white bg-amber-800 hover:bg-amber-700 transition duration-200">
                    Daftar
                </button>

                @if ($errors->any())
                    <div class="text-red-600 text-sm mt-2">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </form>

            <div class="text-center text-sm text-gray-600 pt-2">
                Sudah punya akun? <a href="{{ route('login') }}" class="font-medium text-amber-700 hover:text-amber-600">Masuk
                    sekarang</a>
            </div>
        </div>

        <p class="text-center text-xs text-gray-500 mt-4 max-w-sm">
            Dengan mendaftar, Anda menyetujui
            <a href="#" class="text-amber-700 hover:underline">Syarat & Ketentuan</a> dan
            <a href="#" class="text-amber-700 hover:underline">Kebijakan Privasi</a>
        </p>
    </div>
</body>

</html>
