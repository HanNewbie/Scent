<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Tentang Scent Atelier</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800, 
            once: true,   
        });
    </script>
</head>

<body class="bg-[#fbf7f2]">

    <section id="about" class="bg-[#fbf7f2] py-20">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <!-- Judul -->
            <div class="text-center mb-12" data-aos="fade-down">
                <h2 class="text-2xl md:text-3xl font-semibold text-amber-800 mb-2">
                    Tentang Scent Atelier
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-amber-700 to-yellow-300 mx-auto mb-4 rounded-full"></div>
                <p class="text-gray-700 text-base md:text-lg leading-relaxed">
                    Kami bukan hanya membuat parfum—kami menciptakan
                    <span class="text-amber-700 font-medium">pengalaman sensorik</span> yang membekas.<br />
                    Setiap tetes adalah karya seni yang menggabungkan tradisi klasik dengan inovasi modern.
                </p>
            </div>

            <!-- Grid Konten Gambar & Teks -->
            <div class="grid md:grid-cols-2 gap-10 items-center">
                <!-- Gambar -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-4">
                        <img src="{{ asset('assets/img/1.png') }}" alt="koleksi parfum"
                            class="rounded-2xl shadow-md hover:scale-105 hover:-translate-y-1 transition-transform duration-500 w-full aspect-square object-cover"
                            data-aos="zoom-in">
                        <img src="{{ asset('assets/img/3.png') }}" alt="studio parfum"
                            class="rounded-2xl shadow-md hover:scale-105 hover:-translate-y-1 transition-transform duration-500 w-full aspect-square object-cover"
                            data-aos="zoom-in" data-aos-delay="100">
                    </div>
                    <div class="flex flex-col gap-4">
                        <img src="{{ asset('assets/img/2.png') }}" alt="botol parfum"
                            class="rounded-2xl shadow-md hover:scale-105 hover:-translate-y-1 transition-transform duration-500 w-full aspect-square object-cover mt-8"
                            data-aos="zoom-in" data-aos-delay="200">
                        <img src="{{ asset('assets/img/4.png') }}" alt="etalase parfum"
                            class="rounded-2xl shadow-md hover:scale-105 hover:-translate-y-1 transition-transform duration-500 w-full aspect-square object-cover"
                            data-aos="zoom-in" data-aos-delay="300">
                    </div>
                </div>

                <!-- Teks -->
                <div class="space-y-6 text-gray-700 leading-relaxed" data-aos="fade-left">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fa fa-heart-o text-amber text-xl"></i>
                            <h3 class="text-lg font-semibold text-amber-800">Cerita Kami</h3>
                        </div>
                        <p>
                            <span class="text-amber-700 font-medium">Scent Atelier</span> lahir dari cinta mendalam
                            terhadap seni parfumeri dan keinginan untuk membawa pengalaman olfaktori berkelas dunia
                            ke Indonesia. Kami percaya bahwa setiap orang memiliki aroma unik yang mencerminkan
                            kepribadiannya.
                        </p>
                        <p>
                            Dengan menggabungkan teknik tradisional Prancis dan bahan-bahan terbaik dari berbagai
                            belahan dunia, kami menciptakan parfum yang tidak hanya harum, tetapi juga menceritakan
                            kisah, membangkitkan emosi, dan meninggalkan kesan mendalam.
                        </p>
                    </div>

                    <!-- Card Filosofi -->
                    <div class="bg-amber-800 text-white rounded-2xl p-6 shadow-md hover:scale-105 transition-transform duration-500"
                        data-aos="fade-up">
                        <div class="flex gap-3 items-start">
                            <i class="fa fa-globe text-white text-xl"></i>
                            <div>
                                <p class="text-lg font-semibold mb-1">
                                    “Aroma adalah kenangan yang paling kuat”
                                </p>
                                <p class="text-amber-200 text-sm">— Filosofi Scent Atelier</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol -->
                    <a href="#"
                        class="inline-flex items-center gap-2 bg-amber-700 hover:bg-amber-800 text-white font-medium px-6 py-3 rounded-full shadow transition-all duration-300 transform hover:scale-105"
                        data-aos="fade-up" data-aos-delay="100">
                        Kunjungi Website Resmi
                        <i class="fa fa-long-arrow-right text-white text-xl"></i>
                    </a>
                </div>
            </div>

            <!-- Statistik / Card Angka -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-16 text-center">
                <div class="bg-white rounded-2xl shadow p-6 hover:scale-105 transition-transform duration-500" data-aos="flip-left">
                    <h4 class="text-2xl font-bold text-amber-800 mb-1">33+</h4>
                    <p class="text-gray-600 text-sm">Koleksi Parfum</p>
                </div>
                <div class="bg-white rounded-2xl shadow p-6 hover:scale-105 transition-transform duration-500" data-aos="flip-left" data-aos-delay="100">
                    <h4 class="text-2xl font-bold text-amber-800 mb-1">15K+</h4>
                    <p class="text-gray-600 text-sm">Pelanggan Setia</p>
                </div>
                <div class="bg-white rounded-2xl shadow p-6 hover:scale-105 transition-transform duration-500" data-aos="flip-left" data-aos-delay="200">
                    <h4 class="text-2xl font-bold text-amber-800 mb-1">20+</h4>
                    <p class="text-gray-600 text-sm">Penghargaan</p>
                </div>
                <div class="bg-white rounded-2xl shadow p-6 hover:scale-105 transition-transform duration-500" data-aos="flip-left" data-aos-delay="300">
                    <h4 class="text-2xl font-bold text-amber-800 mb-1">100%</h4>
                    <p class="text-gray-600 text-sm">Original</p>
                </div>
            </div>

        </div>
    </section>
</div>
</body>

</html>
