@extends('layouts.navbar-user')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard-user.css') }}">
@endpush

@section('content')
    <div x-data="{ open: false }">
        <div class="profile-container">
            <a href="{{ route('landingpage') }}" class="back-link"><i class="fa fa-arrow-left"></i> Kembali</a>

            <div class="profile-card">
                <div class="profile-info flex items-start gap-4">
                    @php
                        $initials = strtoupper(
                            collect(explode(' ', Auth::user()->name))
                                ->map(fn($n) => $n[0])
                                ->join(''),
                        );
                    @endphp
                    <img src="https://ui-avatars.com/api/?name={{ $initials }}&background=FBBF24&color=1F2937&size=128&rounded=true"
                        alt="Profile" class="w-16 h-16 rounded-full object-cover">
                    <div class="profile-text flex justify-between w-full">
                        <div class="text-left">
                            <h4 class="font-semibold text-amber-900">{{ Auth::user()->name }}</h4>
                            <p class="text-gray-600">{{ Auth::user()->email }}</p>
                            <div class="profile-badges mt-1 space-x-2">
                                <span class="badge"><i class="fa fa-star"></i> VIP Member</span>
                                <span class="badge-outline">Member sejak {{ Auth::user()->created_at->format('Y') }}</span>
                            </div>
                        </div>

                        @if (Auth::user()->address || Auth::user()->phone || Auth::user()->city || Auth::user()->pos)
                            <div class="ml-6 mt-1 text-left alamat-blok">
                                @if (Auth::user()->phone)
                                    <p><strong>Nomor Telepon:</strong> {{ Auth::user()->phone }}</p>
                                @endif
                                @if (Auth::user()->address)
                                    <p><strong>Alamat:</strong> {{ Auth::user()->address }}</p>
                                @endif
                                @if (Auth::user()->city)
                                    <p><strong>Kota:</strong> {{ Auth::user()->city }}</p>
                                @endif
                                @if (Auth::user()->pos)
                                    <p><strong>Kode Pos:</strong> {{ Auth::user()->pos }}</p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
                <div class="profile-actions mt-2">
                    <i class="fa fa-gear text-gray-600 hover:text-amber-700 transition" @click="open = true"
                        style="cursor:pointer;"></i>
                </div>
            </div>

            <section class="stats-section">
                <div class="stats-container">
                    <div class="stat-card stats-card-only">
                        <h4>Total Belanja <i class="fa fa-bag-shopping"></i></h4>
                        <p>Rp {{ number_format($deliveredTotal, 0, ',', '.') }}</p>
                    </div>
                    <div class="stat-card stats-card-only">
                        <h4>Total Pesanan <i class="fa fa-box"></i></h4>
                        <p>{{ $deliveredCount }}</p>
                    </div>
                    <div class="stat-card stats-card-only">
                        <h4>Favorit <i class="fa fa-heart"></i></h4>
                        <p>{{ $favoriteCount }}</p>
                    </div>
                </div>
        </div>

        <div class="tab-menu">
            <button class="active" id="btn-ringkasan">Ringkasan</button>
            <button id="btn-pesanan">Pesanan</button>
            <button id="btn-favorit">Favorit</button>
        </div>

        {{-- Ringkasan 3 --}}
        <div class="w-full mx-auto px-6" id="section-ringkasan">
            <div class="ringkasan-section section-wrapper">
                <h3 class="orders-title">Pesanan Terakhir</h3>
                <p class="orders-subtitle">
                    {{ $latestOrders->count() < 3 ? 'Pesanan terbaru Anda' : '3 pesanan terbaru Anda' }}
                </p>

                @forelse ($latestOrders as $orderId => $orderGroup)
                    @php
                        $order = $orderGroup->first()->order;
                        $totalHarga = $orderGroup->sum('total_amount');
                        $status = strtolower($order->status ?? 'diproses');
                        $badgeClass = match ($status) {
                            'diproses' => 'badge-processing',
                            'dalam pengiriman' => 'badge-shipping',
                            'terkirim' => 'badge-confirmed',
                            'batal' => 'badge-cancelled',
                            default => 'badge-processing',
                        };
                    @endphp

                    <div
                        class="order-item relative border rounded-lg p-5 mb-4 shadow-sm bg-white hover:shadow-md transition">
                        <div class="flex justify-between items-center mb-2">
                            <div class="flex items-center gap-2">
                                <span class="order-id font-semibold text-gray-800">
                                    #ORD-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                                </span>
                                <span class="badge {{ $badgeClass }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </div>
                        </div>

                        <div class="mb-2 space-y-2 leading-tight">
                            @foreach ($orderGroup as $item)
                                <h4 class="order-product text-gray-700 font-medium text-sm m-0">
                                    - {{ $item->product->name }} {{ $item->variant->variant_name }}
                                    {{ $item->quantity }}x
                                </h4>
                            @endforeach
                        </div>

                        <div class="flex items-center justify-between text-sm text-gray-600">
                            <div class="order-date flex items-center gap-1">
                                <span class="icon-small">📅</span>
                                <span>{{ $order->created_at->format('d/m/Y') }}</span>
                                <span class="order-price font-semibold text-gray-800 ml-4">
                                    Rp {{ number_format($totalHarga, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <a href="{{ route('user.order.detail', $order->id) }}"
                            class="absolute bottom-4 right-4 border border-amber-700 text-amber-700 text-sm font-semibold px-5 py-2.5 rounded-md hover:bg-amber-700 hover:text-white transition">
                            Detail
                        </a>
                    </div>
                @empty
                    <p class="text-gray-500 text-center mt-4">Belum ada pesanan yang dilakukan.</p>
                @endforelse
            </div>
        </div>

        {{-- Pesanan --}}
        <div class="w-full mx-auto px-6" id="section-pesanan" style="display:none;">
            <div class="ringkasan-section section-wrapper">
                <h3 class="orders-title">Semua Pesanan</h3>
                <p class="orders-subtitle">Daftar lengkap pesanan Anda</p>

                @forelse ($allOrders as $orderId => $orderGroup)
                    @php
                        $order = $orderGroup->first()->order;
                        $totalHarga = $orderGroup->sum('total_amount');
                        $status = strtolower($order->status ?? 'diproses');
                        $badgeClass = match ($status) {
                            'diproses' => 'badge-processing',
                            'dalam pengiriman' => 'badge-shipping',
                            'terkirim' => 'badge-confirmed',
                            'batal' => 'badge-cancelled',
                            default => 'badge-processing',
                        };
                    @endphp

                    <div
                        class="order-item relative border rounded-lg p-5 mb-4 shadow-sm bg-white hover:shadow-md transition">
                        <div class="flex justify-between items-center mb-2">
                            <div class="flex items-center gap-2">
                                <span class="order-id font-semibold text-gray-800">
                                    #ORD-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                                </span>
                                <span class="badge {{ $badgeClass }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </div>
                        </div>

                        <div class="mb-2 space-y-2 leading-tight">
                            @foreach ($orderGroup as $item)
                                <h4 class="order-product text-gray-700 font-medium text-sm m-0">
                                    - {{ $item->product->name }} {{ $item->variant->variant_name }}
                                    {{ $item->quantity }}x
                                </h4>
                            @endforeach
                        </div>

                        <div class="flex items-center justify-between text-sm text-gray-600">
                            <div class="order-date flex items-center gap-1">
                                <span class="icon-small">📅</span>
                                <span>{{ $order->created_at->format('d/m/Y') }}</span>
                                <span class="order-price font-semibold text-gray-800 ml-4">
                                    Rp {{ number_format($totalHarga, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <a href="{{ route('user.order.detail', $order->id) }}"
                            class="absolute bottom-4 right-4 border border-amber-700 text-amber-700 text-sm font-semibold px-5 py-2.5 rounded-md hover:bg-amber-700 hover:text-white transition">
                            Detail
                        </a>
                    </div>
                @empty
                    <p class="text-gray-500 text-center mt-4">Belum ada pesanan yang dilakukan.</p>
                @endforelse
            </div>
        </div>

        {{-- Favorit --}}
        <div id="section-favorit" class="hidden mx-4 sm:mx-10 lg:mx-[75px]">
            <h3 class="orders-title text-center mb-4">Produk Favorit Anda</h3>
            <div class="max-w-7xl mx-auto px-4 grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-4">
                @forelse ($favorites as $fav)
                    @php $product = $fav->product; @endphp
                    <div
                        class="bg-white rounded-2xl shadow-md overflow-hidden relative transform transition duration-300 ease-in-out hover:shadow-xl hover:-translate-y-1">
                        <span
                            class="absolute top-2 left-2 bg-amber-100 text-amber-800 px-3 py-1 rounded-full text-xs font-medium z-10">
                            {{ $product->category }}
                        </span>
                        <span
                            class="absolute top-2 right-2 px-3 py-1 rounded-full text-xs font-medium
                            @if ($product->stok > $product->min_stok) bg-green-500 text-white
                            @elseif($product->stok > 0) bg-yellow-300 text-yellow-800
                            @else bg-red-500 text-white @endif z-10">
                            @if ($product->stok > $product->min_stok)
                                Tersedia
                            @elseif($product->stok > 0)
                                Sedikit
                            @else
                                Habis
                            @endif
                        </span>
                        <div class="overflow-hidden">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                class="w-full h-40 object-cover transform transition duration-300 ease-in-out hover:scale-105">
                        </div>

                        <div class="p-4 pb-14">
                            <h3 class="text-md font-semibold text-gray-800 mb-1">{{ $product->name }}</h3>
                            <p class="text-sm text-gray-500 mb-2">
                                <i class="fa fa-box"></i> {{ $product->brand }}
                            </p>
                            <p class="text-amber-900 font-semibold text-2xl">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>
                        </div>

                        <form action="{{ route('user.favorites.remove', $product->id) }}" method="POST"
                            class="absolute bottom-3 right-3 z-10">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="favorite-btn transition duration-200">
                                <i class="fa fa-heart text-red-500 text-xl"></i>
                            </button>
                        </form>

                    </div>
                @empty
                    <p class="col-span-4 text-center text-gray-500">Belum ada produk favorit.</p>
                @endforelse

            </div>
        </div>

        {{-- Modal Edit Profil --}}
        <div x-show="open" x-cloak @click.self="open = false" x-transition.opacity
            class="fixed inset-0 bg-black bg-opacity-50 z-40 flex items-center justify-center p-4">
            <div x-transition.scale
                class="bg-white rounded-2xl shadow-xl w-full max-w-md p-4 relative transform transition-all max-h-[80vh] overflow-y-auto">
                <h2 class="text-lg font-semibold text-amber-900 mb-3 text-center">Edit Profil</h2>
                <form action="{{ route('user.profile.update') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="border border-gray-200 rounded-lg p-3 hover:border-amber-500 transition">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ Auth::user()->name }}"
                            class="w-full border-gray-300 rounded-md focus:ring-amber-800 focus:border-amber-800">
                    </div>

                    <div class="border border-gray-200 rounded-lg p-3 hover:border-amber-500 transition">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ Auth::user()->email }}"
                            class="w-full border-gray-300 rounded-md focus:ring-amber-800 focus:border-amber-800">
                    </div>

                    <div class="border border-gray-200 rounded-lg p-3 hover:border-amber-500 transition">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                        <input type="text" name="phone" value="{{ Auth::user()->phone }}"
                            class="w-full border-gray-300 rounded-md focus:ring-amber-800 focus:border-amber-800">
                    </div>

                    <div class="border border-gray-200 rounded-lg p-3 hover:border-amber-500 transition">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                        <textarea name="address" rows="2"
                            class="w-full border-gray-300 rounded-md focus:ring-amber-800 focus:border-amber-800">{{ Auth::user()->address }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="border border-gray-200 rounded-lg p-3 hover:border-amber-500 transition">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kota</label>
                            <input type="text" name="city" value="{{ Auth::user()->city }}"
                                class="w-full border-gray-300 rounded-md focus:ring-amber-800 focus:border-amber-800">
                        </div>
                        <div class="border border-gray-200 rounded-lg p-3 hover:border-amber-500 transition">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kode Pos</label>
                            <input type="text" name="pos" value="{{ Auth::user()->pos }}"
                                class="w-full border-gray-300 rounded-md focus:ring-amber-800 focus:border-amber-800">
                        </div>
                    </div>

                    <h3 class="text-md font-semibold text-amber-900 mt-4 mb-2">Ubah Password</h3>
                    <div class="border border-gray-200 rounded-lg p-3 hover:border-amber-500 transition">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password Sekarang</label>
                        <div class="relative">
                            <input type="password" id="current_password" name="current_password" placeholder="Masukkan password sekarang"
                                class="w-full border-gray-300 rounded-md focus:ring-amber-800 focus:border-amber-800 pr-10">
                            <button type="button" class="absolute inset-y-0 right-3 flex items-center text-gray-500"
                                data-toggle="password" data-target="current_password" aria-label="Tampilkan password saat ini">
                                <i class="fa fa-eye text-sm"></i>
                            </button>
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-3 hover:border-amber-500 transition">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                        <div class="relative">
                            <input type="password" id="new_password" name="new_password" placeholder="Masukkan password baru"
                                class="w-full border-gray-300 rounded-md focus:ring-amber-800 focus:border-amber-800 pr-10">
                            <button type="button" class="absolute inset-y-0 right-3 flex items-center text-gray-500"
                                data-toggle="password" data-target="new_password" aria-label="Tampilkan password baru">
                                <i class="fa fa-eye text-sm"></i>
                            </button>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 text-right">
                        Lupa password?
                        <a href="{{ route('forgot.password') }}" class="text-amber-800 hover:underline">
                            Reset di sini
                        </a>
                    </p>

                    <!-- Tombol -->
                    <div class="flex justify-end mt-4 space-x-3">
                        <button type="button" @click="open = false"
                            class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300 transition">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-amber-800 text-white rounded-md hover:bg-amber-900 transition">
                            Simpan
                        </button>
                    </div>
                </form>

                <!-- Close -->
                <button @click="open = false" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 transition">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </div>


        <div class="mt-10">
            @include('layouts.footer')
        </div>
    </div>

   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // ===== SWEET ALERT =====
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Sukses!',
            text: '{{ session('success') }}',
            timer: 2000,
            showConfirmButton: false
        });
    @endif

    @if ($errors->any())
        let errorMessages = '';
        @foreach ($errors->all() as $error)
            errorMessages += '{{ $error }}\n';
        @endforeach

        if (errorMessages !== '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: errorMessages,
            });
        }
    @endif

    // ===== NAV TAB SWITCH =====
    const btnRingkasan = document.getElementById('btn-ringkasan');
    const btnPesanan = document.getElementById('btn-pesanan');
    const btnFavorit = document.getElementById('btn-favorit');

    const sectionRingkasan = document.getElementById('section-ringkasan');
            const sectionPesanan = document.getElementById('section-pesanan');
            const sectionFavorit = document.getElementById('section-favorit');

            if(btnRingkasan && btnPesanan && btnFavorit) {
        btnRingkasan.addEventListener('click', () => {
            btnRingkasan.classList.add('active');
            btnPesanan.classList.remove('active');
            btnFavorit.classList.remove('active');
            sectionRingkasan.style.display = 'block';
            sectionPesanan.style.display = 'none';
            sectionFavorit.style.display = 'none';
        });

        btnPesanan.addEventListener('click', () => {
            btnRingkasan.classList.remove('active');
            btnPesanan.classList.add('active');
            btnFavorit.classList.remove('active');
            sectionRingkasan.style.display = 'none';
            sectionPesanan.style.display = 'block';
            sectionFavorit.style.display = 'none';
        });

                btnFavorit.addEventListener('click', () => {
                    btnRingkasan.classList.remove('active');
                    btnPesanan.classList.remove('active');
                    btnFavorit.classList.add('active');
                    sectionRingkasan.style.display = 'none';
                    sectionPesanan.style.display = 'none';
                    sectionFavorit.style.display = 'block';
                });
            }

            // Toggle password visibility in modal
            document.querySelectorAll('[data-toggle="password"]').forEach(button => {
                button.addEventListener('click', () => {
                    const targetId = button.getAttribute('data-target');
                    const input = document.getElementById(targetId);
                    const icon = button.querySelector('i');
                    const isHidden = input.type === 'password';

                    input.type = isHidden ? 'text' : 'password';
                    icon.classList.toggle('fa-eye', !isHidden);
                    icon.classList.toggle('fa-eye-slash', isHidden);
                });
            });
        });
    </script>


@endsection
