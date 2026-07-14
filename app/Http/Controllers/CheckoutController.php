<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PhotoCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function create()
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kamu masih kosong.');
        }

        $items = [];
        $total = 0;

        foreach ($cart as $productId => $qty) {
            $photoCard = PhotoCard::with('store')->find($productId);
            if (! $photoCard) {
                continue;
            }
            $subtotal = $photoCard->price * $qty;
            $total += $subtotal;
            $items[] = compact('photoCard', 'qty', 'subtotal');
        }

        return view('cart.checkout', compact('items', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => ['required', 'string', 'max:500'],
            'phone' => ['required', 'string', 'max:20'],
            'payment_method' => ['required', 'in:cod,transfer'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kamu masih kosong.');
        }

        $order = DB::transaction(function () use ($cart, $request) {
            $total = 0;
            $lineItems = [];

            foreach ($cart as $productId => $qty) {
                $photoCard = PhotoCard::lockForUpdate()->find($productId);

                if (! $photoCard || $photoCard->stock < $qty) {
                    abort(422, "Stok untuk {$photoCard?->name} tidak mencukupi.");
                }

                $subtotal = $photoCard->price * $qty;
                $total += $subtotal;

                $lineItems[] = [
                    'photoCard' => $photoCard,
                    'qty' => $qty,
                    'subtotal' => $subtotal,
                ];
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => Order::generateOrderNumber(),
                'status' => 'pending',
                'total_amount' => $total,
                'shipping_address' => $request->shipping_address,
                'phone' => $request->phone,
                'payment_method' => $request->payment_method,
                'notes' => $request->notes,
            ]);

            foreach ($lineItems as $line) {
                $order->items()->create([
                    'photo_card_id' => $line['photoCard']->id,
                    'store_id' => $line['photoCard']->store_id,
                    'item_name' => $line['photoCard']->name,
                    'price' => $line['photoCard']->price,
                    'qty' => $line['qty'],
                    'subtotal' => $line['subtotal'],
                ]);

                $line['photoCard']->decrement('stock', $line['qty']);
            }

            return $order;
        });

        Session::forget('cart');

        return redirect()->route('orders.show', $order)
            ->with('status', 'Pesanan berhasil dibuat! Berikut adalah bill/struk pesanan kamu.');
    }
}
