<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $query = Store::query()->with('user')->withCount('photo_cards');

        if ($search = $request->get('q')) {
            $query->where('name', 'like', "%{$search}%");
        }

        $stores = $query->latest()->paginate(15)->withQueryString();

        return view('admin.stores.index', compact('stores'));
    }

    public function toggle(Store $store)
    {
        $store->update(['is_active' => ! $store->is_active]);

        return back()->with('status', 'Status toko diperbarui.');
    }
}
