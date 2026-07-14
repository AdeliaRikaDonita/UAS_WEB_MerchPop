<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $store = Auth::user()->store;

        if (! $store) {
            return redirect()->route('seller.store.create');
        }

        $totalProducts = $store->photo_cards()->count();
        $totalOrders = OrderItem::where('store_id', $store->id)->distinct('order_id')->count('order_id');
        $totalRevenue = OrderItem::where('store_id', $store->id)
            ->whereHas('order', fn ($q) => $q->whereIn('status', ['paid', 'processing', 'shipped', 'completed']))
            ->sum('subtotal');
        $recentItems = OrderItem::where('store_id', $store->id)->with('order.user', 'photoCard')
            ->latest()->take(8)->get();

        $chartLabels = [];
        $chartData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartLabels[] = $date->translatedFormat('d M');
            $chartData[] = (float) OrderItem::where('store_id', $store->id)
                ->whereHas('order', fn ($q) => $q->whereIn('status', ['paid', 'processing', 'shipped', 'completed']))
                ->whereDate('created_at', $date->toDateString())
                ->sum('subtotal');
        }

        return view('seller.dashboard', compact(
            'store', 'totalProducts', 'totalOrders', 'totalRevenue', 'recentItems',
            'chartLabels', 'chartData'
        ));
    }
}
