<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Navbar Admin - SCENT ATELIER</title>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />

    <link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/user.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/loader.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/cart.css') }}">
    @stack('styles')
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body>
    <nav class="navbar" id="navbar">
        <div class="navbar-container">
            <div class="logo"><a href="{{ route('landingpage') }}">SCENT ATELIER</a></div>
            <div class="hamburger" onclick="toggleMenu()">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <ul class="nav-links">
                <li><a href="{{ route('koleksi') }}">Koleksi</a></li>
                <li><a href="{{ route('landingpage') }}#about">Tentang</a></li>
                <li><a href="{{ route('contact') }}">Kontak</a></li>

                @auth('web')
                    <li class="nav-desktop flex items-center gap-4">
                        <a href="{{ route('user.cart') }}" class="text-gray-800 hover:text-amber-600 relative">
                            <i class="fa fa-shopping-cart fa-lg"></i>
                        </a>

                        <div class="dropdown relative">
                            <a href="#" class="login-link flex items-center gap-2">
                                <i class="fa fa-user"></i> Akun
                            </a>
                            <ul class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg hidden z-50">
                                <li class="dropdown-header px-4 py-2 font-bold border-b">User Menu</li>

                                <li>
                                    <a href="{{ route('user.dashboard') }}"
                                        class="block px-4 py-2 hover:bg-amber-100 hover:text-amber-600 flex items-center gap-2">
                                        <i class="fa fa-user-circle"></i> Profil
                                    </a>
                                </li>

                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="w-full m-0 p-0">
                                        @csrf
                                        <button type="submit"
                                            class="logout-btn flex items-center gap-2 px-4 py-2 w-full text-red-600 hover:bg-red-100">
                                            <i class="fa fa-sign-out"></i> Keluar
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endauth

                @auth('web')
                    <li class="nav-mobile">
                        <a href="{{ route('user.cart') }}"
                            style="display: block; padding: 0.5rem 0; font-weight: 600; color: #D2691E;">
                            <i class="fa fa-shopping-cart"></i> Keranjang
                        </a>
                    </li>

                    <li class="nav-mobile">
                        <a href="{{ route('user.dashboard') }}"
                            style="display: block; padding: 0.5rem 0; font-weight: 600;">
                            <i class="fa fa-user-circle"></i> Dashboard
                        </a>
                    </li>

                    <li class="nav-mobile">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                style="width: 100%; text-align: left; padding: 0.5rem 0; color: #dc2626; font-weight: 600; background: none; border: none; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                                <i class="fa fa-sign-out"></i> Keluar
                            </button>
                        </form>
                    </li>
                @endauth

                @guest('web')
                    <li>
                        <a href="{{ route('login') }}" class="login-btn">
                            <i class="fa fa-user"></i> Masuk
                        </a>
                    </li>
                @endguest
            </ul>
        </div>
    </nav>

    <main class="flex-1">
        @yield('content')
    </main>
    <div id="global-loader">
        <div class="loader-wrapper">
            <div class="spinner"></div>
            <p>Memuat...</p>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const dropdowns = document.querySelectorAll(".dropdown");

            dropdowns.forEach(dropdown => {
                const toggle = dropdown.querySelector(".login-link");

                toggle.addEventListener("click", function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    dropdowns.forEach(d => {
                        if (d !== dropdown) d.classList.remove("active");
                    });

                    dropdown.classList.toggle("active");
                });
            });

            document.addEventListener("click", function(e) {
                dropdowns.forEach(dropdown => {
                    if (!dropdown.contains(e.target)) {
                        dropdown.classList.remove("active");
                    }
                });
            });
        });
        document.addEventListener("DOMContentLoaded", function() {
            window.addEventListener("load", function() {
                const loader = document.getElementById("global-loader");
                loader.classList.add("hidden");
            });
        });

        function showLoader() {
            document.getElementById("global-loader").classList.remove("hidden");
        }

        function hideLoader() {
            document.getElementById("global-loader").classList.add("hidden");
        }

        document.addEventListener('DOMContentLoaded', () => {
            const hamburger = document.querySelector('.hamburger');
            const navLinks = document.querySelector('.nav-links');

            hamburger.addEventListener('click', () => {
                hamburger.classList.toggle('active');
                navLinks.classList.toggle('open');
            });

            // Klik di luar → tutup menu
            document.addEventListener('click', (e) => {
                if (!hamburger.contains(e.target) && !navLinks.contains(e.target)) {
                    hamburger.classList.remove('active');
                    navLinks.classList.remove('open');
                }
            });
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        AOS.init({
            once: true
        });
    </script>
</body>

</html>
