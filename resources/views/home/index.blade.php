@extends('layouts.app')

@section('title', 'Home')

@section('content')

{{-- Hero Section --}}
<section style="background: linear-gradient(135deg, #2D1406 0%, #4D2612 50%, #633014 100%); min-height: 550px" class="flex items-center relative overflow-hidden">
    <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 15% 75%, #f43f5e 0%, transparent 45%), radial-gradient(circle at 85% 25%, #fda4af 0%, transparent 45%)"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 z-10 relative">
        <div class="max-w-2xl">
            <span class="inline-flex items-center gap-1.5 bg-rose-600/90 text-white text-[10px] font-extrabold uppercase tracking-widest px-3.5 py-1.5 rounded-full mb-6 shadow-sm">
                <span>🎂</span> Freshly Baked Daily
            </span>
            <h1 class="font-display text-5xl md:text-6xl font-extrabold text-white leading-tight mb-6">
                Sweet moments,<br><span class="italic text-rose-300 font-serif">baked with love</span>
            </h1>
            <p class="text-base md:text-lg mb-10 text-[#F5E6D0]/90 leading-relaxed">
                Indulge in our exquisite collection of premium cakes, delightful small chops, and refreshing beverages. Handcrafted with the finest ingredients to celebrate your everyday joy.
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('products.index') }}" class="btn-primary text-sm px-8 py-4 shadow-lg">Explore Menu</a>
                <a href="{{ route('order.track') }}" class="btn-outline text-sm px-8 py-4 border-[#FDF6EC] text-[#FDF6EC] hover:bg-white hover:text-[#3D1A08] shadow-md">Track Order</a>
            </div>
        </div>
    </div>
    <div class="absolute right-8 bottom-8 h-full w-96 opacity-10 text-white text-9xl flex items-center justify-center select-none pointer-events-none">
        🎂🍰🧁
    </div>
</section>

{{-- Overlapping Floating Search --}}
<section class="max-w-4xl mx-auto px-4 -mt-10 relative z-20">
    <div class="bg-white rounded-3xl p-5 md:p-6 shadow-xl border border-[#F5E6D0]/30">
        <form action="{{ route('products.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-grow relative">
                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-lg pointer-events-none">🔍</span>
                <input type="text" name="search" placeholder="What are you craving today? (e.g. Red Velvet, Samosa...)" 
                       class="w-full pl-12 pr-4 py-4 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/40 text-sm font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all">
            </div>
            <button type="submit" class="btn-primary justify-center py-4 px-8 rounded-2xl text-xs uppercase tracking-wider font-extrabold shadow-md hover:shadow-lg">
                Search Menu
            </button>
        </form>
    </div>
</section>

{{-- Category Pills Section --}}
<section class="py-12 bg-transparent">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap justify-center gap-3">
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-full font-bold text-xs uppercase tracking-wider border border-rose-500 bg-rose-500 text-white shadow-sm hover:shadow-md transition-all">
                <span>🍽️</span> All Products
                <span class="opacity-70">({{ \App\Models\Product::where('status','active')->count() }})</span>
            </a>
            @foreach($categories as $cat)
            <a href="{{ route('products.index', ['category' => $cat->slug]) }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-full font-bold text-xs uppercase tracking-wider border border-[#F5E6D0] bg-white text-[#3D1A08] shadow-xs hover:border-rose-500 hover:text-rose-500 hover:shadow-sm transition-all">
                <span>
                    @if($cat->slug === 'cakes') 🎂
                    @elseif($cat->slug === 'small-chops') 🍢
                    @else 🥤
                    @endif
                </span>
                {{ $cat->name }}
                <span class="opacity-60 text-[10px]">({{ $cat->products_count }})</span>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- Featured Products Section --}}
@if($featured->count())
<section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 border-b border-[#F5E6D0]/50 pb-6">
        <div>
            <p class="text-rose-500 text-xs font-bold uppercase tracking-widest mb-2">✨ Chef's Special Picks</p>
            <h2 class="font-display text-3xl md:text-4xl font-extrabold text-[#3D1A08]">Featured Creations</h2>
        </div>
        <a href="{{ route('products.index') }}" class="text-xs font-bold uppercase tracking-widest text-rose-600 hover:text-rose-800 transition-colors mt-2 md:mt-0 flex items-center gap-1">
            Browse Entire Menu <span>→</span>
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($featured as $product)
        @include('products._card', ['product' => $product])
        @endforeach
    </div>
</section>
@endif

{{-- Why Choose Us Section --}}
<section class="py-20 bg-white border-y border-[#F5E6D0]/40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-xl mx-auto mb-16">
            <h2 class="font-display text-3xl md:text-4xl font-extrabold text-[#3D1A08] mb-4">Why Choose Us?</h2>
            <div class="w-12 h-1 bg-rose-600 rounded-full mx-auto mb-4"></div>
            <p class="text-sm text-[#6B3A1F]/70 leading-relaxed">We pride ourselves in delivering luxury-quality bakes and reliable treats to make your milestones exceptionally sweet.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach([
                ['🎂','Baked Fresh Daily','Every single item in our kitchen is crafted and baked from scratch daily using premium ingredients.'],
                ['🚀','Fast, Fragile Delivery','Our dedicated logistics team treats your items like royalty, delivering fresh, secure and on time.'],
                ['💳','Secure Payment Gateway','Instant, hassle-free checkout protected securely by Paystack payment integration.'],
            ] as [$icon, $title, $desc])
            <div class="text-center p-8 rounded-3xl border border-[#F5E6D0]/30 hover:border-rose-300 transition-all duration-300 hover:shadow-lg bg-[#FDF6EC]">
                <div class="text-5xl mb-5 drop-shadow-sm">{{ $icon }}</div>
                <h3 class="font-display font-extrabold text-lg text-[#3D1A08] mb-3">{{ $title }}</h3>
                <p class="text-xs text-[#6B3A1F]/80 leading-relaxed">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA Section --}}
<section class="py-20 text-center relative overflow-hidden" style="background: linear-gradient(135deg, #e11d48 0%, #be123c 100%)">
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 50% 50%, white 0%, transparent 60%)"></div>
    <div class="relative z-10 max-w-2xl mx-auto px-4">
        <h2 class="font-display text-4xl font-extrabold text-white mb-4">Ready to taste the magic?</h2>
        <p class="text-rose-100 mb-10 text-sm leading-relaxed">Place your order today and experience freshly baked treats delivered right to your doorstep.</p>
        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 bg-white text-rose-600 hover:bg-rose-50 font-extrabold text-xs uppercase tracking-wider px-8 py-4 rounded-full shadow-lg hover:shadow-xl transition-all">
            Order Now 🛍️
        </a>
    </div>
</section>
@endsection
