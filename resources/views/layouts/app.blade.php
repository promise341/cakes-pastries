<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Cakes & Pastries') – Fresh Baked with Love</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script>
        // Silence Tailwind Play CDN production warning in console
        const originalWarn = console.warn;
        console.warn = function(...args) {
            if (args[0] && typeof args[0] === 'string' && args[0].includes('cdn.tailwindcss.com')) {
                return;
            }
            originalWarn.apply(console, args);
        };
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'DM Sans', sans-serif; background-color: #FDF6EC; }
        .font-display { font-family: 'Playfair Display', Georgia, serif; }
        nav { background: #3D1A08; }
        .nav-link { color: #F5E6D0; transition: color 0.2s; font-size: 0.9rem; font-weight: 500; }
        .nav-link:hover, .nav-link.active { color: #fb7185; }
        .btn-primary { background: #e11d48; color: white; border-radius: 9999px; padding: 0.65rem 1.75rem; font-weight: 600; font-size: 0.9rem; transition: all 0.2s; display: inline-flex; align-items: center; gap: 0.4rem; }
        .btn-primary:hover { background: #be123c; transform: translateY(-1px); box-shadow: 0 4px 15px rgba(225,29,72,.35); }
        .btn-outline { border: 2px solid #e11d48; color: #e11d48; border-radius: 9999px; padding: 0.6rem 1.6rem; font-weight: 600; font-size: 0.9rem; transition: all 0.2s; display: inline-flex; align-items: center; gap: 0.4rem; }
        .btn-outline:hover { background: #e11d48; color: white; }
        .product-card { background: white; border-radius: 1.25rem; overflow: hidden; box-shadow: 0 2px 12px rgba(61,26,8,.08); transition: transform .25s ease, box-shadow .25s ease; }
        .product-card:hover { transform: translateY(-6px); box-shadow: 0 12px 30px rgba(61,26,8,.14); }
        .flash-success { background: #d1fae5; color: #065f46; border-left: 4px solid #10b981; }
        .flash-error { background: #fee2e2; color: #991b1b; border-left: 4px solid #ef4444; }
        footer { background: #3D1A08; color: #F5E6D0; }
        .badge-cat { background: #FDF6EC; color: #8B4513; border: 1px solid #F5E6D0; font-size: .72rem; font-weight: 600; padding: .2rem .65rem; border-radius: 9999px; text-transform: uppercase; letter-spacing: .05em; }
        .cart-bubble { background: #e11d48; color: white; font-size: .65rem; min-width: 18px; height: 18px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; position: absolute; top: -8px; right: -8px; }
        @keyframes fadeSlide { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fadein { animation: fadeSlide .4s ease forwards; }
    </style>
    @yield('styles')
</head>
<body class="min-h-screen flex flex-col">

<nav class="sticky top-0 z-50 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <span class="text-2xl">🎂</span>
                <div>
                    <p class="font-display font-bold text-white text-lg leading-tight">Cakes & Pastries</p>
                    <p class="text-rose-300 text-xs leading-tight" style="color:#fda4af">Fresh Baked with Love</p>
                </div>
            </a>

            <div class="hidden md:flex items-center gap-7">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">Products</a>
                <a href="{{ route('order.track') }}" class="nav-link">Track Order</a>
            </div>

            <div class="flex items-center gap-4">
                @php $cartCount = collect(session('cart', []))->sum('quantity'); @endphp
                <a href="javascript:void(0)" onclick="toggleCartDrawer(true)" class="relative hover:text-rose-400 transition-colors" style="color:#F5E6D0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    @if($cartCount > 0)
                    <span class="cart-bubble">{{ $cartCount > 9 ? '9+' : $cartCount }}</span>
                    @endif
                </a>
                <button id="mobileMenuBtn" class="md:hidden" style="color:#F5E6D0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
        <div id="mobileMenu" class="hidden md:hidden pb-4 pt-3" style="border-top:1px solid #6B3A1F">
            <a href="{{ route('home') }}" class="block nav-link py-2">Home</a>
            <a href="{{ route('products.index') }}" class="block nav-link py-2">Products</a>
            <a href="{{ route('order.track') }}" class="block nav-link py-2">Track Order</a>
            <a href="javascript:void(0)" onclick="toggleCartDrawer(true)" class="block nav-link py-2">Cart ({{ $cartCount }})</a>
        </div>
    </div>
</nav>

@if(session('success'))
<div class="flash-success animate-fadein px-4 py-3 text-sm font-medium rounded-lg mx-4 mt-4 max-w-4xl lg:mx-auto">✅ {{ session('success') }}</div>
@endif
@if(session('error'))
<div class="flash-error animate-fadein px-4 py-3 text-sm font-medium rounded-lg mx-4 mt-4 max-w-4xl lg:mx-auto">❌ {{ session('error') }}</div>
@endif

<main class="flex-1">@yield('content')</main>

<footer class="py-12 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <span class="text-2xl">🎂</span>
                    <span class="font-display font-bold text-xl text-white">Cakes & Pastries</span>
                </div>
                <p style="color:#fda4af" class="text-sm leading-relaxed">Freshly baked with love and the finest ingredients. Bringing joy to every celebration.</p>
            </div>
            <div>
                <h4 class="font-semibold text-white mb-4">Quick Links</h4>
                <ul class="space-y-2 text-sm" style="color:#fda4af">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a></li>
                    <li><a href="{{ route('products.index') }}" class="hover:text-white transition-colors">All Products</a></li>
                    <li><a href="{{ route('order.track') }}" class="hover:text-white transition-colors">Track Order</a></li>
                    <li><a href="{{ route('cart.index') }}" class="hover:text-white transition-colors">Cart</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold text-white mb-4">Contact Us</h4>
                <ul class="space-y-2 text-sm" style="color:#fda4af">
                    <li>📞 +234 800 000 0000</li>
                    <li>📧 orders@cakesandpastries.com</li>
                    <li>📍 Lagos, Nigeria</li>
                    <li>⏰ Mon–Sat, 8am – 6pm</li>
                </ul>
            </div>
        </div>
        <div class="mt-10 pt-6 text-center text-sm" style="border-top:1px solid #6B3A1F; color:#fda4af">
            © {{ date('Y') }} Cakes & Pastries. All rights reserved.
        </div>
    </div>
</footer>

<!-- Cart Drawer Overlay -->
<div id="cartDrawerOverlay" class="fixed inset-0 bg-[#3D1A08]/60 backdrop-blur-xs z-50 hidden transition-opacity duration-300 opacity-0" onclick="toggleCartDrawer(false)"></div>

<!-- Cart Drawer Panel -->
<div id="cartDrawer" class="fixed top-0 right-0 bottom-0 w-full sm:w-[450px] bg-[#FDF6EC] z-50 shadow-2xl transform translate-x-full transition-transform duration-300 ease-in-out flex flex-col border-l border-[#F5E6D0]">
    <!-- Drawer Header -->
    <div class="p-6 border-b border-[#F5E6D0] bg-[#3D1A08] text-white flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="text-xl">🛒</span>
            <h3 class="font-display font-bold text-lg">Your Cart</h3>
        </div>
        <button onclick="toggleCartDrawer(false)" class="text-[#F5E6D0] hover:text-white transition-colors text-2xl font-bold">&times;</button>
    </div>

    <!-- Drawer Content (Scrollable) -->
    <div class="flex-grow overflow-y-auto p-6 space-y-4">
        @php
            $drawerCart = session('cart', []);
            $drawerTotal = collect($drawerCart)->sum(fn($item) => $item['price'] * $item['quantity']);
        @endphp

        @if(empty($drawerCart))
            <div class="flex flex-col items-center justify-center h-full text-center opacity-60 py-12">
                <span class="text-5xl mb-3">🧁</span>
                <p class="font-medium text-[#3D1A08]">Your cart is empty</p>
                <p class="text-xs mt-1">Add some delicious treats to start!</p>
            </div>
        @else
            @foreach($drawerCart as $id => $item)
                <div class="bg-white p-4 rounded-xl shadow-xs border border-[#F5E6D0]/40 flex gap-4 items-center">
                    <img src="{{ $item['image'] }}" class="w-16 h-16 rounded-lg object-cover bg-[#FDF6EC]" onerror="this.src='https://placehold.co/100?text=🎂'">
                    <div class="flex-grow min-w-0">
                        <h4 class="font-bold text-sm text-[#3D1A08] truncate">{{ $item['name'] }}</h4>
                        <p class="text-xs font-semibold text-rose-600 mt-0.5">₦{{ number_format($item['price'], 0) }}</p>
                        
                        <div class="flex items-center justify-between mt-2">
                            <div class="flex items-center gap-3">
                                <form action="{{ route('cart.update', $id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="quantity" value="{{ $item['quantity'] - 1 }}">
                                    <button type="submit" {{ $item['quantity'] <= 1 ? 'disabled' : '' }} class="w-6 h-6 flex items-center justify-center rounded-full border border-[#F5E6D0] text-xs font-bold text-[#6B3A1F] hover:bg-[#FDF6EC] disabled:opacity-30">-</button>
                                </form>
                                
                                <span class="text-xs font-bold text-[#3D1A08]">{{ $item['quantity'] }}</span>

                                <form action="{{ route('cart.update', $id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="quantity" value="{{ $item['quantity'] + 1 }}">
                                    <button type="submit" class="w-6 h-6 flex items-center justify-center rounded-full border border-[#F5E6D0] text-xs font-bold text-[#6B3A1F] hover:bg-[#FDF6EC]">+</button>
                                </form>
                            </div>

                            <form action="{{ route('cart.remove', $id) }}" method="POST" class="ml-auto">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-rose-500 hover:text-rose-700 transition-colors font-medium">Remove</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <!-- Drawer Footer -->
    @if(!empty($drawerCart))
    <div class="p-6 border-t border-[#F5E6D0] bg-white space-y-4">
        <div class="flex items-center justify-between">
            <span class="text-xs uppercase tracking-wider text-[#6B3A1F]/60 font-semibold">Total Amount</span>
            <span class="font-display font-bold text-2xl text-rose-600">₦{{ number_format($drawerTotal, 0) }}</span>
        </div>
        <div class="grid grid-cols-2 gap-3 pt-2">
            <a href="{{ route('cart.index') }}" class="btn-outline text-center justify-center py-3 text-xs tracking-wider uppercase font-bold rounded-full">View Cart</a>
            <a href="{{ route('checkout.index') }}" class="btn-primary text-center justify-center py-3 text-xs tracking-wider uppercase font-bold rounded-full shadow-md hover:shadow-lg">Checkout</a>
        </div>
    </div>
    @endif
</div>

<script>
    document.getElementById('mobileMenuBtn').addEventListener('click', () => {
        document.getElementById('mobileMenu').classList.toggle('hidden');
    });
    setTimeout(() => {
        document.querySelectorAll('.flash-success, .flash-error').forEach(el => {
            el.style.transition = 'opacity .5s';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 500);
        });
    }, 4000);

    function toggleCartDrawer(open) {
        const overlay = document.getElementById('cartDrawerOverlay');
        const drawer = document.getElementById('cartDrawer');
        if (open) {
            overlay.classList.remove('hidden');
            setTimeout(() => {
                overlay.classList.add('opacity-100');
                drawer.classList.remove('translate-x-full');
            }, 10);
        } else {
            overlay.classList.remove('opacity-100');
            drawer.classList.add('translate-x-full');
            setTimeout(() => {
                overlay.classList.add('hidden');
            }, 300);
        }
    }
</script>
@yield('scripts')
</body>
</html>
