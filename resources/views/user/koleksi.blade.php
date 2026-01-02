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
    @php
        $productData = $products->map(function ($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'image' => asset('storage/' . $p->image),
                'brand' => $p->brand,
                'category' => $p->category,
                'display_price' => $p->display_price,
                'display_stok' => $p->display_stok,
                'action' => route('user.cart.add', $p->id),
                'variants' => $p->variants->map(function ($v) {
                    return [
                        'id' => $v->id,
                        'variant_name' => $v->variant_name,
                        'price' => $v->price,
                        'stok' => $v->stok,
                    ];
                })->values(),
            ];
        });
    @endphp
    <div x-data="productModal({{ $productData->toJson() }})">

        <!-- Hero Section -->
        <div
            class="relative h-[50vh] bg-gradient-to-b from-[#955530] to-[#b87333] text-white flex flex-col items-center justify-center text-center px-6 mt-9">
            <a href="{{ route('landingpage') }}"
                class="absolute top-12 left-6 flex items-center gap-2 text-white hover:underline font-semibold"
                style="font-family: 'Playfair Display', serif;">
                <i class="fa-solid fa-arrow-left"></i>
                Kembali ke Beranda
            </a>

            <div class="max-w-3xl" data-aos="fade-up" data-aos-duration="900">
                <h1 class="text-2xl font-semibold mb-4" style="font-family: 'Playfair Display', serif;">Koleksi Premium Kami
                </h1>
                <div class="w-24 h-[2px] mx-auto bg-gradient-to-r from-transparent via-yellow-200 to-transparent mb-6">
                </div>
                <p class="text-lg leading-relaxed text-[#f4e4d0]" style="font-family: 'Playfair Display', serif;">
                    Jelajahi koleksi parfum designer terbaik dari brand-brand ternama dunia.
                    Setiap aroma dipilih khusus untuk memberikan pengalaman wangi yang tak terlupakan.
                </p>
            </div>
        </div>

        <!-- Search & Filter -->
        <div class="max-w-7xl mx-auto px-4 mt-8" style="font-family: 'Inter', sans-serif;">
            <form method="GET" action="{{ route('koleksi') }}"
                class="bg-white rounded-2xl shadow-md p-4 flex flex-col sm:flex-row gap-3 items-center">

                <!-- Search Input -->
                <div class="relative w-full sm:flex-1">
                    <i class="fa fa-search absolute left-4 top-1/2 -translate-y-1/2 text-amber-700"></i>
                    <input type="text" name="search" placeholder="Cari notes parfum (vanilla, woody, floral...)"
                        value="{{ request('search') }}"
                        class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-700 focus:border-amber-700 outline-none transition">
                </div>

                <!-- Category Filter -->
                <div class="relative w-full sm:w-56">
                    <i class="fa fa-layer-group absolute left-4 top-1/2 -translate-y-1/2 text-amber-700"></i>
                    <select name="category"
                        class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-700 focus:border-amber-700 outline-none transition appearance-none bg-white">
                        <option value="">Semua Kategori</option>

                        @foreach ($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                {{ ucfirst($category) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full sm:w-auto bg-amber-800 hover:bg-amber-700 text-white font-semibold px-6 py-3 rounded-xl transition shadow-md hover:shadow-lg">
                    Cari Koleksi
                </button>

            </form>
        </div>




        <!-- Product Grid -->
        <div class="p-3 max-w-7xl mx-auto px-4 grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-10">
            @foreach ($products as $product)
                <div
                    class="bg-white rounded-2xl shadow-md overflow-visible relative transform transition duration-300 ease-in-out hover:shadow-xl hover:-translate-y-1">
                    <span
                        class="absolute top-3 left-3 bg-amber-800 text-white px-4 py-1.5 rounded-full text-xs font-medium z-10 shadow-md">
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
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                            class="rounded-2xl w-full h-56 object-cover transform transition duration-300 ease-in-out hover:scale-105">
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
                                <span
                                    class="text-gray-700">{{ implode(', ', $product->notes['heart_notes'] ?? []) }}</span>
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
                            <button type="button" @click="openProduct({{ $product->id }})"
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

        @php
            $isUser = Auth::guard('web')->check();
            $isAdmin = Auth::guard('admin')->check();
        @endphp
        @if ($isUser && !$isAdmin)
            <div x-show="openVariantModal" x-cloak
                class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50"
                style="font-family: 'Inter', sans-serif;" @click.self="closeModal()">

                <div class="bg-white w-full max-w-md rounded-2xl shadow-xl p-6 relative font-inter">
                    <h2 class="text-xl font-semibold mb-4 text-gray-800" x-text="selectedProduct?.name || 'Pilih Varian'"></h2>

                    <form method="POST" :action="selectedProduct?.action || ''">
                        @csrf

                        <template x-if="selectedProduct && selectedProduct.variants.length">
                            <div class="grid grid-cols-2 gap-4">
                                <template x-for="variant in selectedProduct.variants" :key="variant.id">
                                    <label
                                        class="border rounded-xl p-4 transition flex flex-col gap-1"
                                        :class="variant.stok === 0 ? 'bg-gray-100 opacity-60 cursor-not-allowed' : 'cursor-pointer hover:bg-gray-50'">

                                        <input type="radio" name="variant_id" :value="variant.id"
                                            class="accent-amber-700 w-4 h-4 mb-1"
                                            x-model="selectedVariant"
                                            @change="selectPrice(variant.price)"
                                            :disabled="variant.stok === 0" required>

                                        <p class="font-semibold text-gray-800 text-sm" x-text="variant.variant_name"></p>

                                        <p class="text-xs text-gray-500">
                                            <span x-show="variant.stok > 0" x-text="'Stok: ' + variant.stok"></span>
                                            <span x-show="variant.stok === 0" class="text-red-600 font-semibold">Habis</span>
                                        </p>

                                        <p class="text-sm font-semibold mt-1"
                                            :class="variant.stok === 0 ? 'text-gray-400' : 'text-amber-700'"
                                            x-text="'Rp ' + Number(variant.price).toLocaleString('id-ID')"></p>
                                    </label>
                                </template>
                            </div>
                        </template>

                        <p class="text-center text-gray-500" x-show="selectedProduct && !selectedProduct.variants.length">
                            Varian produk belum tersedia
                        </p>

                        <div class="mt-5" x-show="selectedPrice">
                            <p class="text-lg font-semibold text-amber-700">
                                Harga:
                                <span x-text="'Rp ' + selectedPrice.toLocaleString('id-ID')"></span>
                            </p>
                        </div>

                        <div class="flex justify-end mt-6 gap-3">
                            <button type="button" @click="closeModal()"
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
        @endif

        <div class="max-w-7xl mx-auto px-4 mt-10 mb-10" data-aos="fade-up" data-aos-duration="900">
            <div class="bg-gradient-to-r from-[#8B5A3C] via-[#A0613C] to-[#8B5A3C] rounded-3xl shadow-lg p-12 text-center text-white"
                style="font-family: 'Playfair Display', serif;">
                <h2 class="text-3xl font-semibold mb-4">Butuh Bantuan Memilih?</h2>
                <p class="text-lg mb-8 leading-relaxed max-w-2xl mx-auto">
                    Tim ahli kami siap membantu Anda menemukan parfum yang sempurna sesuai kepribadian<br>dan preferensi
                    Anda
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
        function productModal(products) {
            return {
                openVariantModal: false,
                selectedPrice: null,
                selectedProduct: null,
                selectedVariant: null,
                products: products,
                openProduct(id) {
                    const product = this.products.find(p => p.id === id);
                    if (product) {
                        this.selectedProduct = product;
                        const available = product.variants.find(v => Number(v.stok) > 0);
                        this.selectedVariant = available ? available.id : null;
                        this.selectedPrice = available ? Number(available.price) : null;
                        this.openVariantModal = true;
                    }
                },
                selectPrice(price) {
                    this.selectedPrice = Number(price);
                },
                closeModal() {
                    this.openVariantModal = false;
                    this.selectedProduct = null;
                    this.selectedPrice = null;
                    this.selectedVariant = null;
                }
            };
        }
    </script>
@endsection
