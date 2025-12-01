<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function add(Request $request, $id)
    {
        if (!Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Silakan login terlebih dahulu.'
                ], 401);
            }
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $request->validate([
            'variant_id' => 'required|exists:product_variants,id'
        ]);

        $user = Auth::user();

        $variant = ProductVariant::where('id', $request->variant_id)
            ->where('product_id', $id)
            ->firstOrFail();

        if ($variant->stok <= 0) {
            return back()->with('error', 'Stok varian sudah habis.');
        }

        $cartItem = Cart::where('user_id', $user->id)
            ->where('variant_id', $variant->id)
            ->first();

        if ($cartItem) {
            if ($cartItem->quantity + 1 > $variant->stok) {
                return back()->with('error', 'Jumlah melebihi stok yang tersedia.');
            }
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id'    => $user->id,
                'product_id' => $variant->product_id,
                'variant_id' => $variant->id,
                'quantity'   => 1,
                'price'      => $variant->price,
            ]);
        }
        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Produk berhasil ditambahkan ke keranjang!'
            ]);
        }
        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!')->withFragment('products');
    }

    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $cart = Cart::with(['product', 'variant'])
            ->where('user_id', $user->id)
            ->get();

        $subtotal = $cart->sum(function ($item) {
            $price = $item->price ?? $item->variant->price ?? 0;
            return $price * $item->quantity;
        });

        return view('user.cart', compact('cart', 'subtotal'));
    }


    public function remove($id)
    {
        $cart = Cart::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$cart) {
            return response()->json([
                'status' => 'error',
                'message' => 'Item tidak ditemukan'
            ], 404);
        }
        $cart->delete();
        return response()->json([
            'status' => 'success'
        ]);
    }


    public function update(Request $request, $cartId)
    {
        $cart = Cart::findOrFail($cartId);
        $cart->quantity = $request->quantity;
        $cart->save();

        return response()->json([
            'status' => 'success',
            'quantity' => $cart->quantity,
            'subtotal' => $cart->quantity * $cart->variant->price
        ]);
    }

}
