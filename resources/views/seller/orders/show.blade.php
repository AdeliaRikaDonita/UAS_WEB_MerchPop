@extends('layouts.app')
@section('title', 'Detail Pesanan')
@section('content')

<div class="max-w-2xl mx-auto bg-white rounded-2xl border border-plum-100 p-8">
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-xl font-bold text-plum-900">{{ $order->order_number }}</h1>
            <p class="text-sm text-blush-500">{{ $order->created_at->translatedFormat('d F Y, H:i') }}</p>
        </div>
        <span class="text-xs font-semibold px-3 py-1 rounded-full
            @class([
                'bg-amber-100 text-amber-700' => $order->status == 'pending',
                'bg-blue-100 text-blue-700' => in_array($order->status, ['paid','processing','shipped']),
                'bg-plum-100 text-blush-700' => $order->status == 'completed',
                'bg-red-100 text-red-700' => $order->status == 'cancelled',
            ])">{{ ucfirst($order->status) }}</span>
    </div>

    <div class="mb-6">
        <p class="text-xs text-plum-400 mb-1">Pembeli</p>
        <p class="text-sm text-plum-800 font-medium">{{ $order->user->name }}</p>
        <p class="text-sm text-blush-600">{{ $order->shipping_address }}</p>
        <p class="text-sm text-blush-600">📞 {{ $order->phone }}</p>
    </div>

    <table class="w-full text-sm mb-6">
        <thead>
            <tr class="text-plum-400 text-xs uppercase">
                <th class="text-left pb-2">Item</th>
                <th class="text-center pb-2">Qty</th>
                <th class="text-right pb-2">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr class="border-t border-blush-50">
                <td class="py-2 text-plum-900">{{ $item->item_name }}</td>
                <td class="text-center py-2 text-blush-700">{{ $item->qty }}</td>
                <td class="text-right py-2 font-medium text-plum-900">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="flex justify-between font-bold text-plum-900 border-t border-plum-100 pt-4 mb-6">
        <span>Total (item toko ini)</span>
        <span>Rp{{ number_format($order->items->sum('subtotal'), 0, ',', '.') }}</span>
    </div>

    <form action="{{ route('seller.orders.status', $order) }}" method="POST" class="flex items-center gap-3">
        @csrf @method('PATCH')
        <select name="status" class="rounded-lg border-plum-200 border px-3 py-2 text-sm flex-1">
            @foreach(['pending','paid','processing','shipped','completed','cancelled'] as $status)
                <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
        <button class="bg-blush-600 hover:bg-blush-700 text-white text-sm font-semibold px-5 py-2 rounded-lg transition">Update Status</button>
    </form>
</div>
@endsection
