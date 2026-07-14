@extends('layouts.app')
@section('title', 'Tambah Photocard')
@section('content')

<div class="max-w-xl mx-auto bg-white rounded-2xl border border-plum-100 p-8">
    <h1 class="text-xl font-bold text-plum-900 mb-6">Tambah Photocard Baru</h1>

    <form action="{{ route('seller.photo_cards.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-blush-700 mb-1">Nama Photocard</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-lg border-plum-200 border px-3 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium text-blush-700 mb-1">Deskripsi</label>
            <textarea name="description" rows="3" class="w-full rounded-lg border-plum-200 border px-3 py-2">{{ old('description') }}</textarea>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-blush-700 mb-1">Harga (Rp)</label>
                <input type="number" name="price" value="{{ old('price') }}" min="0" step="500" required class="w-full rounded-lg border-plum-200 border px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-blush-700 mb-1">Stok</label>
                <input type="number" name="stock" value="{{ old('stock') }}" min="0" required class="w-full rounded-lg border-plum-200 border px-3 py-2">
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-blush-700 mb-1">Album / Grup</label>
                <input type="text" name="category" value="{{ old('category') }}" placeholder="cth: NewJeans — Get Up" class="w-full rounded-lg border-plum-200 border px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-blush-700 mb-1">Kondisi</label>
                <select name="condition" required class="w-full rounded-lg border-plum-200 border px-3 py-2">
                    @foreach(['Mint', 'Near Mint', 'Good', 'Sealed'] as $cond)
                        <option value="{{ $cond }}" {{ old('condition') == $cond ? 'selected' : '' }}>{{ $cond }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-blush-700 mb-1">Foto Photocard</label>
            <input type="file" name="image" accept="image/*" class="w-full text-sm">
        </div>
        <button class="w-full bg-blush-600 hover:bg-blush-700 text-white font-semibold py-2.5 rounded-lg transition">Simpan Photocard</button>
    </form>
</div>
@endsection
