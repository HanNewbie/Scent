@extends('layouts.navbar-user')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8 mt-10">

    <a href="{{ route('user.dashboard') }}" class="text-amber-700 hover:underline">
        ← Kembali ke Dashboard
    </a>

    <div class="bg-white mt-5 p-6 rounded-xl shadow-md">

        <h2 class="text-2xl font-bold text-amber-900 mb-4">
            Detail Pesanan #ORD-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
            <div>
                <p class="text-gray-600">Tanggal Pemesanan</p>
                <p class="font-semibold">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                <hr>
                <p class="text-gray-600">Alamat</p>
                <p class="font-semibold">{{ $order->address}}</p>
                <hr>
                <p class="text-gray-600">Catatan</p>
                <p class="font-semibold">{{ $order->notes}}</p>

            </div>
            <div>
                <p class="text-gray-600">Status</p>
                <span class="px-3 py-1 rounded-full text-sm font-semibold
                    @if($order->status == 'terkirim') bg-green-100 text-green-700
                    @elseif($order->status == 'dalam pengiriman') bg-blue-100 text-blue-700
                    @elseif($order->status == 'batal') bg-red-100 text-red-700
                    @else bg-yellow-100 text-black-700
                    @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>
        <hr class="my-4">
        <h3 class="text-xl font-semibold mb-3">Produk Dibeli</h3>
        @foreach ($order->items as $item)
            <div class="flex items-center justify-between border-b py-4">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('storage/' . $item->product->image) }}"
                         class="w-16 h-16 rounded-md object-cover shadow">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $item->product->name }}  {{ $item->variant->variant_name }}</p>
                        <p class="text-sm text-gray-600">Jumlah: {{ $item->quantity }}</p>
                    </div>
                </div>
                <p class="font-semibold text-gray-800">
                    Rp {{ number_format($item->total_amount, 0, ',', '.') }}
                </p>
            </div>
        @endforeach
        <hr class="my-4">
        <div class="flex justify-between text-lg font-bold">
            <span>Total Pembayaran</span>
            <span>Rp {{ number_format($order->items->sum('total_amount'), 0, ',', '.') }}</span>
        </div>

    </div>

</div>
@endsection
