<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\PhotoCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PhotoCardController extends Controller
{
    public function index()
    {
        $store = Auth::user()->store;
        abort_unless($store, 404, 'Buat toko terlebih dahulu.');

        $photo_cards = $store->photo_cards()->latest()->paginate(10);

        return view('seller.photocards.index', compact('photo_cards'));
    }

    public function create()
    {
        abort_unless(Auth::user()->store, 404, 'Buat toko terlebih dahulu.');

        return view('seller.photocards.create');
    }

    public function store(Request $request)
    {
        $store = Auth::user()->store;
        abort_unless($store, 404);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'category' => ['nullable', 'string', 'max:100'],
            'condition' => ['required', 'in:Mint,Near Mint,Good,Sealed'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('photo_cards', 'public');
        }

        $data['slug'] = Str::slug($data['name']).'-'.Str::random(5);

        $store->photo_cards()->create($data);

        return redirect()->route('seller.photo_cards.index')->with('status', 'Photocard berhasil ditambahkan.');
    }

    public function edit(PhotoCard $photoCard)
    {
        $this->authorizeOwnership($photoCard);

        return view('seller.photocards.edit', compact('photoCard'));
    }

    public function update(Request $request, PhotoCard $photoCard)
    {
        $this->authorizeOwnership($photoCard);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'category' => ['nullable', 'string', 'max:100'],
            'condition' => ['required', 'in:Mint,Near Mint,Good,Sealed'],
            'is_active' => ['sometimes', 'boolean'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('photo_cards', 'public');
        }

        $photoCard->update($data);

        return redirect()->route('seller.photo_cards.index')->with('status', 'Photocard berhasil diperbarui.');
    }

    public function destroy(PhotoCard $photoCard)
    {
        $this->authorizeOwnership($photoCard);
        $photoCard->delete();

        return back()->with('status', 'Photocard dihapus.');
    }

    private function authorizeOwnership(PhotoCard $photoCard): void
    {
        abort_unless(Auth::user()->store && $photoCard->store_id === Auth::user()->store->id, 403);
    }
}
