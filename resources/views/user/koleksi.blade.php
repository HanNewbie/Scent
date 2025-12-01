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

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/product.css') }}">
@endpush

@section('content')
<div x-data="{ 
    openVariantModal: false, 
    selectedPrice: null,
    selectedProduct: null,
    variants: []
}">

    <!-- Hero Section -->
    <div class="relative h-[50vh] bg-gradient-to-b from-[#955530] to-[#b87333] text-white flex flex-col items-center justify-center text-center px-6 mt-9">
        <a href="{{ route('landingpage') }}"
            class="absolute top-12 left-6 flex items-center gap-2 text-white hover:underline font-semibold"
            style="font-family: 'Playfair Display', serif;">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke Beranda
        </a>

        <div class="max-w-3xl" data-aos="fade-up" data-aos-duration="900">
            <h1 class="text-2xl font-semibold mb-4" style="font-family: 'Playfair Display', serif;">Koleksi Premium Kami</h1>
            <div class="w-24 h-[2px] mx-auto bg-gradient-to-r from-transparent via-yellow-200 to-transparent mb-6"></div>
            <p class="text-lg leading-relaxed text-[#f4e4d0]" style="font-family: 'Playfair Display', serif;">
                Jelajahi koleksi parfum designer terbaik dari brand-brand ternama dunia.
                Setiap aroma dipilih khusus untuk memberikan pengalaman wangi yang tak terlupakan.
            </p>
        </div>
    </div>

    <!-- Product Grid -->
    <div class="p-3 max-w-7xl mx-auto px-4 grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-10">
        @foreach ($products as $product)
            <div class="bg-white rounded-2xl shadow-md overflow-visible relative transform transition duration-300 ease-in-out hover:shadow-xl hover:-translate-y-1">                
                <span class="absolute top-3 left-3 bg-amber-800 text-white px-4 py-1.5 rounded-full text-xs font-medium z-10 shadow-md">
                    {{ $product->category }}
                </span>
                @php $isUser = Auth::guard('web')->check(); @endphp
                @if ($isUser)
                    <form action="{{ route('user.favorites.toggle', $product->id) }}" method="POST"
                        class="absolute top-3 right-3 z-10">
                        @csrf
                        <button type="submit"
                            class="bg-white rounded-full w-10 h-10 flex items-center justify-center shadow-md hover:shadow-lg transition duration-200">
                            @if (auth()->user()->favorites->contains('product_id', $product->id))
                                <i class="fa fa-heart text-red-500 text-lg"></i>
                            @else
                                <i class="fa fa-heart text-gray-400 text-lg hover:text-red-500"></i>
                            @endif
                        </button>
                    </form>
                @endif

                <div class="rounded-2xl overflow-hidden">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="rounded-2xl w-full h-56 object-cover transform transition duration-300 ease-in-out hover:scale-105">
                </div>

                <!-- Product Info -->
                <div class="p-4">
                    <p class="text-yellow-500 text-sm font-semibold mb-1 uppercase tracking-wide font-playfair">
                        {{ $product->brand }}
                    </p>
                    <h3 class="text-lg font-semibold text-amber-900 mb-3 font-playfair">
                        {{ $product->name }}
                    </h3>

                    <!-- Notes -->
                    <div class="mb-2 font-inter">
                        <p class="text-xs text-gray-600">
                            <span class="font-semibold text-amber-800">Top Notes:</span>
                            <span class="text-gray-700">{{ implode(', ', $product->notes['top_notes'] ?? []) }}</span>
                        </p>
                    </div>
                    <div class="mb-2 font-inter">
                        <p class="text-xs text-gray-600">
                            <span class="font-semibold text-amber-800">Heart Notes:</span>
                            <span class="text-gray-700">{{ implode(', ', $product->notes['heart_notes'] ?? []) }}</span>
                        </p>
                    </div>
                    <div class="mb-4 font-inter">
                        <p class="text-xs text-gray-600">
                            <span class="font-semibold text-amber-800">Base Notes:</span>
                            <span class="text-gray-700">{{ implode(', ', $product->notes['base_notes'] ?? []) }}</span>
                        </p>
                    </div>

                    <!-- Variants (compact display) -->
                    <div class="space-y-2 font-inter mb-4">
                        @foreach ($product->variants as $variant)
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600 text-sm font-medium">{{ $variant->variant_name }}</span>
                                <p class="text-amber-900 font-bold text-lg">
                                    Rp {{ number_format($variant->price, 0, ',', '.') }}
                                </p>
                            </div>
                        @endforeach
                    </div>

                    <!-- Add to Cart Button -->
                    @php
                        $isUser = Auth::guard('web')->check();
                        $isAdmin = Auth::guard('admin')->check();
                    @endphp

                    @if ($isUser && !$isAdmin)
                        <button type="button" 
                            @click="
                                selectedProduct = {{ $product->id }};
                                variants = {{ $product->variants->toJson() }};
                                openVariantModal = true;
                                selectedPrice = null;
                            "
                            class="w-full bg-amber-800 hover:bg-amber-700 text-white font-medium py-2 px-4 rounded-lg transition mt-4
                            {{ $product->display_stok <= 0 ? 'opacity-50 cursor-not-allowed hover:bg-amber-800' : '' }}"
                            {{ $product->display_stok <= 0 ? 'disabled' : '' }}>
                            <i class="fa fa-cart-plus"></i>
                            Tambahkan ke Keranjang
                        </button>
                    @elseif(!$isUser && !$isAdmin)
                        <a href="{{ route('login') }}">
                            <button type="button"
                                class="w-full bg-amber-800 hover:bg-amber-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300 mt-4
                                {{ $product->display_stok <= 0 ? 'opacity-50 cursor-not-allowed hover:bg-amber-800' : '' }}"
                                {{ $product->display_stok <= 0 ? 'disabled' : '' }}>
                                <i class="fa fa-cart-plus"></i>
                                Tambahkan ke Keranjang
                            </button>
                        </a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

        @isset($product)
            <div x-show="openVariantModal" x-cloak
                class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50"
                style="font-family: 'Inter', sans-serif;">

                <div class="bg-white w-full max-w-md rounded-2xl shadow-xl p-6 relative font-inter">
                    <h2 class="text-xl font-semibold mb-4 text-gray-800">Pilih Varian</h2>

                    <form method="POST" action="{{ route('user.cart.add', $product->id) }}">
                        @csrf

                        @if ($product->variants->count())
                            <div class="grid grid-cols-2 gap-4">
                                @foreach ($product->variants as $variant)
                                    <label
                                        class="border rounded-xl p-4 transition flex flex-col gap-1
                                        {{ $variant->stok == 0 ? 'bg-gray-100 opacity-60 cursor-not-allowed' : 'cursor-pointer hover:bg-gray-50' }}">

                                        <input type="radio" name="variant_id" value="{{ $variant->id }}"
                                            class="accent-amber-700 w-4 h-4 mb-1"
                                            @click="selectedPrice = {{ $variant->price }}"
                                            {{ $variant->stok == 0 ? 'disabled' : '' }} required>

                                        <p class="font-semibold text-gray-800 text-sm">
                                            {{ $variant->variant_name }}
                                        </p>

                                        <p class="text-xs text-gray-500">
                                            @if ($variant->stok > 0)
                                                Stok: {{ $variant->stok }}
                                            @else
                                                <span class="text-red-600 font-semibold">Habis</span>
                                            @endif
                                        </p>

                                        <p
                                            class="text-sm font-semibold mt-1
                                            {{ $variant->stok == 0 ? 'text-gray-400' : 'text-amber-700' }}">
                                            Rp {{ number_format($variant->price, 0, ',', '.') }}
                                        </p>
                                    </label>
                                @endforeach
                            </div>
                        @else
                            <p class="text-center text-gray-500">
                                Varian produk belum tersedia
                            </p>
                        @endif

                        <div class="mt-5" x-show="selectedPrice">
                            <p class="text-lg font-semibold text-amber-700">
                                Harga:
                                <span x-text="'Rp ' + selectedPrice.toLocaleString('id-ID')"></span>
                            </p>
                        </div>

                        <div class="flex justify-end mt-6 gap-3">
                            <button type="button" @click="openVariantModal = false"
                                class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition">
                                Batal
                            </button>

                            <button type="submit"
                                class="px-4 py-2 rounded-lg bg-amber-700 text-white hover:bg-amber-800 transition">
                                Tambahkan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endisset

    <div class="max-w-7xl mx-auto px-4 mt-10 mb-10" data-aos="fade-up" data-aos-duration="900">
        <div class="bg-gradient-to-r from-[#8B5A3C] via-[#A0613C] to-[#8B5A3C] rounded-3xl shadow-lg p-12 text-center text-white"
            style="font-family: 'Playfair Display', serif;">
            <h2 class="text-3xl font-semibold mb-4">Butuh Bantuan Memilih?</h2>
            <p class="text-lg mb-8 leading-relaxed max-w-2xl mx-auto">
                Tim ahli kami siap membantu Anda menemukan parfum yang sempurna sesuai kepribadian<br>dan preferensi Anda
            </p>
            <a href="{{ route('contact') }}"
                class="inline-block bg-white text-[#8B5A3C] font-semibold px-8 py-4 rounded-full hover:bg-gray-100 transition duration-300 shadow-md">
                Konsultasi dengan Ahli Kami
            </a>
        </div>
    </div>

    <div class="mt-10">
        @include('layouts.footer')
    </div>
</div>

 <script>
        const forms = document.querySelectorAll('.add-to-cart-form');
        const container = document.getElementById('notification-container');

        forms.forEach(form => {
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                const url = form.action;
                const token = form.querySelector('input[name="_token"]').value;

                try {
                    const res = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({})
                    });

                    const data = await res.json();
                    showNotification(data.message, data.status);

                } catch (error) {
                    showNotification('Terjadi kesalahan!', 'error');
                }
            });
        });

        function showNotification(message, type = 'success') {
            const notif = document.createElement('div');
            notif.innerHTML = message;
            notif.className = `
        px-4 py-3 rounded-lg shadow-md text-white font-medium
        ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}
        transform transition-all duration-300 ease-in-out`;
            notif.style.opacity = '0';
            notif.style.transform = 'translateY(20px)';
            container.appendChild(notif);

            setTimeout(() => {
                notif.style.opacity = '1';
                notif.style.transform = 'translateY(0)';
            }, 10);

            setTimeout(() => {
                notif.style.opacity = '0';
                notif.style.transform = 'translateY(20px)';
                setTimeout(() => notif.remove(), 300);
            }, 3000);
        }
    </script>
@endsection