@extends('layouts.app')
@section('title', 'Pesanan Saya')
@section('content')

<h1 class="text-2xl font-bold text-plum-800 mb-6">📦 Pesanan Saya</h1>

@if($orders->isEmpty())
    <div class="bg-white rounded-2xl border border-plum-100 p-12 text-center text-blush-500">
        Belum ada pesanan. <a href="{{ route('home') }}" class="text-blush-700 font-semibold hover:underline">Mulai belanja</a>
    </div>
@else
<div class="space-y-3">
    @foreach($orders as $order)
    <a href="{{ route('orders.show', $order) }}" class="block bg-white rounded-xl border border-plum-100 p-4 hover:shadow-md transition">
        <div class="flex flex-wrap justify-between items-center gap-2">
            <div>
                <p class="font-semibold text-plum-900 text-sm">{{ $order->order_number }}</p>
                <p class="text-xs text-plum-400">{{ $order->created_at->translatedFormat('d M Y, H:i') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs font-semibold px-3 py-1 rounded-full
                    @class([
                        'bg-amber-100 text-amber-700' => $order->status == 'pending',
                        'bg-blue-100 text-blue-700' => in_array($order->status, ['paid','processing','shipped']),
                        'bg-plum-100 text-blush-700' => $order->status == 'completed',
                        'bg-red-100 text-red-700' => $order->status == 'cancelled',
                    ])">
                    {{ ucfirst($order->status) }}
                </span>
                <span class="font-bold text-plum-800 text-sm">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
        </div>
    </a>
    @endforeach
</div>
<div class="mt-6">{{ $orders->links() }}</div>
@endif

@endsection
