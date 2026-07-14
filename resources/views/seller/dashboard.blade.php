@extends('layouts.app')
@section('title', 'Dashboard Toko')
@section('content')

<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-display font-bold text-plum-800">✦ {{ $store->name }}</h1>
        <p class="text-sm text-plum-400">Dashboard Penjual</p>
    </div>
    <a href="{{ route('seller.store.edit') }}" class="text-sm text-blush-600 border border-blush-200 px-4 py-2 rounded-lg hover:bg-blush-50 transition">Edit Toko</a>
</div>

<div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white border border-blush-100 rounded-xl p-5">
        <p class="text-xs text-plum-400 mb-1">Total Photocard</p>
        <p class="text-2xl font-bold text-plum-800">{{ $totalProducts }}</p>
    </div>
    <div class="bg-white border border-blush-100 rounded-xl p-5">
        <p class="text-xs text-plum-400 mb-1">Total Pesanan</p>
        <p class="text-2xl font-bold text-plum-800">{{ $totalOrders }}</p>
    </div>
    <div class="bg-gradient-to-br from-blush-500 to-blush-600 rounded-xl p-5">
        <p class="text-xs text-white/80 mb-1">Pendapatan</p>
        <p class="text-2xl font-bold text-white">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>
</div>

<div class="bg-white border border-blush-100 rounded-xl p-6 mb-8">
    <p class="text-sm font-semibold text-plum-700 mb-3">Pendapatan 7 Hari Terakhir</p>
    <canvas id="revenueChart" height="80"></canvas>
</div>

<div class="flex gap-3 mb-8">
    <a href="{{ route('seller.photo_cards.index') }}" class="bg-blush-500 hover:bg-blush-600 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition">Kelola Photocard</a>
    <a href="{{ route('seller.orders.index') }}" class="bg-white border border-blush-200 text-plum-700 text-sm font-semibold px-5 py-2.5 rounded-lg hover:bg-blush-50 transition">Lihat Pesanan</a>
</div>

<h2 class="font-semibold text-plum-700 mb-3">Aktivitas Terbaru</h2>
<div class="bg-white border border-blush-100 rounded-xl divide-y divide-blush-50">
    @forelse($recentItems as $item)
    <div class="p-4 flex justify-between items-center text-sm">
        <div>
            <p class="font-medium text-plum-900">{{ $item->item_name }} <span class="text-plum-400">x{{ $item->qty }}</span></p>
            <p class="text-xs text-plum-400">Pesanan {{ $item->order->order_number ?? '-' }} oleh {{ $item->order->user->name ?? '-' }}</p>
        </div>
        <span class="font-semibold text-blush-600">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</span>
    </div>
    @empty
    <p class="p-6 text-center text-plum-400 text-sm">Belum ada aktivitas.</p>
    @endforelse
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
    const ctx = document.getElementById('revenueChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: {!! json_encode($chartData) !!},
                backgroundColor: '#FF6FB0',
                borderRadius: 6,
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: {
                x: { ticks: { color: '#9C6E90' }, grid: { display: false } },
                y: { ticks: { color: '#9C6E90' }, grid: { color: 'rgba(255,111,176,0.08)' } },
            }
        }
    });
</script>

@endsection
