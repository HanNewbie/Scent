<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Koleksi Parfum</title>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-[#fbf7f2]">
    @php
        $productData = $products->map(function ($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'variants' => $p->variants->map(function ($v) {
                    return [
                        'id' => $v->id,
                        'variant_name' => $v->variant_name,
                        'price' => $v->price,
                        'stok' => $v->stok,
                    ];
                })->values(),
                'action' => route('user.cart.add', $p->id),
            ];
        });
    @endphp

    <section id="products" class="py-16 bg-[#fbf7f2]"
        x-data="productModal({{ $productData->toJson() }})">
        @php
            $isWebUser = Auth::guard('web')->check();
            $isAdmin = Auth::guard('admin')->check();
        @endphp
        <div class="max-w-7xl mx-auto px-4 text-center mb-10">
            <h2 class="text-2xl md:text-3xl font-semibold text-amber-800 mb-2">Koleksi Parfum Kami</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-amber-700 to-yellow-300 mx-auto mb-4 rounded-full"></div>
            <p class="text-gray-700 text-base md:text-lg">
                Eksplorasi <span class="font-semibold">{{ $products->count() }} koleksi parfum premium</span>
            </p>
        </div>

        <div class="max-w-7xl mx-auto px-4 grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"
            data-aos="fade-up" data-aos-duration="900">
            @foreach ($products as $product)
                <div
                    class="bg-white rounded-2xl shadow-md overflow-hidden relative transform transition duration-300 ease-in-out hover:shadow-xl hover:-translate-y-1">
                    <span
                        class="absolute top-2 left-2 bg-amber-100 text-amber-800 px-3 py-1 rounded-full text-xs font-medium z-10">
                        {{ $product->category }}
                    </span>
                    <span
                        class="absolute top-2 right-2 px-3 py-1 rounded-full text-xs font-medium
                        @if ($product->display_stok > 10) bg-green-500 text-white
                        @elseif ($product->display_stok > 0) bg-yellow-300 text-yellow-800
                        @else bg-red-500 text-white @endif z-10">

                        @if ($product->display_stok > 10)
                            Tersedia
                        @elseif ($product->display_stok > 0)
                            Sedikit
                        @else
                            Habis
                        @endif
                    </span>

                    <div class="overflow-hidden">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                            class="w-full h-56 object-cover transform transition duration-300 ease-in-out hover:scale-105">
                    </div>

                    <div class="p-4">
                        <h3 class="text-xl font-semibold text-amber-900 mb-1">{{ $product->name }}</h3>
                        <p class="text-sm text-gray-500 mb-2">
                            <i class="fa fa-box"></i> {{ $product->brand }}
                        </p>
                        <p class="text-amber-900 font-semibold text-xl mb-4" style= "font-inter;">
                            Rp {{ number_format($product->display_price, 0, ',', '.') }}
                        </p>

                        @if ($isWebUser && !$isAdmin)
                            <button type="button" @click="openProduct({{ $product->id }})"
                                class="w-full bg-amber-800 hover:bg-amber-700 text-white font-medium py-2 px-4 rounded-lg transition
            {{ $product->display_stok <= 0 ? 'opacity-50 cursor-not-allowed hover:bg-amber-800' : '' }}"
                                {{ $product->display_stok <= 0 ? 'disabled' : '' }}>
                                <i class="fa fa-cart-plus"></i>
                                Tambahkan ke Keranjang
                            </button>
                        @elseif(!$isWebUser && !$isAdmin)
                            <a href="{{ route('login') }}">
                                <button type="button"
                                    class="w-full bg-amber-800 hover:bg-amber-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300 
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

        <!-- Modal Variant - posisi seperti sebelumnya (di luar loop) -->
        @if ($isWebUser && !$isAdmin)
            <div x-show="openVariantModal" x-cloak
                class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50"
                style="font-family: 'Inter', sans-serif;" @click.self="closeModal()">

                <div class="bg-white w-full max-w-md rounded-2xl shadow-xl p-6 relative font-inter">
                    <h2 class="text-xl font-semibold mb-4 text-gray-800">Pilih Varian</h2>

                    <form class="add-to-cart-form" method="POST" :action="selectedProduct?.action || ''">
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

    </section>
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
</body>

</html>
