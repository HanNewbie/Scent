<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderItem;
use App\Models\ProductVariant;

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

        $favorites = Favorite::with('product')
            ->where('user_id', $user->id)
            ->get();
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
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'pos' => 'nullable|string|max:10',
        ]);

        $user->update($request->only(['name', 'email', 'phone', 'address', 'city', 'pos']));

        return back()->with('success', 'Profil berhasil diperbarui!');
    }



}
