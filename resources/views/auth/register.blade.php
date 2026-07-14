@extends('layouts.app')
@section('title', 'Daftar')
@section('content')
<div class="max-w-md mx-auto mt-8 bg-white rounded-2xl shadow-sm border border-plum-100 p-8">
    <div class="text-center mb-6">
        <span class="text-3xl">✦</span>
        <h1 class="text-2xl font-bold text-plum-800 mt-2">Buat Akun MerchPopRika</h1>
        <p class="text-blush-500 text-sm mt-1">Cari photocard favorit atau buka toko kamu sendiri.</p>
    </div>
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-blush-700 mb-1">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus
                class="w-full rounded-lg border-plum-200 focus:border-blush-500 focus:ring-blush-500 border px-3 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium text-blush-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                class="w-full rounded-lg border-plum-200 focus:border-blush-500 focus:ring-blush-500 border px-3 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium text-blush-700 mb-1">No. HP</label>
            <input type="text" name="phone" value="{{ old('phone') }}"
                class="w-full rounded-lg border-plum-200 focus:border-blush-500 focus:ring-blush-500 border px-3 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium text-blush-700 mb-1">Password</label>
            <input type="password" name="password" required
                class="w-full rounded-lg border-plum-200 focus:border-blush-500 focus:ring-blush-500 border px-3 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium text-blush-700 mb-1">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required
                class="w-full rounded-lg border-plum-200 focus:border-blush-500 focus:ring-blush-500 border px-3 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium text-blush-700 mb-2">Daftar sebagai</label>
            <div class="grid grid-cols-2 gap-3">
                <label class="flex flex-col items-center gap-1 border rounded-xl p-3 cursor-pointer has-[:checked]:border-blush-600 has-[:checked]:bg-blush-50 border-plum-200">
                    <input type="radio" name="role" value="buyer" class="text-blush-600" {{ old('role', 'buyer') == 'buyer' ? 'checked' : '' }}>
                    <span class="text-sm font-medium">🛍️ Pembeli</span>
                </label>
                <label class="flex flex-col items-center gap-1 border rounded-xl p-3 cursor-pointer has-[:checked]:border-blush-600 has-[:checked]:bg-blush-50 border-plum-200">
                    <input type="radio" name="role" value="seller" class="text-blush-600" {{ old('role') == 'seller' ? 'checked' : '' }}>
                    <span class="text-sm font-medium">✦ Penjual</span>
                </label>
            </div>
        </div>
        <button class="w-full bg-blush-600 hover:bg-blush-700 text-white font-semibold py-2.5 rounded-lg transition">
            Daftar
        </button>
    </form>
    <p class="text-center text-sm text-blush-600 mt-6">
        Sudah punya akun? <a href="{{ route('login') }}" class="text-blush-700 font-semibold hover:underline">Masuk</a>
    </p>
</div>
@endsection
