<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Navbar Admin - SCENT ATELIER</title>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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
    <nav class="navbar">
        <div class="navbar-container">
            <div style="font-size: 23px;" class="logo">
                <a href="{{route('landingpage')}}">SCENT ATELIER</a>
            </div>
            <div class="hamburger" onclick="toggleMenu()">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <ul class="nav-links">
                <li><a href="{{ route('koleksi') }}">Koleksi</a></li>
                <li><a href="{{ route('landingpage') }}#about">Tentang</a></li>
                <li><a href="{{ route('contact') }}">Kontak</a></li>

                @auth('admin')
                    <!-- Desktop Dropdown -->
                    <li class="nav-desktop" style="display: flex; align-items: center; gap: 1rem;">
                        <div class="dropdown" id="adminDropdown">
                            <a href="javascript:void(0);" class="login-link" id="dropdownToggle" style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; user-select: none;">
                                <i class="fa fa-shield"></i> Admin
                            </a>
                            <ul class="dropdown-menu">
                                <li class="dropdown-header">Admin Menu</li>

                                <li>
                                    <a href="{{ route('admin.dashboard.index') }}">
                                        <i class="fa fa-cube"></i> Inventory Management
                                    </a>
                                </li>

                                <li>
                                    <form action="{{ route('logout') }}" method="POST" style="margin: 0; padding: 0;">
                                        @csrf
                                        <button type="submit" class="logout-btn" style="color: #dc2626 !important; display: flex; align-items: center; gap: 8px; padding: 10px 16px; width: 100%; font-size: 15px; background: none; border: none; cursor: pointer; transition: background 0.2s ease, color 0.2s ease; text-align: left; font-weight: 600;">
                                            <i class="fa fa-sign-out" style="color: #dc2626 !important;"></i> Keluar
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- Mobile Menu Items -->
                    <li class="nav-mobile">
                        <a href="{{ route('admin.dashboard.index') }}" style="display: block; padding: 0.5rem 0; font-weight: 600; color: #D2691E;">
                            <i class="fa fa-cube"></i> Dashboard Admin
                        </a>
                    </li>

                    <li class="nav-mobile">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" style="width: 100%; text-align: left; padding: 0.5rem 0; color: #dc2626; font-weight: 600; background: none; border: none; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                                <i class="fa fa-sign-out"></i> Keluar
                            </button>
                        </form>
                    </li>
                @endauth

                @guest('admin')
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
        // 1. FUNGSI TOGGLE HAMBURGER MENU
        function toggleMenu() {
            const navLinks = document.querySelector('.nav-links');
            const hamburger = document.querySelector('.hamburger');
            
            console.log('toggleMenu called!');
            console.log('Before toggle:', navLinks.classList.value);
            
            navLinks.classList.toggle('open');
            hamburger.classList.toggle('active');
            
            console.log('After toggle:', navLinks.classList.value);
        }

        // 2. DROPDOWN FUNCTIONALITY
        document.addEventListener("DOMContentLoaded", function() {
            console.log("DOM Loaded - Starting dropdown setup");
            
            const dropdown = document.getElementById('adminDropdown');
            const dropdownToggle = document.getElementById('dropdownToggle');
            
            console.log("Dropdown found:", dropdown);
            console.log("Toggle found:", dropdownToggle);
            
            if (dropdown && dropdownToggle) {
                // Toggle dropdown on click
                dropdownToggle.addEventListener("click", function(e) {
                    console.log("Dropdown toggle clicked!");
                    e.preventDefault();
                    e.stopPropagation();
                    dropdown.classList.toggle("active");
                    console.log("Dropdown is now:", dropdown.classList.contains("active") ? "OPEN" : "CLOSED");
                });
                
                // Close dropdown when clicking outside
                document.addEventListener("click", function(e) {
                    if (!dropdown.contains(e.target)) {
                        dropdown.classList.remove("active");
                    }
                });
            } else {
                console.error("Dropdown elements NOT found!");
            }
        });

        // 3. NAVBAR SCROLL EFFECT
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.remove('transparent');
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
                navbar.classList.add('transparent');
            }
        });

        // 4. LOADER FUNCTIONALITY
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
    </script>
</body>

</html>
