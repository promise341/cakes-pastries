@extends('layouts.app')
@section('title', 'Home')

@section('content')

{{-- HERO --}}
<section style="background: linear-gradient(135deg, #FDF8F0 60%, #F2C4B0 100%)" class="py-20 px-4">
    <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center gap-12">
        <div class="flex-1 text-center md:text-left">
            <p class="text-sm font-bold uppercase tracking-widest mb-3" style="color:var(--gold)">Handmade with Love</p>
            <h1 class="font-display text-5xl md:text-6xl font-bold leading-tight mb-5" style="color:var(--charcoal)">
                Baked Goods That<br><span style="color:var(--rose)">Make Moments</span><br>Unforgettable
            </h1>
            <p class="text-lg opacity-70 mb-8 max-w-md">
                From celebration cakes to fresh small chops and refreshing drinks — everything made fresh for you.
            </p>
            <div class="flex flex-wrap gap-3 justify-center md:justify-start">
                <a href="{{ route('products.index') }}" class="btn-primary text-base">Shop Now</a>
                <a href="{{ route('products.index', ['category' => 'cakes']) }}" class="btn-outline text-base">View Cakes</a>
            </div>
        </div>
        <div class="flex-1 flex justify-center">
            <div class="w-64 h-64 md:w-80 md:h-80 rounded-full flex items-center justify-center text-9xl shadow-2xl"
                 style="background: linear-gradient(135deg, #F2C4B0, #D4A853)">
                🎂
            </div>
        </div>
    </div>
</section>

{{-- CATEGORIES --}}
<section class="py-14 px-4">
    <div class="max-w-6xl mx-auto">
        <h2 class="font-display text-3xl font-bold text-center mb-10" style="color:var(--charcoal)">
            What We Offer
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($categories as $category)
            <a href="{{ route('products.index', ['category' => $category->slug]) }}"
               class="card p-8 text-center group">
                <div class="text-5xl mb-4">
                    @if($category->slug === 'cakes') 🎂
                    @elseif($category->slug === 'small-chops') 🍢
                    @else 🥤 @endif
                </div>
                <h3 class="font-display text-xl font-bold mb-1" style="color:var(--charcoal)">{{ $category->name }}</h3>
                <p class="text-sm opacity-60">{{ $category->products_count }} item{{ $category->products_count !== 1 ? 's' : '' }} available</p>
                <span class="mt-4 inline-block text-sm font-bold" style="color:var(--rose)">Browse →</span>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- FEATURED PRODUCTS --}}
@if($featured->count())
<section class="py-14 px-4" style="background:#fff">
    <div class="max-w-6xl mx-auto">
        <div class="flex items-center justify-between mb-10">
            <h2 class="font-display text-3xl font-bold" style="color:var(--charcoal)">Featured Items</h2>
            <a href="{{ route('products.index') }}" class="text-sm font-bold" style="color:var(--rose)">View All →</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featured as $product)
                @include('products._card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- WHY US --}}
<section class="py-14 px-4">
    <div class="max-w-6xl mx-auto">
        <h2 class="font-display text-3xl font-bold text-center mb-10" style="color:var(--charcoal)">Why Choose Us?</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
            <div class="p-6">
                <div class="text-4xl mb-3">🏠</div>
                <h3 class="font-bold text-lg mb-2">Made Fresh Daily</h3>
                <p class="text-sm opacity-70">Every item is baked or prepared fresh on the day of your order.</p>
            </div>
            <div class="p-6">
                <div class="text-4xl mb-3">🚀</div>
                <h3 class="font-bold text-lg mb-2">Fast Delivery</h3>
                <p class="text-sm opacity-70">We deliver quickly so your treats arrive at their best.</p>
            </div>
            <div class="p-6">
                <div class="text-4xl mb-3">💳</div>
                <h3 class="font-bold text-lg mb-2">Secure Payment</h3>
                <p class="text-sm opacity-70">Pay safely online via Paystack — trusted by millions in Nigeria.</p>
            </div>
        </div>
    </div>
</section>

@endsection
