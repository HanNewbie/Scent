<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Hash;
class DashboardController extends Controller
{
    public function index()
    {
        if (!Auth::guard('web')->check()) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

        $user = Auth::user();

        $orderItems = OrderItem::with(['product', 'variant', 'order'])
            ->whereHas('order', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->latest()
            ->get();

        $groupedOrders = $orderItems->groupBy('order_id');

        $latestOrders = $groupedOrders->take(3);
        $allOrders = $groupedOrders;

        $favorites = Favorite::with(['product.variants' => function ($q) {
            $q->orderBy('price', 'asc');
        }])
            ->where('user_id', $user->id)
            ->get()
            ->each(function ($fav) {
                $product = $fav->product;
                if (!$product) {
                    return;
                }
                $availableVariant = $product->variants
                    ->where('stok', '>', 0)
                    ->sortBy('price')
                    ->first();
                $cheapestVariant = $availableVariant ?? $product->variants->first();
                $product->display_price = $cheapestVariant->price ?? 0;
                $product->display_stok = $cheapestVariant->stok ?? 0;
                $product->display_variant = $cheapestVariant;
            });
        $favoriteCount = $favorites->count();   

        $deliveredOrders = $orderItems->filter(function($item) {
            return $item->order->status === 'terkirim';
        });

        $deliveredCount = $deliveredOrders->pluck('order_id')->unique()->count(); 
        $deliveredTotal = $deliveredOrders->sum(function($item) {
            $price = $item->variant->price ?? $item->product->price ?? 0;
            return $price * $item->quantity;
        });
        return view('user.dashboard', compact(
            'favorites',
            'favoriteCount',
            'latestOrders',
            'allOrders',
            'deliveredCount',
            'deliveredTotal'
        ));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'pos' => 'nullable|string|max:10',
            'current_password' => 'required_with:new_password|string',
            'new_password' => 'nullable|string|min:6',
        ]);

        $user->update($request->only(['name', 'email', 'phone', 'address', 'city', 'pos']));

        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password sekarang tidak sesuai.']);
            }

            $user->update([
                'password' => Hash::make($request->new_password),
            ]);
        }

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

}
