<?php

namespace App\Http\Controllers;

use App\Models\PhotoCard;
use App\Models\Store;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = PhotoCard::query()->with('store')->where('is_active', true)
            ->whereHas('store', fn ($q) => $q->where('is_active', true));

        if ($search = $request->get('q')) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($category = $request->get('category')) {
            $query->where('category', $category);
        }

        $photo_cards = $query->latest()->paginate(12)->withQueryString();

        $categories = PhotoCard::where('is_active', true)->whereNotNull('category')
            ->distinct()->pluck('category');

        $stores = Store::where('is_active', true)->withCount('photo_cards')->latest()->take(6)->get();

        return view('home', compact('photo_cards', 'categories', 'stores', 'search'));
    }
}
