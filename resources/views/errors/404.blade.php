@extends('layouts.app')
@section('title', 'Halaman Tidak Ditemukan')
@section('content')
<div class="max-w-md mx-auto text-center py-16">
    <p class="text-5xl mb-4">✦</p>
    <h1 class="text-2xl font-bold text-plum-800 mb-2">Halaman Tidak Ditemukan</h1>
    <p class="text-blush-500 mb-6">Halaman yang kamu cari sepertinya tidak ada di koleksi kami.</p>
    <a href="{{ route('home') }}" class="bg-blush-600 hover:bg-blush-700 text-white font-semibold px-6 py-2.5 rounded-lg transition">Kembali ke Beranda</a>
</div>
@endsection
