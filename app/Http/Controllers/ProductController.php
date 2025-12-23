<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\ProductVariant;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('variants')->get();

        $totalValue = Order::where('status', 'Terkirim')
            ->with('items.variant', 'items.product')
            ->get()
            ->sum(function ($order) {
                return $order->items->sum(function ($item) {
                    if ($item->variant) {
                        return $item->variant->price * $item->quantity;
                    }
                    return $item->product->price * $item->quantity;
                });
            });

        $inStock = 0;
        $lowStock = 0;
        $outStock = 0;
        foreach ($products as $product) {
            foreach ($product->variants as $variant) {
                if ($variant->stok == 0) {
                    $outStock++;
                } elseif ($variant->stok < 10) {
                    $lowStock++;
                } else {
                    $inStock++;
                }
            }

            if ($product->variants->count() == 0) {
                if ($product->stok == 0) {
                    $outStock++;
                } elseif ($product->stok < 10) {
                    $lowStock++;
                } else {
                    $inStock++;
                }
            }
        }

        $orders = Order::with('items.product', 'user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.dashboard', compact(
            'products',
            'totalValue',
            'inStock',
            'lowStock',
            'outStock',
            'orders'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'brand' => 'required',
            'name' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png|max:5048',
            'SKU' => 'required|unique:products,SKU',
            'category' => 'required',
            'notes' => 'nullable|array',
            
            'variant_name' => 'required|array|min:1',
            'variant_name.*' => 'required|string',

            'variant_stok' => 'required|array',
            'variant_stok.*' => 'required|numeric|min:0',

            'variant_price' => 'required|array',
            'variant_price.*' => 'required|numeric|min:0',
        ]);

        $data = $request->except('image', 'variant_name', 'variant_stok', 'variant_price');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('assets/products', 'public');
        }

        if ($request->has('notes')) {
            $data['notes'] = $request->notes;
        }

        $product = Product::create($data);

        foreach ($request->variant_name as $index => $name) {
            ProductVariant::create([
                'product_id' => $product->id,
                'variant_name' => $name,
                'stok' => $request->variant_stok[$index],
                'price' => $request->variant_price[$index],
            ]);
        }
        return redirect()->back()->with('success', 'Produk dan varian berhasil disimpan.');
    }

    public function update(Request $request, $id)
    {
        $product = Product::with('variants')->findOrFail($id);

        $request->validate([
            'brand'      => 'nullable|string',
            'name'       => 'nullable|string',
            'image'      => 'nullable|mimes:jpg,jpeg,png|max:5048',
            'SKU'        => 'nullable|string|unique:products,SKU,' . $id,
            'category'   => 'nullable|string',
            
            'variant_name' => 'nullable|array',
            'variant_name.*' => 'nullable|string',

            'variant_stok' => 'nullable|array',
            'variant_stok.*' => 'nullable|numeric|min:0',

            'variant_price' => 'nullable|array',
            'variant_price.*' => 'nullable|numeric|min:0',
        ]);

        $data = $request->except([
            '_token', '_method', 'image',
            'variant_id', 'variant_name', 'variant_price',
            'variant_stok',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image && \Storage::disk('public')->exists($product->image)) {
                \Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('assets/products', 'public');
        }

        foreach ($data as $key => $value) {
            if ($value !== null) {
                $product->$key = $value;
            }
        }
        $product->save();

        $oldVariantIds = $product->variants->pluck('id')->toArray();

        $newVariantIds = $request->variant_id ?? [];

        $toDelete = array_diff($oldVariantIds, $newVariantIds);
        ProductVariant::whereIn('id', $toDelete)->delete();

        if ($request->variant_name) {
            foreach ($request->variant_name as $index => $name) {

                if (!$name) continue;

                $variantId  = $request->variant_id[$index] ?? null;
                $price      = $request->variant_price[$index] ?? 0;
                $stok       = $request->variant_stok[$index] ?? 0;

                if ($variantId) {
                    ProductVariant::where('id', $variantId)->update([
                        'variant_name' => $name,
                        'price'        => $price,
                        'stok'         => $stok,
                    ]);
                } else {
                    ProductVariant::create([
                        'product_id'   => $product->id,
                        'variant_name' => $name,
                        'price'        => $price,
                        'stok'         => $stok,
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Produk & varian berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return redirect()->route('admin.dashboard.index')->with('success', 'Produk berhasil dihapus');
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('product.show', compact('product'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::with('items.variant', 'items.product')->findOrFail($id);

        $newStatus = $request->status;
        $oldStatus = $order->status;

        foreach ($order->items as $item) {
            if ($item->variant) {
                $variant = $item->variant;
                if ($oldStatus !== 'batal' && $newStatus === 'batal') {
                    $variant->stok += $item->quantity;
                    $variant->save();
                }
                elseif ($oldStatus === 'batal' && $newStatus !== 'batal') {
                    $variant->stok -= $item->quantity;
                    $variant->save();
                }
            } else {
                $product = $item->product;
                if ($oldStatus !== 'batal' && $newStatus === 'batal') {
                    $product->stok += $item->quantity;
                    $product->save();
                } elseif ($oldStatus === 'batal' && $newStatus !== 'batal') {
                    $product->stok -= $item->quantity;
                    $product->save();
                }
            }
        }
        $order->status = $newStatus;
        $order->save();

        return response()->json([
            'success' => true,
            'status' => $order->status
        ]);
    }
}
