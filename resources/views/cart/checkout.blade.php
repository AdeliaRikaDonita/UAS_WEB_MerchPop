@extends('layouts.app')
@section('title', 'Checkout')
@section('content')

<h1 class="text-2xl font-bold text-plum-800 mb-6">Checkout</h1>

<div class="grid lg:grid-cols-3 gap-6">
    <form action="{{ route('checkout.store') }}" method="POST" class="lg:col-span-2 bg-white rounded-2xl border border-plum-100 p-6 space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-blush-700 mb-1">Alamat Pengiriman</label>
            <textarea name="shipping_address" rows="3" required
                class="w-full rounded-lg border-plum-200 border px-3 py-2">{{ old('shipping_address', auth()->user()->address) }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-blush-700 mb-1">No. HP</label>
            <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}" required
                class="w-full rounded-lg border-plum-200 border px-3 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium text-blush-700 mb-2">Metode Pembayaran</label>
            <div class="grid grid-cols-2 gap-3">
                <label class="flex items-center gap-2 border rounded-xl p-3 cursor-pointer has-[:checked]:border-blush-600 has-[:checked]:bg-blush-50 border-plum-200">
                    <input type="radio" name="payment_method" value="cod" checked class="text-blush-600">
                    <span class="text-sm">Bayar di Tempat (COD)</span>
                </label>
                <label class="flex items-center gap-2 border rounded-xl p-3 cursor-pointer has-[:checked]:border-blush-600 has-[:checked]:bg-blush-50 border-plum-200">
                    <input type="radio" name="payment_method" value="transfer" class="text-blush-600">
                    <span class="text-sm">Transfer Bank</span>
                </label>
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-blush-700 mb-1">Catatan (opsional)</label>
            <textarea name="notes" rows="2" class="w-full rounded-lg border-plum-200 border px-3 py-2">{{ old('notes') }}</textarea>
        </div>
        <button class="w-full bg-blush-600 hover:bg-blush-700 text-white font-semibold py-3 rounded-lg transition">
            Buat Pesanan
        </button>
    </form>

    <div class="bg-white rounded-2xl border border-plum-100 p-6 h-fit">
        <h2 class="font-bold text-plum-800 mb-4">Ringkasan Pesanan</h2>
        <div class="space-y-2 mb-4 max-h-64 overflow-y-auto">
            @foreach($items as $item)
            <div class="flex justify-between text-sm">
                <span class="text-blush-600">{{ $item['photoCard']->name }} x{{ $item['qty'] }}</span>
                <span class="font-medium text-plum-800">Rp{{ number_format($item['subtotal'], 0, ',', '.') }}</span>
            </div>
            @endforeach
        </div>
        <div class="border-t border-plum-100 pt-3 flex justify-between font-bold text-plum-900">
            <span>Total</span>
            <span>Rp{{ number_format($total, 0, ',', '.') }}</span>
        </div>
    </div>
</div>

@endsection
