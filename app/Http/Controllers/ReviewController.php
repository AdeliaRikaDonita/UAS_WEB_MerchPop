<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Order $order)
    {
        abort_unless($order->user_id === Auth::id(), 403);
        abort_unless($order->status === 'completed', 422, 'Pesanan belum selesai.');

        $request->validate([
            'store_id' => ['required', 'exists:stores,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:500'],
        ]);

        $order->reviews()->create([
            'store_id' => $request->store_id,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('status', 'Terima kasih atas ulasan kamu!');
    }
}
