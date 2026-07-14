<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $store = Auth::user()->store;
        abort_unless($store, 404);

        $orders = Order::whereHas('items', fn ($q) => $q->where('store_id', $store->id))
            ->with(['items' => fn ($q) => $q->where('store_id', $store->id), 'user'])
            ->latest()->paginate(10);

        return view('seller.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $store = Auth::user()->store;
        abort_unless($store, 404);
        abort_unless($order->items()->where('store_id', $store->id)->exists(), 403);

        $order->load(['items' => fn ($q) => $q->where('store_id', $store->id), 'user']);

        return view('seller.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $store = Auth::user()->store;
        abort_unless($store, 404);
        abort_unless($order->items()->where('store_id', $store->id)->exists(), 403);

        $request->validate([
            'status' => ['required', 'in:pending,paid,processing,shipped,completed,cancelled'],
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('status', 'Status pesanan diperbarui.');
    }
}
