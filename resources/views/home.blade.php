@extends('layouts.app')
@section('title', 'Jelajahi Photocard')
@section('content')

<div class="rounded-3xl p-8 sm:p-10 mb-8 relative overflow-hidden bg-lav-50">
    <div class="absolute inset-0 opacity-30" style="background: linear-gradient(115deg, #FF8FC4 0%, #FFB6DC 25%, #FFD1E8 50%, #FFA6D4 75%, #FF8FC4 100%); background-size: 300% 300%; animation: holoshift 10s ease infinite;"></div>
    <div class="relative z-10 max-w-xl">
        <span class="inline-block text-xs font-bold bg-white text-blush-600 px-3 py-1.5 rounded-full mb-4">Marketplace photocard terpercaya</span>
        <h1 class="text-2xl sm:text-3xl font-display font-extrabold text-plum-800 mb-3 leading-snug">Koleksi photocard bias kamu, aman &amp; original</h1>
        <p class="text-plum-500 mb-6 text-sm">Jual beli photocard, album, dan merch resmi langsung dari sesama fans.</p>
        <form action="{{ route('home') }}" method="GET" class="flex gap-2 bg-white rounded-full p-1.5 max-w-md shadow-sm">
            <input type="text" name="q" value="{{ $search ?? '' }}" placeholder="Cari nama idol, grup, atau album..."
                class="flex-1 border-0 focus:ring-0 rounded-full px-4 text-plum-900 text-sm">
            <button class="bg-plum-800 hover:bg-plum-900 text-white text-sm font-semibold px-5 py-2 rounded-full transition">Cari</button>
        </form>
    </div>
</div>

@if($categories->count())
<div class="flex flex-wrap gap-2 mb-8">
    <a href="{{ route('home') }}" class="text-xs font-semibold px-4 py-2 rounded-full border {{ !request('category') ? 'bg-plum-800 text-white border-plum-800' : 'border-blush-200 text-plum-600 hover:bg-blush-50' }}">Semua</a>
    @foreach($categories as $cat)
        <a href="{{ route('home', ['category' => $cat]) }}" class="text-xs font-semibold px-4 py-2 rounded-full border {{ request('category') == $cat ? 'bg-plum-800 text-white border-plum-800' : 'border-blush-200 text-plum-600 hover:bg-blush-50' }}">{{ $cat }}</a>
    @endforeach
</div>
@endif

<h2 class="text-xl font-display font-bold text-plum-800 mb-4">Baru ditambahkan</h2>

@if($photo_cards->isEmpty())
    <div class="bg-white rounded-2xl border border-blush-100 p-12 text-center text-plum-400">
        Belum ada photocard yang cocok. Coba kata kunci lain ya.
    </div>
@else
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5">
    @foreach($photo_cards as $photoCard)
    <a href="{{ route('photo_cards.show', $photoCard) }}" class="bg-white rounded-2xl border border-blush-100 overflow-hidden hover:shadow-lg transition group">
        <div class="aspect-[3/4] bg-lav-50 flex items-center justify-center overflow-hidden relative">
            @if($photoCard->image)
                <img src="{{ asset('storage/'.$photoCard->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition" alt="{{ $photoCard->name }}">
            @else
                <div class="absolute inset-0 opacity-50" style="background: linear-gradient(115deg, #FF8FC4 0%, #FFB6DC 25%, #FFD1E8 50%, #FFA6D4 75%, #FF8FC4 100%); background-size: 250% 250%; animation: holoshift 7s ease infinite;"></div>
                <span class="text-4xl relative z-10">✦</span>
            @endif
            @if($photoCard->category)
            <span class="absolute top-2 left-2 z-10 bg-white text-blush-600 text-[10px] font-bold px-2.5 py-1 rounded-full">{{ $photoCard->category }}</span>
            @endif
            <span class="absolute top-2 right-2 z-10 text-[10px] font-bold px-2.5 py-1 rounded-full
                @class([
                    'bg-emerald-500 text-white' => $photoCard->condition === 'Mint',
                    'bg-sky-500 text-white' => $photoCard->condition === 'Near Mint',
                    'bg-amber-500 text-white' => $photoCard->condition === 'Good',
                    'bg-blush-500 text-white' => $photoCard->condition === 'Sealed',
                ])">{{ $photoCard->condition }}</span>
        </div>
        <div class="p-3">
            <p class="text-[11px] text-plum-400 font-medium mb-1">{{ $photoCard->store->name }}</p>
            <h3 class="font-semibold text-plum-900 text-sm line-clamp-2">{{ $photoCard->name }}</h3>
            <p class="text-blush-600 font-bold mt-1 text-sm">Rp{{ number_format($photoCard->price, 0, ',', '.') }}</p>
            @if($photoCard->stock < 1)
                <span class="text-xs text-red-500 font-medium">Stok habis</span>
            @endif
        </div>
    </a>
    @endforeach
</div>
<div class="mt-8">{{ $photo_cards->links() }}</div>
@endif

@if($stores->count())
<h2 class="text-xl font-display font-bold text-plum-800 mt-12 mb-4">Toko pilihan</h2>
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
    @foreach($stores as $store)
    <a href="{{ route('stores.show', $store) }}" class="bg-white rounded-xl border border-blush-100 p-4 text-center hover:shadow-md transition">
        <div class="w-14 h-14 mx-auto rounded-full flex items-center justify-center text-xl mb-2" style="background: linear-gradient(115deg, #FF8FC4, #FFD1E8, #FF8FC4); background-size: 250% 250%; animation: holoshift 8s ease infinite;">✦</div>
        <p class="text-xs font-semibold text-plum-800 line-clamp-1">{{ $store->name }}</p>
        <p class="text-[11px] text-plum-400">{{ $store->photo_cards_count }} photocard</p>
    </a>
    @endforeach
</div>
@endif

@endsection
