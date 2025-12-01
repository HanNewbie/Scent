<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class LandingPageController extends Controller
{
    public function index()
    {
        $products = Product::with(['variants' => function ($q) {
                $q->orderBy('price', 'asc');
            }])
            ->paginate(24);

        // proses setiap produk
        $products->getCollection()->transform(function ($product) {

            // ambil varian yang stok > 0 dan paling murah
            $availableVariant = $product->variants
                ->where('stok', '>', 0)
                ->sortBy('price')
                ->first();

            // jika tidak ada stok, ambil varian termurah
            $cheapestVariant = $availableVariant ?? $product->variants->first();

            $product->display_price  = $cheapestVariant->price ?? 0;
            $product->display_stok   = $cheapestVariant->stok ?? 0;
            $product->display_variant = $cheapestVariant;

            return $product;
        });
        return view('welcome', compact('products'));
    }
}
