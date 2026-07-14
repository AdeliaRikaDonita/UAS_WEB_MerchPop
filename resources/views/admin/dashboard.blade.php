@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('content')

<h1 class="text-2xl font-display font-bold text-plum-800 mb-6">⚙️ Admin Panel</h1>

<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
    <div class="bg-white border border-blush-100 rounded-xl p-5">
        <p class="text-xs text-plum-400 mb-1">Total Pengguna</p>
        <p class="text-2xl font-bold text-plum-800">{{ $totalUsers }}</p>
        <p class="text-xs text-plum-400 mt-1">{{ $totalSellers }} seller • {{ $totalBuyers }} buyer</p>
    </div>
    <div class="bg-white border border-blush-100 rounded-xl p-5">
        <p class="text-xs text-plum-400 mb-1">Toko Terdaftar</p>
        <p class="text-2xl font-bold text-plum-800">{{ $totalStores }}</p>
    </div>
    <div class="bg-white border border-blush-100 rounded-xl p-5">
        <p class="text-xs text-plum-400 mb-1">Total Photocard</p>
        <p class="text-2xl font-bold text-plum-800">{{ $totalProducts }}</p>
    </div>
    <div class="bg-white border border-blush-100 rounded-xl p-5">
        <p class="text-xs text-plum-400 mb-1">Total Pesanan</p>
        <p class="text-2xl font-bold text-plum-800">{{ $totalOrders }}</p>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-4 mb-8">
    <div class="bg-gradient-to-br from-blush-500 to-blush-600 rounded-xl p-6 lg:col-span-1 flex flex-col justify-center">
        <p class="text-xs text-white/80 mb-1">Total Pendapatan Platform</p>
        <p class="text-3xl font-display font-extrabold text-white">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white border border-blush-100 rounded-xl p-6 lg:col-span-2">
        <p class="text-sm font-semibold text-plum-700 mb-3">Pendapatan 7 Hari Terakhir</p>
        <canvas id="revenueChart" height="90"></canvas>
    </div>
</div>

<div class="flex gap-3 mb-8">
    <a href="{{ route('admin.users.index') }}" class="bg-white border border-blush-200 text-plum-700 text-sm font-semibold px-5 py-2.5 rounded-lg hover:bg-blush-50 transition">Kelola Pengguna</a>
    <a href="{{ route('admin.stores.index') }}" class="bg-white border border-blush-200 text-plum-700 text-sm font-semibold px-5 py-2.5 rounded-lg hover:bg-blush-50 transition">Kelola Toko</a>
    <a href="{{ route('admin.orders.index') }}" class="bg-white border border-blush-200 text-plum-700 text-sm font-semibold px-5 py-2.5 rounded-lg hover:bg-blush-50 transition">Semua Pesanan</a>
</div>

<h2 class="font-semibold text-plum-700 mb-3">Pesanan Terbaru</h2>
<div class="bg-white border border-blush-100 rounded-xl divide-y divide-blush-50">
    @forelse($recentOrders as $order)
    <a href="{{ route('admin.orders.show', $order) }}" class="p-4 flex justify-between items-center text-sm hover:bg-blush-50/50 transition">
        <div>
            <p class="font-medium text-plum-900">{{ $order->order_number }}</p>
            <p class="text-xs text-plum-400">{{ $order->user->name }}</p>
        </div>
        <span class="font-semibold text-blush-600">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
    </a>
    @empty
    <p class="p-6 text-center text-plum-400 text-sm">Belum ada pesanan.</p>
    @endforelse
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
    const ctx = document.getElementById('revenueChart');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: {!! json_encode($chartData) !!},
                borderColor: '#FF6FB0',
                backgroundColor: 'rgba(255, 111, 176, 0.12)',
                tension: 0.35,
                fill: true,
                pointBackgroundColor: '#FF6FB0',
                pointRadius: 4,
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: {
                x: { ticks: { color: '#9C6E90' }, grid: { color: 'rgba(255,111,176,0.08)' } },
                y: { ticks: { color: '#9C6E90' }, grid: { color: 'rgba(255,111,176,0.08)' } },
            }
        }
    });
</script>

@endsection
