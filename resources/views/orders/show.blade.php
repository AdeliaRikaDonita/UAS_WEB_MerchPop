@extends('layouts.app')
@section('title', 'Bill Pesanan '.$order->order_number)
@section('content')

<div class="max-w-2xl mx-auto">

    <div class="flex items-center justify-between mb-4 print:hidden">
        <a href="{{ route('orders.index') }}" class="text-sm text-blush-600 hover:underline">&larr; Kembali ke Pesanan Saya</a>
        <button onclick="window.print()" class="text-sm bg-blush-600 hover:bg-blush-700 text-white font-semibold px-4 py-2 rounded-lg transition">
            🖨️ Cetak / Simpan PDF
        </button>
    </div>

    {{-- BILL / STRUK PESANAN --}}
    <div class="bg-white rounded-2xl border border-plum-100 p-8 shadow-sm" id="bill">

        <div class="text-center border-b-2 border-dashed border-plum-200 pb-5 mb-5">
            <p class="text-2xl">✦</p>
            <h1 class="text-xl font-bold text-plum-800">MerchPopRika</h1>
            <p class="text-xs text-plum-400">Struk / Bukti Pesanan</p>
        </div>

        <div class="flex justify-between text-sm mb-1">
            <span class="text-blush-500">No. Pesanan</span>
            <span class="font-semibold text-plum-900">{{ $order->order_number }}</span>
        </div>
        <div class="flex justify-between text-sm mb-1">
            <span class="text-blush-500">Tanggal</span>
            <span class="font-medium text-plum-800">{{ $order->created_at->translatedFormat('d F Y, H:i') }}</span>
        </div>
        <div class="flex justify-between text-sm mb-1">
            <span class="text-blush-500">Status</span>
            <span class="font-semibold px-2 py-0.5 rounded-full text-xs
                @class([
                    'bg-amber-100 text-amber-700' => $order->status == 'pending',
                    'bg-blue-100 text-blue-700' => in_array($order->status, ['paid','processing','shipped']),
                    'bg-plum-100 text-blush-700' => $order->status == 'completed',
                    'bg-red-100 text-red-700' => $order->status == 'cancelled',
                ])">{{ ucfirst($order->status) }}</span>
        </div>
        <div class="flex justify-between text-sm mb-1">
            <span class="text-blush-500">Pembayaran</span>
            <span class="font-medium text-plum-800">{{ $order->payment_method === 'cod' ? 'Bayar di Tempat (COD)' : 'Transfer Bank' }}</span>
        </div>

        <div class="border-t border-dashed border-plum-200 my-4"></div>

        <p class="text-xs text-plum-400 mb-1">Dikirim ke:</p>
        <p class="text-sm text-plum-800 mb-1">{{ $order->shipping_address }}</p>
        <p class="text-sm text-blush-600">📞 {{ $order->phone }}</p>

        <div class="border-t border-dashed border-plum-200 my-4"></div>

        <table class="w-full text-sm">
            <thead>
                <tr class="text-plum-400 text-xs uppercase">
                    <th class="text-left pb-2">Item</th>
                    <th class="text-center pb-2">Qty</th>
                    <th class="text-right pb-2">Harga</th>
                    <th class="text-right pb-2">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr class="border-t border-blush-50">
                    <td class="py-2">
                        <p class="font-medium text-plum-900">{{ $item->item_name }}</p>
                        <p class="text-xs text-plum-400">{{ $item->store->name ?? '-' }}</p>
                    </td>
                    <td class="text-center py-2 text-blush-700">{{ $item->qty }}</td>
                    <td class="text-right py-2 text-blush-700">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="text-right py-2 font-medium text-plum-900">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="border-t-2 border-dashed border-plum-200 mt-4 pt-4">
            <div class="flex justify-between text-lg font-extrabold text-plum-900">
                <span>Total Bayar</span>
                <span>Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
        </div>

        @if($order->notes)
        <p class="text-xs text-plum-400 mt-4 italic">Catatan: {{ $order->notes }}</p>
        @endif

        <p class="text-center text-xs text-plum-300 mt-6">Terima kasih telah berbelanja di MerchPopRika ✦</p>
    </div>

    @if($order->status === 'completed')
    <div class="bg-white rounded-2xl border border-plum-100 p-6 mt-6 print:hidden">
        <h2 class="font-bold text-plum-800 mb-3">Beri Ulasan Toko</h2>
        @foreach($order->items->unique('store_id') as $item)
        <form action="{{ route('reviews.store', $order) }}" method="POST" class="mb-4 border-b border-blush-50 pb-4 last:border-0">
            @csrf
            <input type="hidden" name="store_id" value="{{ $item->store_id }}">
            <p class="text-sm font-medium text-plum-800 mb-2">{{ $item->store->name ?? 'Toko' }}</p>
            <div class="flex items-center gap-2 mb-2">
                @for($i = 1; $i <= 5; $i++)
                <label class="cursor-pointer">
                    <input type="radio" name="rating" value="{{ $i }}" class="hidden peer" {{ $i == 5 ? 'checked' : '' }}>
                    <span class="text-xl text-plum-200 peer-checked:text-amber-400">⭐</span>
                </label>
                @endfor
            </div>
            <textarea name="comment" rows="2" placeholder="Tulis ulasan (opsional)" class="w-full text-sm rounded-lg border-plum-200 border px-3 py-2 mb-2"></textarea>
            <button class="text-sm bg-blush-600 hover:bg-blush-700 text-white font-semibold px-4 py-2 rounded-lg transition">Kirim Ulasan</button>
        </form>
        @endforeach
    </div>
    @endif

</div>

<style>
    @media print {
        nav, footer, .print\:hidden { display: none !important; }
        #bill { border: none !important; box-shadow: none !important; }
    }
</style>

@endsection
