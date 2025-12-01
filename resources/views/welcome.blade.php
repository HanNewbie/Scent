<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scent Atelier</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lp.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    
    @if(Auth::guard('admin')->check())
        @include('navbar.admin')
    @else
        @include('navbar.user')
    @endif

    <section class="hero">
        <img src="{{ asset('assets/img/scent.png') }}" alt="Logo Scent Atelier" class="logo-motion">
        <p style="margin-top: 20px; font-size: 25px;">Selamat Datang di Dunia Scent Atelier</p>
        <p style="font-size: 25px; margin-top: 10px;">
            Toko parfum artisanal dari scentartatelier.id - Ciptakan aroma yang menceritakan kisah Anda.
        </p>
    </section>

    @include('layouts.why')
    @include('layouts.products')
    @include('layouts.about')
    @include('layouts.point')
    @include('layouts.footer')

    <script src="{{ asset('js/navbar.js') }}"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const dropdowns = document.querySelectorAll(".dropdown");

            dropdowns.forEach(dropdown => {
                const toggle = dropdown.querySelector("a");
                toggle.addEventListener("click", function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dropdowns.forEach(d => {
                        if (d !== dropdown) d.classList.remove("active");
                    });
                    dropdown.classList.toggle("active");
                });
            });
            document.addEventListener("click", () => {
                dropdowns.forEach(dropdown => dropdown.classList.remove("active"));
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
        const hamburger = document.querySelector('.navbar .hamburger');
        const navLinks = document.querySelector('.nav-links');

        hamburger.addEventListener('click', () => {
            navLinks.classList.toggle('open');
        });
        });
    </script>

</body>

</html>
