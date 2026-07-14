<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StoreController extends Controller
{
    public function create()
    {
        if (Auth::user()->store) {
            return redirect()->route('seller.dashboard');
        }

        return view('seller.store.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'address' => ['nullable', 'string', 'max:500'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $slug = Str::slug($request->name).'-'.Str::random(5);

        Auth::user()->store()->create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        return redirect()->route('seller.dashboard')->with('status', 'Toko berhasil dibuat!');
    }

    public function edit()
    {
        $store = Auth::user()->store;
        abort_unless($store, 404);

        return view('seller.store.edit', compact('store'));
    }

    public function update(Request $request)
    {
        $store = Auth::user()->store;
        abort_unless($store, 404);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'address' => ['nullable', 'string', 'max:500'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $store->update($request->only('name', 'description', 'address', 'phone'));

        return redirect()->route('seller.dashboard')->with('status', 'Profil toko diperbarui.');
    }
}
