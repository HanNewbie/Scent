@extends('layouts.navbar-user')

@section('title', 'Keranjang Belanja')
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/cart.css') }}">
@endpush

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="cart-container mt-10">
        <a href="{{ url()->previous() }}" class="back-link">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
        <h1 class="cart-title">Keranjang Belanja</h1>
        <p class="cart-subtitle">{{ $cart->count() }} produk dalam keranjang</p>

        @if ($cart->isEmpty())
            <div class="empty-cart text-center py-20">
                <i class="fa fa-shopping-bag fa-4x" aria-hidden="true"></i>
                <h2 class="text-xl font-semibold mb-2">Keranjang Anda Kosong</h2>
                <p class="text-gray-600 mb-4">Mulai belanja dan tambahkan produk favorit Anda!</p>
                <a href="{{ route('landingpage') }}#products"
                    class="px-6 py-2 bg-amber-800 text-white rounded-lg hover:bg-amber-700 transition">
                    Mulai Belanja
                </a>
            </div>
        @else
            <div class="cart-content">
                <div class="cart-items">
                    @foreach ($cart as $item)
                        <div class="cart-card" data-cart-id="{{ $item->id }}" data-product-name="{{ $item->product->name }}" data-variant-name="{{ $item->variant->variant_name }}">
                            <div class="cart-image">
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}">
                            </div>
                            <div class="cart-details">
                                <h3 class="cart-product-name">
                                    {{ $item->product->name }}
                                </h3>
                                <p class="text-sm text-gray-500 mb-1">
                                    Varian: <span class="font-medium">{{ $item->variant->variant_name }}</span>
                                </p>
                                <p class="cart-price">
                                    Rp {{ number_format($item->variant->price, 0, ',', '.') }}
                                </p>
                                <div class="cart-quantity">
                                    <button class="qty-btn decrease" data-cart-id="{{ $item->id }}">−</button>
                                    <span class="qty" id="qty-{{ $item->id }}">{{ $item->quantity }}</span>
                                    <button class="qty-btn increase" data-cart-id="{{ $item->id }}">+</button>
                                </div>
                            </div>
                            <div class="cart-subtotal">
                                <p class="text-sm text-gray-500">Subtotal</p>
                                <h4>
                                    Rp {{ number_format($item->quantity * $item->variant->price, 0, ',', '.') }}
                                </h4>
                            </div>
                            <form action="{{ route('user.cart.remove', $item->id) }}" method="POST"
                                class="delete-btn-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>

                <div class="cart-summary">
                    <h2>Ringkasan Pesanan</h2>
                    @foreach ($cart as $item)
                        <div class="summary-row" data-cart-id="{{ $item->id }}">
                            <span class="summary-name">
                                {{ $item->product->name }} ({{ $item->variant->variant_name }}) × {{ $item->quantity }}
                            </span>
                            <span class="subtotal-price">
                                Rp {{ number_format($item->variant->price * $item->quantity, 0, ',', '.') }}
                            </span>
                        </div>
                    @endforeach
                    <hr>
                    <div class="summary-total">
                        <span>Total</span>
                        <span class="font-semibold text-lg">
                            Rp {{ number_format($subtotal, 0, ',', '.') }}
                        </span>
                    </div>

                    <a href="{{ route('user.order.checkout') }}" class="checkout-btn">
                        <i class="fa fa-shopping-bag"></i> Checkout
                    </a>

                    <a href="{{ route('landingpage') }}#products" class="continue-link">
                        Lanjut Belanja
                    </a>
                </div>
            </div>
        @endif
    </div>

    <div>
        @include('layouts.footer')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            document.querySelectorAll('.delete-btn-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Hapus item ini?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, hapus',
                        cancelButtonText: 'Batal'
                    }).then(result => {
                        if (result.isConfirmed) {
                            const url = form.action;
                            fetch(url, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': token,
                                        'Accept': 'application/json'
                                    }
                                })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.status === 'success') {
                                        const card = form.closest('.cart-card');
                                        const cartId = card.dataset.cartId;
                                        card.remove();

                                        const summaryRow = document.querySelector(
                                            `.summary-row[data-cart-id="${cartId}"]`
                                        );
                                        if (summaryRow) summaryRow.remove();

                                        updateCartSummary();

                                        Swal.fire('Terhapus!', 'Item berhasil dihapus.',
                                            'success');
                                    } else {
                                        Swal.fire('Gagal!', data.message, 'error');
                                    }
                                })
                                .catch(err => {
                                    console.error(err);
                                    Swal.fire('Error!', 'Terjadi kesalahan', 'error');
                                });
                        }
                    });
                });
            });

            document.querySelectorAll('.qty-btn.increase').forEach(btn => {
                btn.addEventListener('click', () => {
                    const cartId = btn.dataset.cartId;
                    const qtySpan = document.getElementById(`qty-${cartId}`);
                    updateQuantity(cartId, parseInt(qtySpan.textContent) + 1);
                });
            });

            document.querySelectorAll('.qty-btn.decrease').forEach(btn => {
                btn.addEventListener('click', () => {
                    const cartId = btn.dataset.cartId;
                    const qtySpan = document.getElementById(`qty-${cartId}`);
                    const qty = parseInt(qtySpan.textContent);
                    if (qty > 1) updateQuantity(cartId, qty - 1);
                });
            });

            function updateQuantity(cartId, qty) {
                fetch(`{{ url('user/cart/update') }}/${cartId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            quantity: qty
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {

                            // qty
                            document.getElementById(`qty-${cartId}`).textContent = data.quantity;

                            // subtotal kartu
                            const card = document.querySelector(`.cart-card[data-cart-id="${cartId}"]`);
                            card.querySelector('.cart-subtotal h4').textContent =
                                `Rp ${data.subtotal.toLocaleString('id-ID')}`;

                            updateCartSummary();
                        }
                    });
            }

            function updateCartSummary() {
            let total = 0;

            document.querySelectorAll('.cart-card').forEach(card => {
                const subtotalText = card.querySelector('.cart-subtotal h4').textContent;
                total += Number(subtotalText.replace(/\D/g, ''));

                const cartId = card.dataset.cartId;
                const qty = card.querySelector('.qty').textContent;
                const productName = card.dataset.productName;
                const variantName = card.dataset.variantName;

                const row = document.querySelector(`.summary-row[data-cart-id="${cartId}"]`);
                if (row) {
                    row.querySelector('.summary-name').textContent =
                        `${productName} (${variantName}) × ${qty}`;
                    row.querySelector('.subtotal-price').textContent = subtotalText;
                }
            });

            document.querySelector('.summary-total span:last-child').textContent =
                `Rp ${total.toLocaleString('id-ID')}`;
        }

        });
    </script>
@endsection
