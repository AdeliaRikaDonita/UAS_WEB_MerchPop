@extends('layouts.app')
@section('title', $photoCard->name)
@section('content')

<nav class="text-sm text-blush-500 mb-4">
    <a href="{{ route('home') }}" class="hover:underline">Beranda</a> /
    <a href="{{ route('stores.show', $photoCard->store) }}" class="hover:underline">{{ $photoCard->store->name }}</a> /
    <span class="text-plum-800">{{ $photoCard->name }}</span>
</nav>

<div class="grid md:grid-cols-2 gap-8">
    <div class="aspect-square bg-white rounded-2xl border border-plum-100 flex items-center justify-center overflow-hidden">
        @if($photoCard->image)
            <img src="{{ asset('storage/'.$photoCard->image) }}" class="w-full h-full object-cover" alt="{{ $photoCard->name }}">
        @else
            <span class="text-8xl">✦</span>
        @endif
    </div>

    <div>
        <a href="{{ route('stores.show', $photoCard->store) }}" class="text-sm text-blush-500 hover:underline">{{ $photoCard->store->name }}</a>
        <h1 class="text-2xl font-bold text-plum-800 mt-1 mb-3">{{ $photoCard->name }}</h1>
        <p class="text-3xl font-extrabold text-blush-700 mb-4">Rp{{ number_format($photoCard->price, 0, ',', '.') }}</p>

        <p class="text-blush-600 mb-6 leading-relaxed">{{ $photoCard->description ?: 'Tidak ada deskripsi.' }}</p>

        <div class="flex items-center gap-3 mb-6 text-sm flex-wrap">
            <span class="px-3 py-1 rounded-full bg-blush-50 text-blush-700 border border-plum-200">
                Stok: {{ $photoCard->stock }}
            </span>
            <span class="px-3 py-1 rounded-full font-semibold
                @class([
                    'bg-emerald-50 text-emerald-700 border border-emerald-200' => $photoCard->condition === 'Mint',
                    'bg-sky-50 text-sky-700 border border-sky-200' => $photoCard->condition === 'Near Mint',
                    'bg-amber-50 text-amber-700 border border-amber-200' => $photoCard->condition === 'Good',
                    'bg-blush-50 text-blush-700 border border-blush-200' => $photoCard->condition === 'Sealed',
                ])">
                {{ $photoCard->condition }}
            </span>
            @if($photoCard->category)
            <span class="px-3 py-1 rounded-full bg-blush-50 text-blush-700 border border-plum-100">
                {{ $photoCard->category }}
            </span>
            @endif
        </div>

        @if($photoCard->stock > 0)
        <form action="{{ route('cart.add', $photoCard) }}" method="POST" class="flex items-center gap-3">
            @csrf
            <input type="number" name="qty" value="1" min="1" max="{{ $photoCard->stock }}"
                class="w-20 rounded-lg border-plum-200 border px-3 py-2 text-center">
            <button class="bg-blush-600 hover:bg-blush-700 text-white font-semibold px-6 py-2.5 rounded-lg transition">
                🛒 Tambah ke Keranjang
            </button>
        </form>
        @else
        <button disabled class="bg-plum-200 text-blush-500 font-semibold px-6 py-2.5 rounded-lg cursor-not-allowed">
            Stok Habis
        </button>
        @endif
    </div>
</div>

@if($related->count())
<h2 class="text-lg font-bold text-plum-800 mt-12 mb-4">Photocard Lain dari Toko Ini</h2>
<div class="grid grid-cols-2 sm:grid-cols-4 gap-5">
    @foreach($related as $r)
    <a href="{{ route('photo_cards.show', $r) }}" class="bg-white rounded-2xl border border-plum-100 overflow-hidden hover:shadow-md transition">
        <div class="aspect-square bg-blush-50 flex items-center justify-center">
            @if($r->image)
                <img src="{{ asset('storage/'.$r->image) }}" class="w-full h-full object-cover" alt="{{ $r->name }}">
            @else
                <span class="text-4xl">✦</span>
            @endif
        </div>
        <div class="p-3">
            <h3 class="font-semibold text-sm text-plum-900 line-clamp-2">{{ $r->name }}</h3>
            <p class="text-blush-700 font-bold text-sm mt-1">Rp{{ number_format($r->price, 0, ',', '.') }}</p>
        </div>
    </a>
    @endforeach
</div>
@endif

@endsection
