@extends('layouts.app')
@section('title', 'Kelola Pengguna')
@section('content')

<h1 class="text-2xl font-bold text-plum-800 mb-6">Kelola Pengguna</h1>

<form method="GET" class="flex gap-2 mb-4 max-w-md">
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama/email..." class="flex-1 rounded-lg border-plum-200 border px-3 py-2 text-sm">
    <button class="bg-blush-600 hover:bg-blush-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">Cari</button>
</form>

<div class="bg-white rounded-xl border border-plum-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-blush-50 text-blush-600 text-xs uppercase">
            <tr>
                <th class="text-left px-4 py-3">Nama</th>
                <th class="text-left px-4 py-3">Email</th>
                <th class="text-left px-4 py-3">Role</th>
                <th class="text-left px-4 py-3">Pesanan</th>
                <th class="text-right px-4 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-blush-50">
            @forelse($users as $user)
            <tr>
                <td class="px-4 py-3 font-medium text-plum-900">{{ $user->name }}</td>
                <td class="px-4 py-3 text-blush-600">{{ $user->email }}</td>
                <td class="px-4 py-3">
                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-plum-100 text-blush-700">{{ ucfirst($user->role) }}</span>
                </td>
                <td class="px-4 py-3 text-blush-600">{{ $user->orders_count }}</td>
                <td class="px-4 py-3 text-right">
                    @unless($user->isAdmin())
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus pengguna ini?')">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:underline text-xs font-medium">Hapus</button>
                    </form>
                    @endunless
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-4 py-8 text-center text-plum-400">Tidak ada pengguna ditemukan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $users->links() }}</div>

@endsection
