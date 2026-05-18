@extends('layouts.app')

@section('title', 'Home')

@section('content')

{{-- Hero --}}
<section style="background:linear-gradient(135deg,#3D1A08 0%,#6B3A1F 50%,#8B4513 100%); min-height:520px" class="flex items-center relative overflow-hidden">
    <div class="absolute inset-0 opacity-10" style="background-image:radial-gradient(circle at 20% 80%,#fb7185 0%,transparent 50%),radial-gradient(circle at 80% 20%,#fda4af 0%,transparent 50%)"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 z-10 relative">
        <div class="max-w-2xl">
            <span class="inline-block bg-rose-500 text-white text-xs font-bold uppercase tracking-widest px-3 py-1 rounded-full mb-4">🎂 Fresh Daily</span>
            <h1 class="font-display text-5xl md:text-6xl font-bold text-white leading-tight mb-6">
                Sweet moments,<br><em class="italic" style="color:#fda4af">baked with love</em>
            </h1>
            <p class="text-lg mb-8" style="color:#F5E6D0; opacity:.85">From celebration cakes to party snacks and refreshing drinks — everything you need, delivered to your door.</p>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('products.index') }}" class="btn-primary text-base px-8 py-3">Shop Now →</a>
                <a href="{{ route('order.track') }}" class="btn-outline" style="border-color:#F5E6D0;color:#F5E6D0">Track Order</a>
            </div>
        </div>
    </div>
    <div class="absolute right-0 top-0 h-full w-64 opacity-5 text-white text-9xl flex items-center justify-center select-none">🎂🍰🧁</div>
</section>

{{-- Category Pills --}}
<section class="py-10 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap justify-center gap-3">
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full font-semibold text-sm border-2 transition-all" style="border-color:#e11d48;color:#e11d48;background:white" onmouseover="this.style.background='#e11d48';this.style.color='white'" onmouseout="this.style.background='white';this.style.color='#e11d48'">
                🍽️ All Products
                <span class="text-xs opacity-70">({{ \App\Models\Product::where('status','active')->count() }})</span>
            </a>
            @foreach($categories as $cat)
            <a href="{{ route('products.index', ['category' => $cat->slug]) }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full font-semibold text-sm border-2 transition-all" style="border-color:#3D1A08;color:#3D1A08;background:white" onmouseover="this.style.background='#3D1A08';this.style.color='white'" onmouseout="this.style.background='white';this.style.color='#3D1A08'">
                @if($cat->slug === 'cakes') 🎂
                @elseif($cat->slug === 'small-chops') 🍢
                @else 🥤
                @endif
                {{ $cat->name }}
                <span class="text-xs opacity-60">({{ $cat->products_count }})</span>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- Featured Products --}}
@if($featured->count())
<section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <p class="text-rose-500 text-sm font-semibold uppercase tracking-widest mb-1">✨ Our Picks</p>
            <h2 class="font-display text-3xl font-bold" style="color:#3D1A08">Featured Products</h2>
        </div>
        <a href="{{ route('products.index') }}" class="text-sm font-semibold" style="color:#e11d48">View All →</a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($featured as $product)
        @include('components.product-card', ['product' => $product])
        @endforeach
    </div>
</section>
@endif

{{-- Why Choose Us --}}
<section class="py-16" style="background:white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="font-display text-3xl font-bold text-center mb-12" style="color:#3D1A08">Why Choose Us?</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach([
                ['🎂','Fresh Daily','Every product is baked fresh daily using only the finest ingredients.'],
                ['🚀','Fast Delivery','We deliver to your doorstep quickly, so your treats arrive fresh.'],
                ['💳','Secure Payment','Pay safely online with Paystack — your transaction is protected.'],
            ] as [$icon, $title, $desc])
            <div class="text-center p-8 rounded-2xl" style="background:#FDF6EC">
                <div class="text-5xl mb-4">{{ $icon }}</div>
                <h3 class="font-display font-bold text-xl mb-2" style="color:#3D1A08">{{ $title }}</h3>
                <p class="text-sm" style="color:#6B3A1F; opacity:.8">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-16 text-center" style="background:linear-gradient(135deg,#e11d48,#be123c)">
    <h2 class="font-display text-3xl font-bold text-white mb-4">Ready to place your order?</h2>
    <p class="text-rose-100 mb-8">Browse our full menu and get it delivered.</p>
    <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 bg-white font-bold px-8 py-3 rounded-full transition-all hover:bg-rose-50" style="color:#e11d48">
        Shop Products →
    </a>
</section>
@endsection
