<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Order;


class OrderController extends Controller
{
    public function showConfirmation()
    {
        $user = Auth::user();

        $cartItems = Cart::with(['product', 'variant'])
            ->where('user_id', $user->id)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('user.cart.index')
                ->with('error', 'Keranjang masih kosong');
        }

        $totalAmount = $cartItems->sum(function ($item) {
            return $item->variant->price * $item->quantity;
        });

        return view('user.confirm', compact('cartItems', 'user', 'totalAmount'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'city'    => 'required|string|max:100',
            'pos'     => 'required|string|max:10',
            'notes'   => 'nullable|string|max:255',
        ]);

        $user = Auth::user();

        $cartItems = Cart::with(['product', 'variant'])
            ->where('user_id', $user->id)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('user.cart')
                ->with('error', 'Keranjang anda kosong.');
        }

        $totalAmount = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $order = Order::create([
            'user_id'      => $user->id,
            'status'       => 'diproses',
            'total_amount' => $totalAmount,
            'address'      => $request->address,
            'city'         => $request->city,
            'pos'          => $request->pos,
            'notes'        => $request->notes,
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id'     => $order->id,
                'product_id'   => $item->product_id,
                'variant_id'   => $item->variant_id,
                'price'        => $item->price,
                'quantity'     => $item->quantity,
                'total_amount' => $item->price * $item->quantity,
            ]);

            if ($item->variant) {
                $item->variant->stok -= $item->quantity;
                $item->variant->save();
            } else {
                $item->product->stok -= $item->quantity;
                $item->product->save();
            }
        }

        Cart::where('user_id', $user->id)->delete();

        $productList = $cartItems->map(function ($item) {
            $variantName = $item->variant ? "({$item->variant->variant_name})" : "";
            return "- {$item->product->name} {$variantName} {$item->quantity}";
        })->implode("\n");

        $message = "Halo, saya ingin memesan:\n"
            . "{$productList}\n"
            . "Alamat: {$request->address}, {$request->city} ({$request->pos})\n"
            . "Total: Rp " . number_format($totalAmount, 0, ',', '.');

        $whatsappUrl = 'https://wa.me/62895325815577?text=' . urlencode($message);

        return redirect()->route('user.dashboard')
            ->with('success', 'Pesanan berhasil dibuat!')
            ->with('whatsappUrl', $whatsappUrl);
    }

    public function detail($id)
    {
        $order = Order::with(['items.product'])
                    ->where('id', $id)
                    ->where('user_id', Auth::id()) 
                    ->firstOrFail();

        return view('user.detail', compact('order'));
    }


    // public function confirm(Request $request, $orderId)
    // {
    //     $orders = Item::create([
    //         'user_id' => $user->id,
    //         'total_amount' => $totalAmount,
    //     ]);

    //     return redirect()->route('user.orders')->with('success', 'Pesanan berhasil dikonfirmasi!');
    // }

    // public function create(Request $request)
    // {
    //     $user = auth()->user();
    //     $cartItems = $user->cartItems;


    //     $totalAmount = $cartItems->sum(function($item){
    //         return $item->product->price * $item->quantity;
    //     });

    //     $order = Order::create([
    //         'user_id' => $user->id,
    //         'status' => 'diproses',
    //         'total_amount' => $totalAmount,
    //     ]);

    //     foreach ($cartItems as $item) {
    //         $order->items()->create([
    //             'product_id' => $item->product_id,
    //             'quantity' => $item->quantity,
    //             'price' => $item->product->price,
    //         ]);
    //     }

    //     return redirect()->route('user.order.confirmation', $order->id);
    // }

    public function confirmation($id)
    {
        $order = Order::with(['items.product', 'user'])->findOrFail($id);
        return view('user.order.confirmation', compact('order'));
    }

}
