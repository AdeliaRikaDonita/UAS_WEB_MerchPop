@extends('layouts.app')
@section('title', 'Kelola Photocard')
@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-plum-800">Kelola Photocard</h1>
    <a href="{{ route('seller.photo_cards.create') }}" class="bg-blush-600 hover:bg-blush-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition">+ Tambah Photocard</a>
</div>

<div class="bg-white rounded-xl border border-plum-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-blush-50 text-blush-600 text-xs uppercase">
            <tr>
                <th class="text-left px-4 py-3">Photocard</th>
                <th class="text-left px-4 py-3">Harga</th>
                <th class="text-left px-4 py-3">Stok</th>
                <th class="text-left px-4 py-3">Status</th>
                <th class="text-right px-4 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-blush-50">
            @forelse($photo_cards as $photoCard)
            <tr>
                <td class="px-4 py-3 font-medium text-plum-900">{{ $photoCard->name }}</td>
                <td class="px-4 py-3 text-blush-700">Rp{{ number_format($photoCard->price, 0, ',', '.') }}</td>
                <td class="px-4 py-3 text-blush-700">{{ $photoCard->stock }}</td>
                <td class="px-4 py-3">
                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $photoCard->is_active ? 'bg-plum-100 text-blush-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $photoCard->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td class="px-4 py-3 text-right space-x-2">
                    <a href="{{ route('seller.photo_cards.edit', $photoCard) }}" class="text-blush-600 hover:underline text-xs font-medium">Edit</a>
                    <form action="{{ route('seller.photo_cards.destroy', $photoCard) }}" method="POST" class="inline" onsubmit="return confirm('Hapus photocard ini?')">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:underline text-xs font-medium">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-4 py-8 text-center text-plum-400">Belum ada photocard. Yuk tambahkan photocard pertamamu!</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $photo_cards->links() }}</div>

@endsection
