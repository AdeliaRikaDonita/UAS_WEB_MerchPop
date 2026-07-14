@extends('layouts.app')
@section('title', 'Kelola Toko')
@section('content')

<h1 class="text-2xl font-bold text-plum-800 mb-6">Kelola Toko</h1>

<div class="bg-white rounded-xl border border-plum-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-blush-50 text-blush-600 text-xs uppercase">
            <tr>
                <th class="text-left px-4 py-3">Toko</th>
                <th class="text-left px-4 py-3">Pemilik</th>
                <th class="text-left px-4 py-3">Photocard</th>
                <th class="text-left px-4 py-3">Status</th>
                <th class="text-right px-4 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-blush-50">
            @forelse($stores as $store)
            <tr>
                <td class="px-4 py-3 font-medium text-plum-900">
                    <a href="{{ route('stores.show', $store) }}" class="hover:underline">{{ $store->name }}</a>
                </td>
                <td class="px-4 py-3 text-blush-600">{{ $store->user->name }}</td>
                <td class="px-4 py-3 text-blush-600">{{ $store->photo_cards_count }}</td>
                <td class="px-4 py-3">
                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $store->is_active ? 'bg-plum-100 text-blush-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $store->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td class="px-4 py-3 text-right">
                    <form action="{{ route('admin.stores.toggle', $store) }}" method="POST">
                        @csrf @method('PATCH')
                        <button class="text-blush-600 hover:underline text-xs font-medium">
                            {{ $store->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-4 py-8 text-center text-plum-400">Belum ada toko.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $stores->links() }}</div>

@endsection
