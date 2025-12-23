<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SCENT ATELIER - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
</head>

<body class="bg-amber-50">
    <!-- Back Button - Responsive positioning -->
    <div class="fixed top-4 left-4 z-50 sm:absolute">
        <a href="{{ route('landingpage') }}" 
           class="back-button flex items-center gap-2 text-amber-800 hover:text-amber-600 font-medium text-sm sm:text-base transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            <span class="hidden sm:inline">Kembali</span>
        </a>
    </div>

    <!-- Main Container -->
    <div class="min-h-screen flex flex-col items-center justify-center p-4 sm:p-6 pt-16 sm:pt-4">
        <!-- Login Card -->
        <div class="login-container w-full max-w-md bg-white rounded-2xl sm:rounded-3xl shadow-xl p-6 sm:p-8 space-y-5 sm:space-y-6">
            
            <!-- Header -->
            <div class="text-center space-y-1">
                <h1 class="text-xl sm:text-2xl font-semibold text-amber-800 tracking-wider">SCENT ATELIER</h1>
                <p class="text-gray-700 text-sm sm:text-base">Masuk ke akun Anda</p>
            </div>

            <!-- Login Form -->
            <form action="{{ route('login.submit') }}" method="POST" class="space-y-4 sm:space-y-5">
                @csrf
                
                <!-- Role Selection -->
                <div>
                    <label class="text-sm font-medium text-amber-800">Login sebagai</label>
                    <div class="grid grid-cols-2 gap-2 sm:gap-3 mt-2">
                        <!-- Customer -->
                        <div>
                            <input type="radio" name="role" value="user" id="role-user" class="peer hidden" checked>
                            <label for="role-user"
                                class="flex flex-col items-center justify-center gap-1.5 sm:gap-2 p-3 sm:p-4 rounded-lg sm:rounded-xl cursor-pointer border-2 transition-all duration-200
                                    border-gray-300 text-gray-700 bg-white
                                    hover:bg-[#f6e9e2] hover:border-[#a1532a]
                                    peer-checked:bg-[#f6e9e2] peer-checked:border-[#a1532a]
                                    peer-checked:hover:bg-[#f6e9e2] peer-checked:hover:border-[#a1532a]
                                    relative min-h-[80px] sm:min-h-[100px]">
                                <i class="fa fa-user text-base sm:text-lg text-amber-800"></i>
                                <span class="text-xs sm:text-sm font-medium">Customer</span>
                                <span class="absolute top-2 right-2 w-2.5 h-2.5 sm:w-3 sm:h-3 bg-[#a1532a] rounded-full hidden peer-checked:block"></span>
                            </label>
                        </div>

                        <!-- Admin -->
                        <div>
                            <input type="radio" name="role" value="admin" id="role-admin" class="peer hidden">
                            <label for="role-admin"
                                class="flex flex-col items-center justify-center gap-1.5 sm:gap-2 p-3 sm:p-4 rounded-lg sm:rounded-xl cursor-pointer border-2 transition-all duration-200
                                    border-gray-300 text-gray-700 bg-white
                                    hover:bg-[#f6e9e2] hover:border-[#a1532a]
                                    peer-checked:bg-[#f6e9e2] peer-checked:border-[#a1532a]
                                    peer-checked:hover:bg-[#f6e9e2] peer-checked:hover:border-[#a1532a]
                                    relative min-h-[80px] sm:min-h-[100px]">
                                <i class="fa fa-shield text-base sm:text-lg text-amber-800"></i>
                                <span class="text-xs sm:text-sm font-medium">Admin</span>
                                <span class="absolute top-2 right-2 w-2.5 h-2.5 sm:w-3 sm:h-3 bg-[#a1532a] rounded-full hidden peer-checked:block"></span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-sm font-medium text-amber-800 mb-1">Email</label>
                    <div class="relative">
                        <i class="fa fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="email" id="email" name="email" required
                            class="w-full rounded-lg border border-gray-300 bg-gray-100 pl-10 pr-3 py-2.5 sm:py-2 text-gray-900 placeholder:text-gray-500
                            hover:border-gray-500 focus:border-gray-500 focus:ring-1 focus:ring-gray-400 transition duration-200 text-base"
                            placeholder="nama@email.com">
                    </div>
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-sm font-medium text-amber-800 mb-1">Password</label>
                    <div class="relative">
                        <i class="fa fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="password" id="password" name="password" required
                            class="w-full rounded-lg border border-gray-300 bg-gray-100 pl-10 pr-10 py-2.5 sm:py-2 text-gray-900 placeholder:text-gray-500
                            hover:border-gray-500 focus:border-gray-500 focus:ring-1 focus:ring-gray-400 transition duration-200 text-base"
                            placeholder="********">
                        <i class="fa fa-eye absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 cursor-pointer text-sm" 
                           onclick="togglePassword()"></i>
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs sm:text-sm flex-wrap gap-2">
                    <a href="{{ route('forgot.password') }}" class="text-amber-700 hover:text-amber-600 whitespace-nowrap">Lupa password?</a>
                </div>

                <button type="submit"
                    class="w-full py-3 sm:py-2.5 rounded-lg shadow-sm text-sm sm:text-base font-medium text-white bg-amber-800 hover:bg-amber-700 
                    active:bg-amber-900 transition duration-200 min-h-[44px]">
                    Masuk
                </button>

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-lg p-3 text-red-600 text-xs sm:text-sm">
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
            </form>

            <div class="space-y-3">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-xs sm:text-sm">
                        <span class="bg-white px-2 text-gray-500">Atau masuk dengan</span>
                    </div>
                </div>

                <a href="{{ route('google.login') }}"
                    class="flex items-center justify-center w-full py-2.5 sm:py-2 px-4 border border-gray-300 rounded-lg shadow-sm 
                    text-sm sm:text-base font-medium text-gray-700 bg-white hover:bg-gray-50 active:bg-gray-100 
                    transition duration-200 gap-2 min-h-[44px]">
                    <i class="fab fa-google text-red-500 text-base"></i>
                    <span>Google</span>
                </a>
            </div>

            <div class="text-center text-xs sm:text-sm text-gray-600 pt-2">
                Belum punya akun? 
                <a href="{{route('register')}}" class="font-medium text-amber-700 hover:text-amber-600 underline">
                    Daftar sekarang
                </a>
            </div>
        </div>

        <p class="text-center text-xs text-gray-500 mt-4 sm:mt-6 max-w-sm px-4">
            Dengan masuk, Anda menyetujui
            <a href="#" class="text-amber-700 hover:underline">Syarat & Ketentuan</a> dan
            <a href="#" class="text-amber-700 hover:underline">Kebijakan Privasi</a>
        </p>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.querySelector('.fa-eye');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            if (/iPhone|iPad|iPod/i.test(navigator.userAgent)) {
                const inputs = document.querySelectorAll('input');
                inputs.forEach(input => {
                    input.addEventListener('focus', function() {
                        this.style.fontSize = '16px';
                    });
                });
            }
        });
    </script>
</body>

</html>