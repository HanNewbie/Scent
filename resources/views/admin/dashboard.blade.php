@extends('layouts.navbar-admin')
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard-admin.css') }}">
@endpush

@section('content')

    <body class="bg-[#fdf6f0] text-[#5a3e2b] font-sans pt-10" x-data="inventoryData()">
        <div class="p-10">
            <a href="{{ route('landingpage') }}" class="flex items-center text-lg text-[#9a6238] hover:underline mb-2">←
                Kembali</a>
            <h1 class="text-xl font-semibold text-[#7a4a27]">Inventory Management</h1>
            <p class="text-sm text-[#b28a68]">Kelola stok dan produk parfum Anda</p>
        </div>
        <div class="grid grid-cols-5 gap-4 px-6">
            <div class="bg-white rounded-2xl shadow p-4">
                <p class="text-sm">Total Produk</p>
                <h2 class="text-2xl font-semibold mt-1">{{ $products->count() }}</h2>
            </div>
            <div class="bg-white rounded-2xl shadow p-4">
                <p class="text-sm">In Stock</p>
                <h2 class="text-2xl font-semibold mt-1">{{ $inStock }}</h2>
            </div>
            <div class="bg-white rounded-2xl shadow p-4">
                <p class="text-sm">Low Stock</p>
                <h2 class="text-2xl font-semibold mt-1">{{ $lowStock }}</h2>
            </div>
            <div class="bg-white rounded-2xl shadow p-4">
                <p class="text-sm">Out of Stock</p>
                <h2 class="text-2xl font-semibold mt-1">{{ $outStock }}</h2>
            </div>
            <div class="bg-[#9a6238] text-white rounded-2xl shadow p-4">
                <p class="text-sm">Total Value</p>
                <h2 class="text-lg font-semibold mt-1">Rp {{ number_format($totalValue, 0, ',', '.') }}</h2>
            </div>
        </div>

        <div class="flex justify-end px-10 mt-4 gap-2">
            <button id="btn-inventory" class="bg-[#5a3e2b] text-white px-4 py-2 rounded-lg text-sm hover:bg-[#3e2a1e]">
                📦 Inventory
            </button>
            <button id="btn-orders" class="bg-[#5a3e2b] text-white px-4 py-2 rounded-lg text-sm hover:bg-[#3e2a1e]">
                🗒️ Daftar Pesanan
            </button>
        </div>

        {{-- Tabel Produk --}}
        <div id="section-inventory" class="px-6 mt-6 max-w-8xl mx-auto">
            <div class="flex flex-col bg-white rounded-2xl shadow px-4 py-3 mb-4 gap-3">
                <div class="flex items-center gap-3">
                    <div class="flex items-center flex-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" placeholder="Cari produk, brand, atau SKU..."
                            class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#9a6238]"
                            x-model="search">
                    </div>

                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="flex items-center border border-gray-200 px-3 py-2 rounded-lg text-sm text-[#9a6238] hover:bg-gray-50">
                            <span x-text="statusFilter"></span>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition
                            class="absolute right-0 mt-2 w-40 bg-white border rounded-lg shadow-lg z-50">
                            <ul>
                                <li>
                                    <button @click="statusFilter='Semua Status'; open=false"
                                        class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">Semua Status
                                    </button>
                                </li>
                                <li>
                                    <button @click="statusFilter='In Stock'; open=false"
                                        class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">In Stock
                                    </button>
                                </li>
                                <li>
                                    <button @click="statusFilter='Low Stock'; open=false"
                                        class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">Low Stock
                                    </button>
                                </li>
                                <li>
                                    <button @click="statusFilter='Out of Stock'; open=false"
                                        class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">Out of Stock
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-end mb-4">
                <button @click="addModal = true"
                    class="bg-[#9a6238] text-white px-4 py-2 rounded-lg text-sm hover:bg-[#7c4e2d]">
                    + Tambah Produk
                </button>
            </div>

            <div class="overflow-x-auto bg-white rounded-2xl shadow w-full">
                <table class="w-full text-sm text-left">
                    <thead class="bg-[#f8efe8] text-gray-700">
                        <tr>
                            <th class="px-4 py-3">Produk</th>
                            <th class="px-4 py-3">SKU</th>
                            <th class="px-4 py-3">Kategori</th>
                            <th class="px-4 py-3">Varian</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr class="border-t hover:bg-gray-50 transition"
                                x-show="('{{ strtolower($product->brand . ' ' . $product->name . ' ' . $product->SKU) }}').includes(search.toLowerCase())">
                                <td class="px-4 py-3 flex items-center gap-3">
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                        class="w-14 h-14 object-cover rounded-lg shadow">
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $product->brand }}</p>
                                        <p class="text-gray-600">{{ $product->name }}</p>
                                    </div>
                                </td>
                                <td class="px-4 py-3">{{ $product->SKU }}</td>
                                <td class="px-4 py-3">{{ $product->category }}</td>
                                <td class="px-4 py-3">
                                    <div x-data="{ open: false }">
                                        <button @click="open = !open" class="text-blue-600 text-sm underline">
                                            Lihat Varian ({{ $product->variants->count() }})
                                        </button>
                                        <div x-show="open" x-transition
                                            class="mt-2 bg-gray-100 p-3 rounded-lg space-y-2 text-xs">
                                            @forelse ($product->variants as $variant)
                                                <div class="bg-white p-2 rounded-md shadow-sm flex justify-between">
                                                    <span>{{ $variant->variant_name }}</span>
                                                    <span>Stok: {{ $variant->stok }}</span>
                                                    <span>Rp {{ number_format($variant->price, 0, ',', '.') }}</span>
                                                </div>
                                            @empty
                                                <p class="text-gray-500">Tidak ada varian</p>
                                            @endforelse
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $outVariants = $product->variants
                                            ->filter(fn($v) => intval($v->stok) == 0)
                                            ->pluck('variant_name')
                                            ->toArray();

                                        $lowVariants = $product->variants
                                            ->filter(fn($v) => intval($v->stok) > 0 && intval($v->stok) < 10)
                                            ->pluck('variant_name')
                                            ->toArray();
                                    @endphp

                                    @if (count($outVariants) > 0)
                                        <div class="bg-red-100 text-red-700 px-2 py-0.5 rounded text-[10px] inline-block">
                                            Out of Stock ({{ implode(', ', $outVariants) }})
                                        </div>
                                    @endif

                                    @if (count($lowVariants) > 0)
                                        <div
                                            class="bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded text-[10px] inline-block ml-1">
                                            Low Stock ({{ implode(', ', $lowVariants) }})
                                        </div>
                                    @endif

                                    @if (count($outVariants) == 0 && count($lowVariants) == 0)
                                        <div
                                            class="bg-green-100 text-green-700 px-2 py-0.5 rounded text-[10px] inline-block">
                                            In Stock
                                        </div>
                                    @endif
                                </td>

                                <td class="px-4 py-3 flex gap-2">
                                    <button @click="editProduct({{ $product->id }})"
                                        class="bg-yellow-400 text-white px-3 py-1 rounded-lg text-sm hover:bg-yellow-500">
                                        Edit
                                    </button>
                                    <form action="{{ route('admin.dashboard.destroy', $product->id) }}" method="POST"
                                        @submit.prevent="deleteProduct($event, {{ $product->id }})">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-red-600">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Tambah Produk Modal --}}
        <div x-show="addModal" x-cloak
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 p-4">
            <div class="bg-white rounded-2xl shadow-lg p-6 w-full max-w-lg relative max-h-[85vh] overflow-y-auto my-6 mt-14"
                x-data="{ variants: [{ name: '', stok: '', min_stok: '', price: '' }] }">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Tambah Produk</h2>
                <button @click="addModal = false"
                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">✕</button>
                <form action="{{ route('admin.dashboard.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-2 gap-3">
                        <div class="flex flex-col">
                            <label class="text-sm font-semibold text-gray-700 mb-1">Brand</label>
                            <input type="text" name="brand" placeholder="Brand"
                                class="border rounded px-3 py-2 w-full">
                        </div>
                        <div class="flex flex-col">
                            <label class="text-sm font-semibold text-gray-700 mb-1">Nama Produk</label>
                            <input type="text" name="name" placeholder="Nama Produk"
                                class="border rounded px-3 py-2 w-full">
                        </div>
                        <div class="flex flex-col">
                            <label class="text-sm font-semibold text-gray-700 mb-1">SKU</label>
                            <input type="text" name="SKU" placeholder="SKU"
                                class="border rounded px-3 py-2 w-full">
                        </div>
                        <div class="flex flex-col">
                            <label class="text-sm font-semibold text-gray-700 mb-1">Kategori</label>
                            <input type="text" name="category" placeholder="Kategori"
                                class="border rounded px-3 py-2 w-full">
                        </div>
                        <div class="flex flex-col">
                            <label class="text-sm font-semibold text-gray-700 mb-1">Top Notes</label>
                            <input type="text" name="notes[top_notes][]" placeholder="Top Notes" class="border rounded px-3 py-2 w-full">
                        </div>
                        <div class="flex flex-col">
                            <label class="text-sm font-semibold text-gray-700 mb-1">Heart Notes</label>
                            <input type="text" name="notes[heart_notes][]" placeholder="Top Notes" class="border rounded px-3 py-2 w-full">
                        </div>
                        <div class="flex flex-col">
                            <label class="text-sm font-semibold text-gray-700 mb-1">Base Notes</label>
                            <input type="text" name="notes[base_notes][]" placeholder="Base Notes" class="border rounded px-3 py-2 w-full">
                        </div>
                        <div class="flex flex-col col-span-2">
                            <label class="text-sm font-semibold text-gray-700 mb-1">Gambar Produk</label>
                            <input type="file" name="image" class="border rounded px-3 py-2 w-full col-span-2">
                        </div>

                    </div>
                    <div class="mt-4">
                        <h3 class="text-xl font-semibold text-gray-700 mb-2">Varian Produk</h3>
                        <div class="grid grid-cols-12 gap-2 font-semibold text-gray-700 mb-2">
                            <div class="col-span-5">Nama Varian</div>
                            <div class="col-span-2">Stok</div>
                            <div class="col-span-4">Harga</div>
                            <div class="col-span-1"></div>
                        </div>
                        <template x-for="(variant, index) in variants" :key="index">
                            <div class="grid grid-cols-12 gap-2 mb-2 items-center">
                                <input type="text" :name="'variant_name[' + index + ']'" x-model="variant.name"
                                    placeholder="Nama Varian" class="col-span-5 border rounded px-3 py-2">
                                <input type="number" :name="'variant_stok[' + index + ']'" x-model="variant.stok"
                                    placeholder="Stok" class="col-span-2 border rounded px-3 py-2 text-center">
                                <input type="number" :name="'variant_price[' + index + ']'" x-model="variant.price"
                                    placeholder="Harga" class="col-span-4 border rounded px-3 py-2">
                                <button type="button" @click="variants.splice(index, 1)" x-show="variants.length > 1"
                                    class="col-span-1 text-red-600 hover:text-red-800">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </template>
                        <button type="button" @click="variants.push({ name:'', stok:'', price:'' })"
                            class="mt-3 bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">
                            + Tambah Varian
                        </button>
                    </div>
                    <button type="submit" class="bg-[#9a6238] text-white px-4 py-2 rounded-lg w-full hover:bg-[#7c4e2d]">
                        Simpan Produk
                    </button>
                </form>
            </div>
        </div>

        {{-- Edit Produk Modal --}}
        <div x-show="editModalId" x-cloak 
             class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 p-4">
            <div class="bg-white rounded-2xl shadow-lg p-6 w-full max-w-lg relative max-h-[85vh] overflow-y-auto my-6 mt-14"
                x-data="{ variants: [] }"
                x-init="$watch('editModalId', value => {
                    if (value) {
                        variants = JSON.parse(JSON.stringify(currentProduct.variants));
                    }
                })">

                <h2 class="text-xl font-semibold mb-4 text-gray-800">Edit Produk</h2>

                <button @click="editModalId = null"
                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">✕</button>

                <form :action="`/admin/dashboard/${editModalId}`" method="POST" enctype="multipart/form-data"
                    class="space-y-4">
                    @csrf
                    @method('PUT')

                    <!-- INFO PRODUK -->
                    <div class="grid grid-cols-2 gap-3">
                        <div class="flex flex-col">
                            <label class="text-sm font-semibold text-gray-700 mb-1">Brand</label>
                            <input type="text" name="brand"
                                class="border rounded px-3 py-2 w-full"
                                x-model="currentProduct.brand">
                        </div>

                        <div class="flex flex-col">
                            <label class="text-sm font-semibold text-gray-700 mb-1">Nama Produk</label>
                            <input type="text" name="name"
                                class="border rounded px-3 py-2 w-full"
                                x-model="currentProduct.name">
                        </div>

                        <div class="flex flex-col">
                            <label class="text-sm font-semibold text-gray-700 mb-1">SKU</label>
                            <input type="text" name="SKU"
                                class="border rounded px-3 py-2 w-full"
                                x-model="currentProduct.SKU">
                        </div>

                        <div class="flex flex-col">
                            <label class="text-sm font-semibold text-gray-700 mb-1">Kategori</label>
                            <input type="text" name="category"
                                class="border rounded px-3 py-2 w-full"
                                x-model="currentProduct.category">
                        </div>

                        <div class="flex flex-col col-span-2">
                            <label class="text-sm font-semibold text-gray-700 mb-1">Gambar Produk</label>
                            <input type="file" name="image"
                                class="border rounded px-3 py-2 w-full">
                        </div>
                    </div>

                    <!-- VARIAN -->
                    <div class="mt-4">
                        <h3 class="text-xl font-semibold text-gray-700 mb-2">Varian Produk</h3>

                        <!-- Header -->
                        <div class="grid grid-cols-12 gap-2 font-semibold text-gray-700 mb-2">
                            <div class="col-span-5">Nama Varian</div>
                            <div class="col-span-2 text-center">Stok</div>
                            <div class="col-span-4">Harga</div>
                            <div class="col-span-1"></div>
                        </div>

                        <!-- List Varian -->
                        <template x-for="(variant, index) in variants" :key="index">
                            <div class="grid grid-cols-12 gap-2 mb-2 items-center">
                                <input type="hidden" :name="'variant_id[' + index + ']'" x-model="variant.id">

                                <input type="text"
                                    :name="'variant_name[' + index + ']'"
                                    x-model="variant.variant_name"
                                    placeholder="Nama Varian"
                                    class="col-span-5 border rounded px-3 py-2">

                                <input type="number"
                                    :name="'variant_stok[' + index + ']'"
                                    x-model="variant.stok"
                                    placeholder="Stok"
                                    class="col-span-2 border rounded px-3 py-2 text-center">

                                <input type="number"
                                    :name="'variant_price[' + index + ']'"
                                    x-model="variant.price"
                                    placeholder="Harga"
                                    class="col-span-4 border rounded px-3 py-2">

                                <button type="button"
                                    @click="variants.splice(index, 1)"
                                    x-show="variants.length > 1"
                                    class="col-span-1 text-red-600 hover:text-red-800">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </template>

                        <button type="button"
                            @click="variants.push({ id:null, variant_name:'', stok:'', price:'' })"
                            class="mt-3 bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">
                            + Tambah Varian
                        </button>
                    </div>

                    <!-- SUBMIT -->
                    <button type="submit"
                        class="bg-[#9a6238] text-white px-4 py-2 rounded-lg w-full hover:bg-[#7c4e2d]">
                        Update Produk
                    </button>
                </form>
                </div>
        </div>

        {{-- Daftar Pesanan --}}
        <div id="section-orders" style="display:none; margin:20px 75px;">
            <h3 class="orders-title text-center mb-4">Daftar Pesanan</h3>
            <div class="flex flex-col bg-white rounded-2xl shadow px-4 py-3 mb-4 gap-3">
                <div class="flex items-center gap-3">
                    <div class="flex items-center flex-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" placeholder="Cari pesanan..."
                            class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#9a6238]"
                            x-model="searchOrders">
                    </div>

                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="flex items-center border border-gray-200 px-3 py-2 rounded-lg text-sm text-[#9a6238] hover:bg-gray-50">
                            <span x-text="statusFilter"></span>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition
                            class="absolute right-0 mt-2 w-44 bg-white border rounded-lg shadow-lg z-50">
                            <ul>
                                <li>
                                    <button @click="statusFilter='Semua Status'; open=false"
                                        class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">Semua Status
                                    </button>
                                </li>
                                <li>
                                    <button @click="statusFilter='diproses'; open=false"
                                        class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">Diproses
                                    </button>
                                </li>
                                <li>
                                    <button @click="statusFilter='dalam pengiriman'; open=false"
                                        class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">Dalam Pengiriman
                                    </button>
                                </li>
                                <li>
                                    <button @click="statusFilter='terkirim'; open=false"
                                        class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">Terkirim
                                    </button>
                                </li>
                                <li>
                                    <button @click="statusFilter='batal'; open=false"
                                        class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100">Batal
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto bg-white rounded-2xl shadow">
                <table class="w-full text-sm text-left">
                    <thead class="bg-[#f8efe8]">
                        <tr>
                            <th class="px-4 py-3">No. Pesanan</th>
                            <th class="px-4 py-3">Nama Pemesan</th>
                            <th class="px-4 py-3">Produk</th>
                            <th class="px-4 py-3">Jumlah</th>
                            <th class="px-4 py-3">Total Harga</th>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            @php
                                $searchString = strtolower(
                                    $order->id .
                                        ' ' .
                                        $order->user->name .
                                        ' ' .
                                        implode(' ', $order->items->pluck('product.name')->toArray()),
                                );
                            @endphp
                            <tr class="border-t"
                                x-show="('{{ $searchString }}').includes(searchOrders.toLowerCase()) && (statusFilter === 'Semua Status' || statusFilter === '{{ $order->status }}')">
                                <td class="px-4 py-3">#{{ $order->id }}</td>
                                <td class="px-4 py-3">{{ $order->user->name }}</td>
                                <td class="px-4 py-3">
                                    @foreach ($order->items as $item)
                                        {{ $item->product->name }} {{ $item->variant->variant_name }}<br>
                                    @endforeach
                                </td>
                                <td class="px-4 py-3">
                                    @foreach ($order->items as $item)
                                        x{{ $item->quantity }}<br>
                                    @endforeach
                                </td>
                                <td class="px-4 py-3">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                <td class="px-4 py-3">{{ $order->created_at->format('d M Y H:i') }}</td>
                                <td class="px-4 py-3">
                                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST"
                                        style="display: flex; flex-direction: column; gap: 8px; align-items: flex-start;">
                                        @csrf
                                        @method('PATCH')
                                        <select class="status-dropdown border rounded px-2 py-1 text-sm bg-white w-full"
                                            data-order-id="{{ $order->id }}" style="min-width: 150px;">
                                            <option value="diproses" {{ $order->status == 'diproses' ? 'selected' : '' }}>
                                                Diproses</option>
                                            <option value="dalam pengiriman"
                                                {{ $order->status == 'dalam pengiriman' ? 'selected' : '' }}>Dalam
                                                Pengiriman</option>
                                            <option value="terkirim" {{ $order->status == 'terkirim' ? 'selected' : '' }}>
                                                Terkirim</option>
                                            <option value="batal" {{ $order->status == 'batal' ? 'selected' : '' }}>Batal
                                            </option>
                                        </select>

                                        <span
                                            class="status-badge px-3 py-1 rounded-full text-xs w-full text-center
                                                @if ($order->status == 'diproses') bg-yellow-300 text-yellow-800
                                                @elseif($order->status == 'dalam pengiriman') bg-blue-300 text-blue-800
                                                @elseif($order->status == 'terkirim') bg-green-500 text-white
                                                @elseif($order->status == 'batal') bg-red-500 text-white @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-10">
            @include('layouts.footer')
        </div>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            function inventoryData() {
                return {
                    addModal: false,
                    editModalId: null,
                    search: '',
                    searchOrders: '',
                    statusFilter: 'Semua Status',
                    products: @json($products),
                    orders: @json($orders),
                    get currentProduct() {
                        return this.products.find(p => p.id === this.editModalId) || {};
                    },
                    editProduct(id) {
                        this.editModalId = id;
                    },
                    deleteProduct(event, id) {
                        Swal.fire({
                            title: 'Hapus produk ini?',
                            text: "Data produk akan dihapus permanen!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Ya, hapus!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                event.target.submit();
                            }
                        });
                    }
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                const btnOrders = document.getElementById('btn-orders');
                const btnInventory = document.getElementById('btn-inventory');
                const sectionOrders = document.getElementById('section-orders');
                const sectionInventory = document.getElementById('section-inventory');

                function showOrders() {
                    sectionOrders.style.display = 'block';
                    sectionInventory.style.display = 'none';
                }

                btnOrders.addEventListener('click', showOrders);
                btnInventory.addEventListener('click', function() {
                    sectionInventory.style.display = 'block';
                    sectionOrders.style.display = 'none';
                });

                const dropdowns = document.querySelectorAll('.status-dropdown');
                dropdowns.forEach(dropdown => {
                    dropdown.addEventListener('change', function() {
                        const orderId = this.dataset.orderId;
                        const status = this.value;
                        const badge = this.nextElementSibling;

                        fetch(`/admin/orders/${orderId}/status`, {
                                method: 'PATCH',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    status: status
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    badge.textContent = data.status.charAt(0).toUpperCase() + data
                                        .status.slice(1);
                                    badge.className = 'status-badge px-3 py-1 rounded-full text-xs';
                                    switch (data.status) {
                                        case 'Diproses':
                                            badge.classList.add('bg-yellow-300', 'text-yellow-800');
                                            break;
                                        case 'Dalam pengiriman':
                                            badge.classList.add('bg-blue-300', 'text-blue-800');
                                            break;
                                        case 'Terkirim':
                                            badge.classList.add('bg-green-500', 'text-white');
                                            break;
                                        case 'Batal':
                                            badge.classList.add('bg-red-500', 'text-white');
                                            break;
                                    }
                                    sectionOrders.style.display = 'block';
                                    sectionInventory.style.display = 'none';
                                }
                            })
                            .catch(error => console.error('Error:', error));
                    });
                });
            });
        </script>

        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    timer: 2000,
                    showConfirmButton: false
                });
            </script>
        @endif

    </body>
@endsection
