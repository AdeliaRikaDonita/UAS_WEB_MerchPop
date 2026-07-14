<?php

namespace App\Http\Controllers;

use App\Models\Store;

class StoreController extends Controller
{
    public function show(Store $store)
    {
        $photo_cards = $store->photo_cards()->where('is_active', true)->latest()->paginate(9);
        $reviews = $store->reviews()->with('user')->latest()->take(5)->get();

        return view('stores.show', compact('store', 'photo_cards', 'reviews'));
    }
}
