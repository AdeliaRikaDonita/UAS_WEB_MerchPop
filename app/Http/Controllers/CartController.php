<?php

namespace App\Http\Controllers;

use App\Models\PhotoCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
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

        return view('cart.index', compact('items', 'total'));
    }

    public function add(Request $request, PhotoCard $photoCard)
    {
        $qty = max(1, (int) $request->input('qty', 1));

        if ($photoCard->stock < 1) {
            return back()->with('error', 'Maaf, stok photocard ini sedang habis.');
        }

        $cart = Session::get('cart', []);
        $cart[$photoCard->id] = min(($cart[$photoCard->id] ?? 0) + $qty, $photoCard->stock);
        Session::put('cart', $cart);

        return back()->with('status', "{$photoCard->name} ditambahkan ke keranjang.");
    }

    public function update(Request $request, PhotoCard $photoCard)
    {
        $qty = (int) $request->input('qty', 1);
        $cart = Session::get('cart', []);

        if ($qty <= 0) {
            unset($cart[$photoCard->id]);
        } else {
            $cart[$photoCard->id] = min($qty, $photoCard->stock);
        }

        Session::put('cart', $cart);

        return back()->with('status', 'Keranjang diperbarui.');
    }

    public function remove(PhotoCard $photoCard)
    {
        $cart = Session::get('cart', []);
        unset($cart[$photoCard->id]);
        Session::put('cart', $cart);

        return back()->with('status', 'Item dihapus dari keranjang.');
    }
}
