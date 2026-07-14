@extends('layouts.app')
@section('title', $store->name)
@section('content')

<div class="bg-white rounded-2xl border border-plum-100 p-6 mb-8 flex flex-col sm:flex-row gap-5 items-start sm:items-center">
    <div class="w-20 h-20 rounded-full bg-plum-100 flex items-center justify-center text-4xl shrink-0">✦</div>
    <div class="flex-1">
        <h1 class="text-2xl font-bold text-plum-900">{{ $store->name }}</h1>
        <p class="text-blush-500 text-sm mt-1">{{ $store->description ?: 'Toko pilihan di MerchPopRika.' }}</p>
        <div class="flex flex-wrap gap-4 text-sm text-blush-600 mt-3">
            @if($store->address)<span>📍 {{ $store->address }}</span>@endif
            @if($store->phone)<span>📞 {{ $store->phone }}</span>@endif
            <span>⭐ {{ $store->averageRating() ?: '-' }} ({{ $store->reviews()->count() }} ulasan)</span>
        </div>
    </div>
</div>

<h2 class="text-lg font-bold text-plum-800 mb-4">Photocard dari {{ $store->name }}</h2>
@if($photo_cards->isEmpty())
    <div class="bg-white rounded-2xl border border-plum-100 p-10 text-center text-blush-500">Toko ini belum punya photocard.</div>
@else
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5 mb-6">
    @foreach($photo_cards as $photoCard)
    <a href="{{ route('photo_cards.show', $photoCard) }}" class="bg-white rounded-2xl border border-plum-100 overflow-hidden hover:shadow-md transition">
        <div class="aspect-square bg-blush-50 flex items-center justify-center">
            @if($photoCard->image)
                <img src="{{ asset('storage/'.$photoCard->image) }}" class="w-full h-full object-cover" alt="{{ $photoCard->name }}">
            @else
                <span class="text-5xl">✦</span>
            @endif
        </div>
        <div class="p-3">
            <h3 class="font-semibold text-sm text-plum-900 line-clamp-2">{{ $photoCard->name }}</h3>
            <p class="text-blush-700 font-bold text-sm mt-1">Rp{{ number_format($photoCard->price, 0, ',', '.') }}</p>
        </div>
    </a>
    @endforeach
</div>
{{ $photo_cards->links() }}
@endif

@if($reviews->count())
<h2 class="text-lg font-bold text-plum-800 mt-10 mb-4">Ulasan Pembeli</h2>
<div class="space-y-3">
    @foreach($reviews as $review)
    <div class="bg-white rounded-xl border border-plum-100 p-4">
        <div class="flex justify-between items-center mb-1">
            <span class="font-semibold text-sm text-plum-800">{{ $review->user->name }}</span>
            <span class="text-amber-500 text-sm">{{ str_repeat('⭐', $review->rating) }}</span>
        </div>
        <p class="text-sm text-blush-600">{{ $review->comment }}</p>
    </div>
    @endforeach
</div>
@endif

@endsection
