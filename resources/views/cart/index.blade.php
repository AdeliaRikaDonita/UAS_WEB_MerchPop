@extends('layouts.app')
@section('title', 'Keranjang Belanja')
@section('content')

<h1 class="text-2xl font-bold text-plum-800 mb-6">🛒 Keranjang Belanja</h1>

@if(empty($items))
    <div class="bg-white rounded-2xl border border-plum-100 p-12 text-center text-blush-500">
        <p class="mb-4">Keranjang kamu masih kosong.</p>
        <a href="{{ route('home') }}" class="bg-blush-600 hover:bg-blush-700 text-white font-semibold px-6 py-2.5 rounded-lg transition">Mulai Belanja</a>
    </div>
@else
<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-3">
        @foreach($items as $item)
        <div class="bg-white rounded-xl border border-plum-100 p-4 flex items-center gap-4">
            <div class="w-16 h-16 bg-blush-50 rounded-lg flex items-center justify-center shrink-0 overflow-hidden">
                @if($item['photoCard']->image)
                    <img src="{{ asset('storage/'.$item['photoCard']->image) }}" class="w-full h-full object-cover">
                @else
                    <span class="text-2xl">✦</span>
                @endif
            </div>
            <div class="flex-1">
                <p class="font-semibold text-plum-900 text-sm">{{ $item['photoCard']->name }}</p>
                <p class="text-xs text-plum-400">{{ $item['photoCard']->store->name }}</p>
                <p class="text-blush-700 font-bold text-sm mt-1">Rp{{ number_format($item['photoCard']->price, 0, ',', '.') }}</p>
            </div>
            <form action="{{ route('cart.update', $item['photoCard']) }}" method="POST" class="flex items-center gap-2">
                @csrf @method('PATCH')
                <input type="number" name="qty" value="{{ $item['qty'] }}" min="1" max="{{ $item['photoCard']->stock }}"
                    class="w-16 rounded-lg border-plum-200 border px-2 py-1.5 text-center text-sm">
                <button class="text-xs text-blush-600 hover:underline">Ubah</button>
            </form>
            <p class="font-bold text-plum-800 w-28 text-right text-sm">Rp{{ number_format($item['subtotal'], 0, ',', '.') }}</p>
            <form action="{{ route('cart.remove', $item['photoCard']) }}" method="POST">
                @csrf @method('DELETE')
                <button class="text-red-400 hover:text-red-600 text-sm">✕</button>
            </form>
        </div>
        @endforeach
    </div>

    <div class="bg-white rounded-2xl border border-plum-100 p-6 h-fit">
        <h2 class="font-bold text-plum-800 mb-4">Ringkasan</h2>
        <div class="flex justify-between text-sm text-blush-600 mb-2">
            <span>Total</span>
            <span class="font-bold text-plum-900 text-lg">Rp{{ number_format($total, 0, ',', '.') }}</span>
        </div>
        @auth
            @if(auth()->user()->isBuyer())
                <a href="{{ route('checkout.create') }}" class="block text-center w-full bg-blush-600 hover:bg-blush-700 text-white font-semibold py-2.5 rounded-lg mt-4 transition">
                    Lanjut ke Checkout
                </a>
            @else
                <p class="text-xs text-plum-400 mt-4 text-center">Hanya akun pembeli yang bisa checkout.</p>
            @endif
        @else
            <a href="{{ route('login') }}" class="block text-center w-full bg-blush-600 hover:bg-blush-700 text-white font-semibold py-2.5 rounded-lg mt-4 transition">
                Masuk untuk Checkout
            </a>
        @endauth
    </div>
</div>
@endif

@endsection
