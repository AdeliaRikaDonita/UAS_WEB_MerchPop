@extends('layouts.app')
@section('title', 'Semua Pesanan')
@section('content')

<h1 class="text-2xl font-bold text-plum-800 mb-6">Semua Pesanan</h1>

<div class="bg-white rounded-xl border border-plum-100 divide-y divide-blush-50">
    @forelse($orders as $order)
    <a href="{{ route('admin.orders.show', $order) }}" class="block p-4 hover:bg-blush-50/50 transition">
        <div class="flex flex-wrap justify-between items-center gap-2">
            <div>
                <p class="font-semibold text-plum-900 text-sm">{{ $order->order_number }}</p>
                <p class="text-xs text-plum-400">{{ $order->user->name }} • {{ $order->created_at->translatedFormat('d M Y, H:i') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs font-semibold px-3 py-1 rounded-full
                    @class([
                        'bg-amber-100 text-amber-700' => $order->status == 'pending',
                        'bg-blue-100 text-blue-700' => in_array($order->status, ['paid','processing','shipped']),
                        'bg-plum-100 text-blush-700' => $order->status == 'completed',
                        'bg-red-100 text-red-700' => $order->status == 'cancelled',
                    ])">{{ ucfirst($order->status) }}</span>
                <span class="font-bold text-plum-800 text-sm">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
        </div>
    </a>
    @empty
    <p class="p-8 text-center text-plum-400 text-sm">Belum ada pesanan.</p>
    @endforelse
</div>
<div class="mt-6">{{ $orders->links() }}</div>

@endsection
