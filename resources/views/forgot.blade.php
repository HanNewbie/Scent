<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SCENT ATELIER - Forgot Password</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="bg-amber-50">
    <div class="fixed top-4 left-4 z-50">
        <a href="{{ route('login') }}"
            class="flex items-center gap-2 text-amber-800 hover:text-amber-600 font-medium text-sm transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    <div class="min-h-screen flex items-center justify-center p-4 pt-16">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-6 sm:p-8 space-y-6">
            <div class="text-center space-y-1">
                <h1 class="text-xl sm:text-2xl font-semibold text-amber-800 tracking-wider">
                    SCENT ATELIER
                </h1>
                <p class="text-gray-700 text-sm sm:text-base">
                    Lupa Password
                </p>
            </div>
            @if (session('status'))
                <div class="bg-green-50 border border-green-200 rounded-lg p-3 text-green-700 text-sm">
                    <i class="fa fa-check-circle mr-1"></i>
                    {{ session('status') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-50 border border-red-200 rounded-lg p-3 text-red-700 text-sm">
                    <i class="fa fa-exclamation-circle mr-1"></i>
                    {{ session('error') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-lg p-3 text-red-700 text-sm">
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="flex items-start gap-2">
                                <i class="fa fa-exclamation-circle mt-0.5"></i>
                                <span>{{ $error }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('forgot.password.post') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-amber-800 mb-1">
                        Email
                    </label>
                    <div class="relative">
                        <i class="fa fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="email" name="email" id="email" required
                            class="w-full rounded-lg border border-gray-300 bg-gray-100 pl-10 pr-3 py-2.5
                            text-gray-900 placeholder:text-gray-500
                            hover:border-gray-500 focus:border-gray-500 focus:ring-1 focus:ring-gray-400
                            transition duration-200"
                            placeholder="nama@email.com">
                    </div>
                </div>
                <button type="submit"
                    class="w-full py-3 rounded-lg shadow-sm text-sm font-medium text-white
                    bg-amber-800 hover:bg-amber-700 active:bg-amber-900 transition duration-200">
                    Kirim Link Reset Password
                </button>
            </form>
            <p class="text-center text-xs text-gray-500">
                Kami akan mengirimkan tautan reset password ke email Anda.
            </p>
        </div>
    </div>

</body>

</html>
