<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MerchPopRika') — Photocard Marketplace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        blush: {
                            50: '#FFF3FA', 100: '#FFE1F0', 200: '#FFC2E0',
                            300: '#FFA0CE', 400: '#FF8FC4', 500: '#FF6FB0',
                            600: '#E8489A', 700: '#C22F7C', 800: '#8F2260',
                            900: '#5C1740',
                        },
                        lav: {
                            50: '#FCE9F5', 100: '#F7D6EC', 200: '#F0B8DE',
                        },
                        plum: {
                            50: '#F7EFF5', 100: '#EDDCE9', 200: '#D9BAD1',
                            300: '#BE95B2', 400: '#9C6E90', 500: '#7A5570',
                            600: '#5C3E54', 700: '#4A2B45', 800: '#3A2036',
                            900: '#2A1727',
                        },
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'ui-sans-serif', 'system-ui'],
                        display: ['Baloo 2', 'ui-sans-serif'],
                    },
                },
            },
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-display { font-family: 'Baloo 2', sans-serif; }
        .holo-text {
            background: linear-gradient(115deg, #FF8FC4 0%, #FFB6DC 25%, #FFD1E8 50%, #FFA6D4 75%, #FF8FC4 100%);
            background-size: 300% 300%;
            -webkit-background-clip: text; background-clip: text; color: transparent;
            animation: holoshift 6s ease infinite;
        }
        @keyframes holoshift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
    </style>
</head>
<body class="bg-gradient-to-b from-blush-50 to-lav-50 text-plum-800 min-h-screen flex flex-col">

    <nav class="bg-white/80 backdrop-blur-sm border-b border-blush-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('home') }}" class="flex items-center gap-1.5 font-display font-bold text-lg holo-text">
                    <span>✦</span> MerchPopRika
                </a>

                <div class="hidden md:flex items-center gap-6 text-sm font-semibold text-plum-600">
                    <a href="{{ route('home') }}" class="hover:text-blush-600 transition">Jelajahi</a>
                    @auth
                        @if(auth()->user()->isBuyer())
                            <a href="{{ route('orders.index') }}" class="hover:text-blush-600 transition">Pesanan Saya</a>
                        @elseif(auth()->user()->isSeller())
                            <a href="{{ route('seller.dashboard') }}" class="hover:text-blush-600 transition">Dashboard Toko</a>
                        @elseif(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="hover:text-blush-600 transition">Admin Panel</a>
                        @endif
                    @endauth
                </div>

                <div class="flex items-center gap-3">
                    @guest
                        <a href="{{ route('cart.index') }}" class="relative w-9 h-9 rounded-full bg-blush-100 text-blush-600 flex items-center justify-center hover:bg-blush-200 transition">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                        </a>
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-plum-600 hover:text-blush-600 transition">Masuk</a>
                        <a href="{{ route('register') }}" class="text-sm font-bold bg-blush-500 text-white px-4 py-2 rounded-full hover:bg-blush-600 transition">Daftar</a>
                    @else
                        @if(auth()->user()->isBuyer())
                        <a href="{{ route('cart.index') }}" class="relative w-9 h-9 rounded-full bg-blush-100 text-blush-600 flex items-center justify-center hover:bg-blush-200 transition">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                        </a>
                        @endif
                        <span class="text-sm text-plum-500 hidden sm:inline">Hai, {{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="text-sm font-semibold text-plum-500 hover:text-red-500 transition">Keluar</button>
                        </form>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-1">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            @if(session('status'))
                <div class="mb-4 rounded-xl bg-blush-100 border border-blush-200 text-blush-700 px-4 py-3 text-sm font-medium">
                    ✅ {{ session('status') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 rounded-xl bg-red-50 border border-red-200 text-red-600 px-4 py-3 text-sm font-medium">
                    ⚠️ {{ session('error') }}
                </div>
            @endif
            @if($errors->any())
                <div class="mb-4 rounded-xl bg-red-50 border border-red-200 text-red-600 px-4 py-3 text-sm font-medium">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer class="bg-white border-t border-blush-200 text-plum-500 mt-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-sm flex flex-col sm:flex-row justify-between gap-4">
            <p>&copy; {{ date('Y') }} MerchPopRika — Photocard Marketplace. Dibuat untuk UAS Pemrograman Web 2.</p>
            <p class="text-blush-500 font-display font-semibold">Collect your bias ✦</p>
        </div>
    </footer>
</body>
</html>
