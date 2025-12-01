<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Scent Atelier</title>
    <script src="https://kit.fontawesome.com/a2e0e9c6b1.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
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

    <section class="bg-[#fbf7f2] py-20">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-2xl font-semibold text-amber-800">Nilai-Nilai Kami</h2>
                <div class="w-24 h-1 bg-amber-400 mx-auto mt-2"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 values-grid">
                <div class="bg-white rounded-2xl shadow-md p-6 value-card">
                    <div class="inline-flex p-3 bg-amber-800 text-white rounded-xl mb-4">
                        <i class="fas fa-star"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-amber-800 mb-2">Keahlian Artisan</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Setiap parfum dibuat dengan tangan oleh perfumer berpengalaman lebih dari 20 tahun
                    </p>
                </div>

                <div class="bg-white rounded-2xl shadow-md p-6 value-card">
                    <div class="inline-flex p-3 bg-amber-800 text-white rounded-xl mb-4">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-amber-800 mb-2">Bahan Alami Premium</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Menggunakan esens murni dari seluruh dunia, dipilih dengan teliti untuk kualitas terbaik
                    </p>
                </div>

                <div class="bg-white rounded-2xl shadow-md p-6 value-card">
                    <div class="inline-flex p-3 bg-amber-800 text-white rounded-xl mb-4">
                        <i class="fa fa-thumbs-up"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-amber-800 mb-2">Kualitas Terjamin</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Setiap botol melewati kontrol kualitas ketat dan sertifikasi internasional
                    </p>
                </div>

                <div class="bg-white rounded-2xl shadow-md p-6 value-card">
                    <div class="inline-flex p-3 bg-amber-800 text-white rounded-xl mb-4">
                        <i class="fa fa-user"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-amber-800 mb-2">Konsultasi Personal</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Tim ahli kami siap membantu Anda menemukan aroma yang sempurna untuk kepribadian Anda
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="container mx-auto px-4 py-16">
        <div class="relative rounded-2xl shadow-lg overflow-hidden text-center flex flex-col items-center p-12 cta-box">
            <div class="absolute inset-0 bg-gradient-to-b from-amber-800/95 via-amber-800/85 to-amber-800/90"></div>
            <div class="relative z-10 text-white">
                <i class="fas fa-star text-6xl mb-4"></i>
                <h2 class="text-2xl mb-3 font-semibold">Temukan Aroma Signature Anda</h2>
                <p class="max-w-md mx-auto mb-8 leading-relaxed">
                    Kunjungi atelier kami untuk konsultasi personal gratis
                </p>
                <a href="#"
                    class="inline-flex items-center gap-2 bg-white text-amber-800 font-medium px-6 py-3 rounded-full shadow">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </section>

    <section class="relative bg-amber-800 pt-20 pb-16 overflow-hidden bottom-section">
        <div class="relative container mx-auto px-4 flex flex-col items-center text-center text-amber-100">
            <h3 class="text-white font-medium">Mulai Perjalanan Aroma Anda</h3>

            <p class="text-2xl max-w-2xl mx-auto mb-10 leading-relaxed text-white">
                Temukan parfum signature Anda...
            </p>

            <div class="flex flex-col sm:flex-row justify-center items-center gap-4 bottom-buttons">
                <a href="#"
                    class="inline-block bg-white text-amber-800 font-medium px-6 py-3 rounded-full shadow">
                    Jelajahi Koleksi
                </a>
                <a href="#"
                    class="inline-block border border-white text-white font-medium px-6 py-3 rounded-full shadow">
                    Konsultasi Gratis
                </a>
            </div>
        </div>
    </section>
</body>

</html>
