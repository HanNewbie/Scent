@extends('layouts.app')

@section('navbar')
    @php
        $isAdmin = Auth::guard('admin')->check();
    @endphp

    @if ($isAdmin)
        @include('layouts.navbar-admin')
    @else
        @include('layouts.navbar-user')
    @endif
@endsection

@section('content')
    <div class="contact-section">
        <div class="contact-hero" style="background-image: url('{{ asset('assets/img/parfum.jpg') }}');">
            <div class="contact-overlay">
                <h1 class="contact-title">Hubungi Kami</h1>
                <div class="contact-title-underline"></div>
                <p class="contact-subtitle">Kami siap membantu Anda menemukan aroma yang sempurna. Hubungi tim expert kami
                    hari ini!</p>
            </div>
        </div>

        <div class="contact-cards-container" data-aos="fade-up" data-aos-duration="900">
            <div class="contact-card">
                <div class="contact-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                        </path>
                    </svg>
                </div>
                <h3 class="contact-card-title text-amber-800">Telepon</h3>
                <p class="contact-card-content">083136440321</p>
            </div>

            <div class="contact-card">
                <div class="contact-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                </div>
                <h3 class="contact-card-title text-amber-800">Email</h3>
                <p class="contact-card-content">info@scentartelier.id</p>
            </div>

            <div class="contact-card">
                <div class="contact-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                </div>
                <h3 class="contact-card-title text-amber-800">Jam Operasional</h3>
                <p class="contact-card-content">09:00 - 21:00 WIB</p>
            </div>

            <div class="contact-card">
                <div class="contact-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                </div>
                <h3 class="contact-card-title text-amber-800">Lokasi</h3>
                <p class="contact-card-content">Purwokerto, Jawa Tengah</p>
            </div>
        </div>
    </div>

    <div class="contact-content-wrapper">
        <div class="contact-form-section">
            <h2 class="form-section-title">Kirim Pesan</h2>
            <form class="contact-form" onsubmit="return false;">
                @csrf
                <div class="form-group">
                    <label for="name" class="form-label">Nama Lengkap <span class="required">*</span></label>
                    <input type="text" id="name" name="name" class="form-input" placeholder="Masukkan nama Anda"
                        required>
                </div>
                <div class="form-row">
                    <div class="form-group form-group-half">
                        <label for="email" class="form-label">Email <span class="required">*</span></label>
                        <input type="email" id="email" name="email" class="form-input"
                            placeholder="email@example.com" required>
                    </div>
                    <div class="form-group form-group-half">
                        <label for="phone" class="form-label">No. Telepon <span class="required">*</span></label>
                        <input type="tel" id="phone" name="phone" class="form-input"
                            placeholder="+62 812 3456 7890" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="subject" class="form-label">Subjek</label>
                    <input type="text" id="subject" name="subject" class="form-input"
                        placeholder="Perihal pesan Anda">
                </div>
                <div class="form-group">
                    <label for="message" class="form-label">Pesan <span class="required">*</span></label>
                    <textarea id="message" name="message" class="form-textarea" rows="5"
                        placeholder="Tulis pesan Anda di sini..." required></textarea>
                </div>
                <button type="button" id="sendWA" class="form-submit-btn">
                    <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                    Kirim Pesan
                </button>
                <div id="formError" class="text-red-600 mt-2"></div>
            </form>

        </div>

        <div class="faq-section">
            <h2 class="faq-section-title">Pertanyaan Umum</h2>

            <div class="faq-item" data-aos="fade-up" data-aos-duration="900">
                <h3 class="faq-question">Bagaimana cara membuat janji konsultasi?</h3>
                <p class="faq-answer">Anda dapat membuat janji melalui form di bawah atau menghubungi langsung store
                    terdekat. Tim kami akan menghubungi Anda dalam 24 jam.</p>
            </div>

            <div class="faq-item" data-aos="fade-up" data-aos-duration="900">
                <h3 class="faq-question">Apakah bisa custom parfum?</h3>
                <p class="faq-answer">Ya! Kami menyediakan layanan custom parfum dengan konsultasi langsung bersama
                    perfumer expert kami. Booking minimal 3 hari sebelumnya.</p>
            </div>

            <div class="faq-item" data-aos="fade-up" data-aos-duration="900">
                <h3 class="faq-question">Berapa lama proses pengiriman?</h3>
                <p class="faq-answer">Untuk area Banyumas dan sekitarnya 1-2 hari kerja. Luar kota 2-4 hari kerja.
                    Pengiriman express juga tersedia.</p>
            </div>

            <div class="faq-item" data-aos="fade-up" data-aos-duration="900">
                <h3 class="faq-question">Apakah ada garansi produk?</h3>
                <p class="faq-answer">Semua produk kami 100% original dengan garansi uang kembali jika terbukti palsu.
                    Retur dapat dilakukan dalam 7 hari jika seal masih utuh.</p>
            </div>
        </div>
    </div>

    <div class="social-section" style="text-align:center;">
        <h2 class="social-title">Ikuti Kami</h2>
        <div class="social-title-underline" style="margin: 0 auto;"></div>
        <p class="social-subtitle">Dapatkan update terbaru dan promo eksklusif</p>

        <div class="social-cards-container" style="display:flex; justify-content:center; gap:20px; flex-wrap:wrap;">
            <a href="https://instagram.com/scentartatelier" target="_blank" class="social-card social-instagram"
                style="text-align:center; width:230px; padding:20px;">
                <i class="fa fa-instagram fa-2x" aria-hidden="true"></i>
                <h3 class="social-platform">Instagram</h3>
                <p class="social-handle">@scentartatelier</p>
            </a>

            <a href="https://wa.me/6283136440321" target="_blank" class="social-card social-whatsapp"
                style="text-align:center; width:230px; padding:20px;">
                <i class="fa fa-whatsapp fa-2x" aria-hidden="true"></i>
                <h3 class="social-platform">WhatsApp</h3>
                <p class="social-handle">6283136440321</p>
            </a>
        </div>
    </div>

    <section class="store-section" style="margin-top:70px;">
        <h2 class="text-center text-3xl font-semibold mb-2 text-amber-800">Kunjungi Store Kami</h2>
        <div class="w-24 h-1 bg-yellow-600 mx-auto mb-4"></div>
        <p class="text-center mb-10 text-gray-600">
            Temukan lokasi kami dan rasakan pengalaman berbelanja yang eksklusif
        </p>

        <div
            class="max-w-3xl mx-auto bg-white shadow-xl hover:shadow-2xl transition-shadow duration-300 rounded-lg overflow-hidden group">
            <div class="store-image relative overflow-hidden">
                <img src="{{ asset('assets/img/parfum.jpg') }}" alt="Store Image"
                    class="w-full h-64 object-cover transition-transform duration-500 ease-in-out group-hover:scale-110">

                <h3 class="absolute bottom-4 left-4 text-white drop-shadow-lg">
                    Scent Atelier Purwokerto
                </h3>
            </div>

            <div class="p-6">
                <div class="flex items-start gap-3 mb-3">
                    <span class="text-yellow-700 text-xl"><i class="fa fa-map-marker fa-lg"></i></span>
                    <p class="text-gray-700">
                        Pakembaran, Bancarkembar, Kec. Purwokerto Utara, Kabupaten Banyumas, Jawa Tengah 53121
                    </p>
                </div>

                <div class="flex items-start gap-3 mb-3">
                    <span class="text-yellow-700 text-xl"><i class="fa fa-phone fa-lg"></i></span>
                    <p class="text-gray-700">6283136440321</p>
                </div>

                <div class="flex items-start gap-3 mb-6">
                    <span class="text-yellow-700 text-xl"><i class="fa fa-clock fa-lg"></i></span>
                    <p class="text-gray-700">Senin – Minggu: 09.00 – 21.00</p>
                </div>

                <a href="https://maps.app.goo.gl/CvwFWiCHcdQ7JTt5A" target="_blank"
                    class="block w-full text-center bg-yellow-700 text-white py-3 rounded-lg text-lg hover:bg-yellow-800 transition">
                    <i class="fa fa-map-marker fa-lg"></i> Lihat di Peta
                </a>
            </div>
        </div>
    </section>

    <section class="consult-section max-w-7xl mx-auto mt-12 mb-20 rounded-3xl p-12 text-center text-white"
        style="background: radial-gradient(circle, #a45a2a 0%, #8a4820 40%, #6e3a1a 100%);">

        <h2 class="text-2xl font-semibold mb-4">Butuh Konsultasi Personal?</h2>

        <p class="text-base leading-relaxed max-w-3xl mx-auto mb-8">
            Buat janji dengan perfumer expert kami untuk mendapatkan rekomendasi parfum yang
            sempurna sesuai kepribadian Anda
        </p>

        <a href="#"
            class="inline-flex items-center gap-2 px-6 py-3 bg-white text-[#8a4820] rounded-lg 
              font-medium border border-white hover:bg-transparent hover:text-white 
              transition-all duration-300">

            <i class="fa fa-comment-o" aria-hidden="true"></i>
            Buat Janji Sekarang
        </a>
    </section>

    <div class="mt-10">
        @include('layouts.footer')
    </div>


    <script>
    document.getElementById('sendWA').addEventListener('click', function () {
        let name = document.getElementById('name').value.trim();
        let email = document.getElementById('email').value.trim();
        let phone = document.getElementById('phone').value.trim();
        let subject = document.getElementById('subject').value.trim();
        let message = document.getElementById('message').value.trim();
        let errorDiv = document.getElementById('formError');

        // Reset pesan error
        errorDiv.textContent = '';

        if (!name || !email || !phone || !message) {
            errorDiv.textContent = "Harap isi semua kolom yang wajib diisi. *";
            return;
        }

        let waNumber = "6283136440321";
        let waText =
            "Halo, saya ingin mengirim pesan:%0A%0A" +
            "Nama: " + name + "%0A" +
            "Email: " + email + "%0A" +
            "No. Telepon: " + phone + "%0A" +
            "Subjek: " + (subject ? subject : "-") + "%0A" +
            "Pesan: " + message;

        let waURL = "https://wa.me/" + waNumber + "?text=" + waText;
        window.open(waURL, "_blank");
    });
</script>

@endsection
