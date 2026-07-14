@extends('layouts.app')
@section('title', 'Masuk')
@section('content')
<div class="max-w-md mx-auto mt-8 bg-white rounded-2xl shadow-sm border border-plum-100 p-8">
    <div class="text-center mb-6">
        <span class="text-3xl">✦</span>
        <h1 class="text-2xl font-bold text-plum-800 mt-2">Masuk ke MerchPopRika</h1>
        <p class="text-blush-500 text-sm mt-1">Yuk lanjut cari photocard favoritmu.</p>
    </div>
    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-blush-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                class="w-full rounded-lg border-plum-200 focus:border-blush-500 focus:ring-blush-500 border px-3 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium text-blush-700 mb-1">Password</label>
            <input type="password" name="password" required
                class="w-full rounded-lg border-plum-200 focus:border-blush-500 focus:ring-blush-500 border px-3 py-2">
        </div>
        <label class="flex items-center gap-2 text-sm text-blush-600">
            <input type="checkbox" name="remember" class="rounded border-plum-300 text-blush-600">
            Ingat saya
        </label>
        <button class="w-full bg-blush-600 hover:bg-blush-700 text-white font-semibold py-2.5 rounded-lg transition">
            Masuk
        </button>
    </form>
    <p class="text-center text-sm text-blush-600 mt-6">
        Belum punya akun? <a href="{{ route('register') }}" class="text-blush-700 font-semibold hover:underline">Daftar sekarang</a>
    </p>
</div>
@endsection
