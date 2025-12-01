<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer SCENT ATELIER</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/footer.css') }}">

</head>

<body>
    <footer class="max-w-8xl mx-auto bg-stone-900 text-stone-300 pt-6 pb-4 px-4">
        <div class="container mx-auto px-4 pt-12 pb-8 border-b border-stone-700">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                <div>
                    <h4 class="footer-title text-amber-500 mb-3 tracking-wider">
                        SCENT ATELIER
                    </h4>
                    <p class="footer-text text-stone-400 leading-relaxed">
                        Menciptakan aroma yang menceritakan kisah Anda sejak 2020.
                    </p>
                </div>

                <div class="text-left ml-0 md:ml-0 lg:ml-0">
                    <h4 class="footer-subtitle text-white mb-3">Link Cepat</h4>
                    <ul class="space-y-2">
                        <li><a href="#about" class="footer-link hover:text-amber-500 transition duration-300">Tentang Kami</a></li>
                        <li><a href="#" class="footer-link hover:text-amber-500 transition duration-300">Koleksi</a></li>
                        <li><a href="#" class="footer-link hover:text-amber-500 transition duration-300">Cara Pesan</a></li>
                        <li><a href="#" class="footer-link hover:text-amber-500 transition duration-300">Blog</a></li>
                    </ul>
                </div>

                <div class="flex flex-col items-start ml-0 md:ml-0 lg:ml-4">
                    <h4 class="footer-subtitle text-white mb-3">Kontak</h4>
                    <ul class="space-y-2">
                        <li class="flex items-center gap-2 footer-text">
                            <i class="fa fa-map-marker text-white"></i>
                            <span>Banyumas, Jawa Tengah</span>
                        </li>
                        <li class="flex items-center gap-2 footer-text">
                            <i class="fa fa-phone text-white"></i>
                            <span>085865674959</span>
                        </li>
                        <li class="flex items-center gap-2 footer-text">
                            <i class="fa fa-envelope text-white"></i>
                            <span>hello@scentartatelier.id</span>
                        </li>
                    </ul>
                </div>

                <div class="flex flex-col items-start ml-0 md:ml-0 lg:ml-4">
                    <h4 class="footer-subtitle text-white mb-3">Ikuti Kami</h4>
                    <div class="flex space-x-3">
                        <a href="#"
                            class="w-10 h-10 flex items-center justify-center bg-stone-700 hover:bg-amber-600 rounded-full transition duration-300 social-icon">
                            <i class="fa fa-instagram text-white"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 flex items-center justify-center bg-stone-700 hover:bg-amber-600 rounded-full transition duration-300 social-icon">
                            <i class="fa fa-facebook text-white"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 flex items-center justify-center bg-stone-700 hover:bg-amber-600 rounded-full transition duration-300 social-icon">
                            <i class="fa fa-envelope text-white"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <div class="container mx-auto px-10 py-6 text-center text-stone-400">
            <p class="footer-text text-[15px]">© 2023 scentartatelier.id - Semua hak dilindungi. Hubungi kami untuk konsultasi parfum pribadi.</p>
        </div>
    </footer>
    
</body>

</html>
