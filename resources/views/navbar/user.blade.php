<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/css/lp.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Document</title>
</head>

<body>
    <nav class="navbar transparent" id="navbar">
        <div class="navbar-container">
            <div style="font-size: 23px;" class="logo">SCENT ATELIER</div>
            <div class="hamburger" onclick="toggleMenu()">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <ul class="nav-links">
                <li><a href="{{ route('koleksi') }}">Koleksi</a></li>
                <li><a href="#about">Tentang</a></li>
                <li><a href="{{ route('contact') }}">Kontak</a></li>

                @auth('web')
                    <!-- Desktop Dropdown -->
                    <li class="nav-desktop" style="display: flex; align-items: center; gap: 1rem;">
                        <a href="{{ route('user.cart') }}" class="cart-icon" style="text-decoration: none; transition: color 0.3s;">
                            <i class="fa fa-shopping-cart fa-lg"></i>
                        </a>

                        <div class="dropdown">
                            <a href="javascript:void(0);" class="login-link" style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; user-select: none;">
                                <i class="fa fa-user"></i> Akun
                            </a>
                            <ul class="dropdown-menu">
                                <li class="dropdown-header">User Menu</li>

                                <li>
                                    <a href="{{ route('user.dashboard') }}">
                                        <i class="fa fa-user-circle"></i> Profil
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
                @endauth

                @auth('web')
                    <!-- Mobile Menu Items -->
                    <li class="nav-mobile">
                        <a href="{{ route('user.cart') }}" style="display: block; padding: 0.5rem 0; font-weight: 600; color: #D2691E;">
                            <i class="fa fa-shopping-cart"></i> Keranjang
                        </a>
                    </li>

                    <li class="nav-mobile">
                        <a href="{{ route('user.dashboard') }}" style="display: block; padding: 0.5rem 0; font-weight: 600;">
                            <i class="fa fa-user-circle"></i> Dashboard
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

    <script>
        // Toggle hamburger menu untuk mobile
        document.addEventListener("DOMContentLoaded", function() {
            const dropdown = document.getElementById('userDropdown');
            const dropdownToggle = document.getElementById('dropdownToggle');
            
            if (dropdown && dropdownToggle) {
                dropdownToggle.addEventListener("click", function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dropdown.classList.toggle("active");
                });
                
                // Close when clicking outside
                document.addEventListener("click", function(e) {
                    if (!dropdown.contains(e.target)) {
                        dropdown.classList.remove("active");
                    }
                });
            }
        });

        // Fungsi toggle dropdown (bisa dipanggil dari inline onclick)
        function toggleDropdown(event) {
            event.preventDefault();
            event.stopPropagation();
            const dropdown = event.target.closest('.dropdown');
            if (dropdown) {
                dropdown.classList.toggle("active");
                console.log("Dropdown toggled:", dropdown.classList.contains("active"));
            }
        }

        // Dropdown functionality dengan multiple metode
        document.addEventListener("DOMContentLoaded", function() {
            console.log("DOM Loaded - Starting dropdown setup");
            
            const dropdown = document.querySelector(".dropdown");
            console.log("Dropdown found:", dropdown);
            
            if (dropdown) {
                const link = dropdown.querySelector(".login-link");
                console.log("Login link found:", link);
                
                if (link) {
                    // Metode 1: addEventListener
                    link.addEventListener("click", function(e) {
                        console.log("Link clicked via addEventListener");
                        e.preventDefault();
                        e.stopPropagation();
                        dropdown.classList.toggle("active");
                        console.log("Classes after toggle:", dropdown.className);
                    }, true); // use capture phase
                    
                    // Metode 2: onclick langsung (backup)
                    link.onclick = function(e) {
                        console.log("Link clicked via onclick");
                        e.preventDefault();
                        e.stopPropagation();
                        dropdown.classList.toggle("active");
                        return false;
                    };
                }
            } else {
                console.error("Dropdown element not found!");
            }

            // Tutup dropdown saat klik di luar
            document.addEventListener("click", function(e) {
                const dropdown = document.querySelector(".dropdown");
                if (dropdown && !dropdown.contains(e.target)) {
                    console.log("Clicked outside - closing dropdown");
                    dropdown.classList.remove("active");
                }
            });
        });

        // Navbar scroll effect
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
    </script>
</body>

</html>