@extends('layouts.app')
@section('title', 'Buat Toko')
@section('content')

<div class="max-w-lg mx-auto bg-white rounded-2xl border border-plum-100 p-8">
    <h1 class="text-xl font-bold text-plum-900 mb-1">✦ Lengkapi Profil Toko Kamu</h1>
    <p class="text-sm text-blush-500 mb-6">Sebelum mulai jualan, buat dulu profil tokomu.</p>

    <form action="{{ route('seller.store.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-blush-700 mb-1">Nama Toko</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                class="w-full rounded-lg border-plum-200 border px-3 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium text-blush-700 mb-1">Deskripsi</label>
            <textarea name="description" rows="3" class="w-full rounded-lg border-plum-200 border px-3 py-2">{{ old('description') }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-blush-700 mb-1">Alamat</label>
            <textarea name="address" rows="2" class="w-full rounded-lg border-plum-200 border px-3 py-2">{{ old('address') }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-blush-700 mb-1">No. HP Toko</label>
            <input type="text" name="phone" value="{{ old('phone') }}" class="w-full rounded-lg border-plum-200 border px-3 py-2">
        </div>
        <button class="w-full bg-blush-600 hover:bg-blush-700 text-white font-semibold py-2.5 rounded-lg transition">
            Buat Toko
        </button>
    </form>
</div>
@endsection
