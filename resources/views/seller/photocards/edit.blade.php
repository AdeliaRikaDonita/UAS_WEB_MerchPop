@extends('layouts.app')
@section('title', 'Edit Photocard')
@section('content')

<div class="max-w-xl mx-auto bg-white rounded-2xl border border-plum-100 p-8">
    <h1 class="text-xl font-bold text-plum-900 mb-6">Edit Photocard</h1>

    <form action="{{ route('seller.photo_cards.update', $photoCard) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium text-blush-700 mb-1">Nama Photocard</label>
            <input type="text" name="name" value="{{ old('name', $photoCard->name) }}" required class="w-full rounded-lg border-plum-200 border px-3 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium text-blush-700 mb-1">Deskripsi</label>
            <textarea name="description" rows="3" class="w-full rounded-lg border-plum-200 border px-3 py-2">{{ old('description', $photoCard->description) }}</textarea>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-blush-700 mb-1">Harga (Rp)</label>
                <input type="number" name="price" value="{{ old('price', $photoCard->price) }}" min="0" step="500" required class="w-full rounded-lg border-plum-200 border px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-blush-700 mb-1">Stok</label>
                <input type="number" name="stock" value="{{ old('stock', $photoCard->stock) }}" min="0" required class="w-full rounded-lg border-plum-200 border px-3 py-2">
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-blush-700 mb-1">Album / Grup</label>
                <input type="text" name="category" value="{{ old('category', $photoCard->category) }}" class="w-full rounded-lg border-plum-200 border px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-blush-700 mb-1">Kondisi</label>
                <select name="condition" required class="w-full rounded-lg border-plum-200 border px-3 py-2">
                    @foreach(['Mint', 'Near Mint', 'Good', 'Sealed'] as $cond)
                        <option value="{{ $cond }}" {{ old('condition', $photoCard->condition) == $cond ? 'selected' : '' }}>{{ $cond }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-blush-700 mb-1">Foto Photocard</label>
            @if($photoCard->image)
                <img src="{{ asset('storage/'.$photoCard->image) }}" class="w-20 h-20 object-cover rounded-lg mb-2">
            @endif
            <input type="file" name="image" accept="image/*" class="w-full text-sm">
        </div>
        <label class="flex items-center gap-2 text-sm text-blush-700">
            <input type="checkbox" name="is_active" value="1" {{ $photoCard->is_active ? 'checked' : '' }} class="rounded border-plum-300 text-blush-600">
            Photocard aktif (ditampilkan di toko)
        </label>
        <button class="w-full bg-blush-600 hover:bg-blush-700 text-white font-semibold py-2.5 rounded-lg transition">Simpan Perubahan</button>
    </form>
</div>
@endsection
