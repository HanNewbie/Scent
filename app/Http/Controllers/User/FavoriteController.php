<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Product;

class FavoriteController extends Controller
{
    public function toggle(Product $product)
    {
        $user = auth()->user();

        // Cek apakah sudah difavoritkan
        $favorite = Favorite::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if ($favorite) {
            // Jika sudah ada, hapus dari favorit
            $favorite->delete();
            $message = 'Produk dihapus dari favorit.';
        } else {
            // Jika belum ada, tambahkan ke favorit
            Favorite::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
            $message = 'Produk ditambahkan ke favorit.';
        }

        return back()->with('status', $message);
    }

    public function remove($productId)
    {
        Favorite::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->delete();

        return redirect()->back()->with('success', 'Produk dihapus dari favorit');
    }
}
