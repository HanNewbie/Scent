<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CollectController extends Controller
{
    public function index(Request $request)
    {
        $categories = Product::select('category')
            ->whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $query = Product::with(['variants' => function ($q) {
            $q->orderBy('price', 'asc');
        }]);

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $keyword = strtolower($request->search);

            $query->where(function ($q) use ($keyword) {
                $q->whereRaw("LOWER(JSON_EXTRACT(notes, '$.top_notes')) LIKE ?", ["%{$keyword}%"])
                ->orWhereRaw("LOWER(JSON_EXTRACT(notes, '$.heart_notes')) LIKE ?", ["%{$keyword}%"])
                ->orWhereRaw("LOWER(JSON_EXTRACT(notes, '$.base_notes')) LIKE ?", ["%{$keyword}%"])
                ->orWhereRaw("LOWER(name) LIKE ?", ["%{$keyword}%"]);
            });
        }

        $products = $query->paginate(24)->appends($request->query());

        $products->getCollection()->transform(function ($product) {
            $availableVariant = $product->variants
                ->where('stok', '>', 0)
                ->sortBy('price')
                ->first();

            $cheapestVariant = $availableVariant ?? $product->variants->first();
            $product->display_price    = $cheapestVariant->price ?? 0;
            $product->display_stok     = $cheapestVariant->stok ?? 0;
            $product->display_variant  = $cheapestVariant;

            return $product;
        });

        return view('user.koleksi', compact('products', 'categories'));
    }
}
