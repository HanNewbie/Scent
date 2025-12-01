@extends('layouts.navbar-user')

@section('title', 'Checkout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/checkout.css') }}">
@endpush

@section('content')
    <div class="checkout-container mt-20">
        <a href="{{ route('user.cart') }}" class="back-link">
            <i class="fa fa-arrow-left"></i> Kembali ke Keranjang
        </a>

        <h2 class="checkout-title">Checkout</h2>
        <p class="checkout-subtitle">Lengkapi detail pemesanan Anda</p>

        <!-- FORM UTAMA -->
        <form id="orderForm" action="{{ route('user.order.store') }}" method="POST">
            @csrf
            <div class="checkout-grid">
                <div class="checkout-box">
                    <h3 class="section-title">
                        <i class="fa fa-location-dot"></i> Informasi Pengiriman
                    </h3>

                    <div class="form-group">
                        <label>Nama Lengkap *</label>
                        <input type="text" name="name" value="{{ $user->name }}" readonly>
                    </div>

                    <div class="form-group">
                        <label>Email *</label>
                        <input type="email" name="email" value="{{ $user->email }}" readonly>
                    </div>

                    <div class="form-group">
                        <label>Nomor Telepon *</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label>Alamat Lengkap *</label>
                        <textarea name="address" required placeholder="Masukkan alamat lengkap">{{ old('address', $user->address ?? '') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Kota *</label>
                        <input type="text" name="city" value="{{ old('city', $user->city ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label>Kode Pos *</label>
                        <input type="text" name="pos" value="{{ old('pos', $user->pos ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label>Catatan (Opsional)</label>
                        <input type="text" name="notes" placeholder="Catatan untuk kurir atau toko..."
                            value="{{ old('notes') }}">
                    </div>
                </div>

                <div class="checkout-box summary-box auto-height">
                    <h3 class="section-title">Ringkasan Pesanan</h3>

                    @foreach ($cartItems as $item)
                        <div class="summary-item">
                            <span>
                                {{ $item->product->name }}
                                ({{ $item->variant->variant_name }})
                                × {{ $item->quantity }}
                            </span>
                            <span>
                                Rp {{ number_format($item->variant->price * $item->quantity, 0, ',', '.') }}
                            </span>
                        </div>
                    @endforeach

                    <hr>

                    <div class="summary-item total">
                        <span>Total</span>
                        <span>Rp {{ number_format($totalAmount, 0, ',', '.') }}</span>
                    </div>

                    <button type="button" id="btnConfirm" class="btn-confirm w-full mt-4">
                        <i class="fa fa-check"></i> Konfirmasi Pesanan
                    </button>
                </div>

            </div>
        </form>
    </div>
    @php
        $productsForWhatsapp = $cartItems->map(function ($item) {
            return [
                'product' => $item->product->name,
                'variant' => $item->variant->variant_name,
                'qty' => $item->quantity,
            ];
        });
    @endphp
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnConfirm = document.getElementById('btnConfirm');
            const form = document.getElementById('orderForm');

            function checkFormValidity() {
                const requiredFields = form.querySelectorAll('input[required], textarea[required]');
                let valid = true;

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        valid = false;
                    }
                });

                btnConfirm.disabled = !valid;
                btnConfirm.classList.toggle('opacity-50', !valid);
            }

            checkFormValidity();
            form.addEventListener('input', checkFormValidity);

            btnConfirm.addEventListener('click', function() {
                if (btnConfirm.disabled) return;

                const formData = new FormData(form);
                const address = formData.get('address');
                const city = formData.get('city');
                const pos = formData.get('pos');
                const products = @json($productsForWhatsapp);
                const total = "{{ number_format($totalAmount, 0, ',', '.') }}";

                const productList = products
                    .map(item => `- ${item.product} (${item.variant}) ${item.qty}`)
                    .join('\n');

                const message = [
                    'Halo, saya ingin memesan:',
                    productList,
                    `Alamat: ${address}, ${city} (${pos})`,
                    `Total: Rp ${total}`
                ].join('\n');
                const whatsappUrl = `https://wa.me/6281515935967?text=${encodeURIComponent(message)}`;
                window.open(whatsappUrl, '_blank');
                fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        },
                        body: formData
                    })
                    .then(response => {
                        if (response.ok) {
                            setTimeout(() => {
                                window.location.href =
                                    "{{ route('user.dashboard', ['#pesanan']) }}";
                            }, 500);
                        } else {
                            alert('Gagal menyimpan pesanan. Silakan coba lagi.');
                        }
                    })
                    .catch(() => {
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                    });
                });
            });
    </script>



@endsection
