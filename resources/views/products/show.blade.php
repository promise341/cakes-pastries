@extends('layouts.app')
@section('title', $product->name)

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">

    {{-- Breadcrumb --}}
    <nav class="text-xs tracking-wider uppercase opacity-75 mb-8 flex items-center gap-2 text-[#6B3A1F]">
        <a href="{{ route('home') }}" class="hover:text-rose-600 transition-colors font-medium">Home</a> 
        <span class="opacity-50">/</span>
        <a href="{{ route('products.index') }}" class="hover:text-rose-600 transition-colors font-medium">Products</a> 
        <span class="opacity-50">/</span>
        @if($product->category)
            <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="hover:text-rose-600 transition-colors font-medium">
                {{ $product->category->name }}
            </a> 
            <span class="opacity-50">/</span>
        @endif
        <span class="font-bold text-rose-600">{{ $product->name }}</span>
    </nav>

    <div class="bg-white rounded-3xl shadow-sm border border-[#F5E6D0]/40 overflow-hidden">
        <div class="flex flex-col md:flex-row">

            {{-- Product Image --}}
            <div class="md:w-1/2 relative bg-[#FDF6EC]">
                <img src="{{ $product->image_url }}"
                     alt="{{ $product->name }}"
                     class="w-full h-80 md:h-full object-cover min-h-[350px] md:min-h-[500px]"
                     onerror="this.src='https://placehold.co/600x500/F2C4B0/6B3F2A?text=🎂'">
            </div>

            {{-- Product Details --}}
            <div class="md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
                @if($product->category)
                <span class="inline-flex items-center self-start bg-rose-50 text-rose-600 text-xs font-bold uppercase tracking-widest px-3 py-1 rounded-full mb-4">
                    {{ $product->category->name }}
                </span>
                @endif
                
                <h1 class="font-display text-3xl md:text-4xl font-extrabold text-[#3D1A08] mb-4 leading-tight">
                    {{ $product->name }}
                </h1>

                <div class="flex items-baseline gap-2 mb-6">
                    <span class="text-3xl md:text-4xl font-display font-extrabold text-rose-600">
                        ₦{{ number_format($product->price, 0) }}
                    </span>
                    <span class="text-xs text-[#6B3A1F]/60 uppercase tracking-widest font-medium">VAT inclusive</span>
                </div>

                <div class="prose prose-sm text-[#6B3A1F]/80 mb-8 max-w-none leading-relaxed">
                    {{ $product->description }}
                </div>

                @if($product->isInStock())
                    <div class="flex items-center gap-3 mb-4">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">
                            ✓ In Stock ({{ $product->stock }} left)
                        </span>
                    </div>

                    <form action="{{ route('cart.add', $product) }}" method="POST" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4">
                        @csrf
                        <div class="flex items-center border border-[#F5E6D0] rounded-full overflow-hidden bg-white shadow-inner self-start">
                            <button type="button" onclick="changeQty(-1)"
                                    class="px-5 py-3 text-lg font-extrabold text-[#6B3A1F] hover:bg-[#FDF6EC] active:bg-[#F5E6D0] transition-colors">−</button>
                            <input type="number" name="quantity" id="qty" value="1" min="1" max="{{ min($product->stock, 50) }}" readonly
                                   class="w-12 text-center bg-transparent border-none focus:outline-none text-sm font-bold text-[#3D1A08]">
                            <button type="button" onclick="changeQty(1)"
                                    class="px-5 py-3 text-lg font-extrabold text-[#6B3A1F] hover:bg-[#FDF6EC] active:bg-[#F5E6D0] transition-colors">+</button>
                        </div>
                        <button type="submit" class="btn-primary py-3 px-8 shadow-md hover:shadow-lg flex items-center justify-center gap-2 rounded-full flex-grow text-base transition-all">
                            <span>🛒</span> Add to Shopping Cart
                        </button>
                    </form>
                @else
                    <div class="flex flex-col items-start gap-3">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-600 border border-rose-100 mb-2">
                            Out of Stock
                        </span>
                        <p class="text-sm text-[#6B3A1F]/70 italic leading-relaxed">We apologize! This delectable delight is currently unavailable. Please check back later or explore our other freshly baked treats.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Related Products --}}
    @if($related->count())
    <div class="mt-16">
        <div class="flex flex-col mb-8">
            <h2 class="font-display text-2xl md:text-3xl font-extrabold text-[#3D1A08] mb-2">You Might Also Like</h2>
            <div class="w-16 h-1 bg-rose-600 rounded-full"></div>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($related as $product)
                @include('products._card', ['product' => $product])
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection

@section('scripts')
<script>
    function changeQty(delta) {
        const input = document.getElementById('qty');
        const maxVal = parseInt(input.getAttribute('max')) || 50;
        const newVal = Math.max(1, Math.min(maxVal, parseInt(input.value) + delta));
        input.value = newVal;
    }
</script>
@endsection
