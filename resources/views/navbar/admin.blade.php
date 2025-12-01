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
    <nav class="navbar" id="navbar">
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

                @auth('admin')
                    <!-- DESKTOP -->
                    <li class="nav-desktop dropdown relative flex items-center gap-4">
                        <a href="#" class="login-link flex items-center gap-2">
                            <i class="fa fa-shield"></i> Admin
                        </a>

                        <ul class="dropdown-menu absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg hidden z-50">
                            <li class="dropdown-header px-4 py-2 font-bold border-b">Admin Menu</li>

                            <li>
                                <a href="{{ route('admin.dashboard.index') }}"
                                    class="block px-4 py-2 hover:bg-amber-100 hover:text-amber-600 flex items-center gap-2">
                                    <i class="fa fa-cube"></i> Inventory Management
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
                    </li>

                    <!-- MOBILE -->
                    <li class="nav-mobile">
                        <a href="{{ route('admin.dashboard.index') }}" class="block py-2 font-semibold text-amber-700">
                           <i class="fa fa-shield"></i>Dashboard Admin
                        </a>
                    </li>

                    <li class="nav-mobile">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left py-2 text-red-600 font-semibold">
                                <i class="fa fa-sign-out"></i>Keluar
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
