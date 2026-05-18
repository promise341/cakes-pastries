@extends('layouts.app')
@section('title', $product->name)

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">

    {{-- Breadcrumb --}}
    <nav class="text-sm opacity-60 mb-6">
        <a href="{{ route('home') }}" class="hover:underline">Home</a> /
        <a href="{{ route('products.index') }}" class="hover:underline">Products</a> /
        <a href="{{ route('products.index', ['category' => $product->category?->slug]) }}" class="hover:underline">
            {{ $product->category?->name }}
        </a> /
        <span class="font-semibold" style="color:var(--rose)">{{ $product->name }}</span>
    </nav>

    <div class="bg-white rounded-2xl shadow-md overflow-hidden">
        <div class="flex flex-col md:flex-row">

            {{-- Product Image --}}
            <div class="md:w-1/2">
                <img src="{{ $product->image_url }}"
                     alt="{{ $product->name }}"
                     class="w-full h-72 md:h-full object-cover"
                     style="min-height:320px"
                     onerror="this.src='https://placehold.co/600x500/F2C4B0/6B3F2A?text=🎂'">
            </div>

            {{-- Product Details --}}
            <div class="md:w-1/2 p-8 flex flex-col justify-center">
                <span class="text-xs font-bold uppercase tracking-wider mb-2" style="color:var(--gold)">
                    {{ $product->category?->name }}
                </span>
                <h1 class="font-display text-3xl font-bold mb-3" style="color:var(--charcoal)">{{ $product->name }}</h1>

                <p class="text-3xl font-bold mb-4" style="color:var(--rose)">₦{{ number_format($product->price, 0) }}</p>

                <p class="text-sm opacity-70 mb-6 leading-relaxed">{{ $product->description }}</p>

                @if($product->status === 'available')
                    <span class="badge badge-available inline-block mb-5">✓ In Stock</span>
                    <form action="{{ route('cart.add', $product) }}" method="POST" class="flex items-center gap-3">
                        @csrf
                        <div class="flex items-center border rounded-full overflow-hidden" style="border-color:var(--blush)">
                            <button type="button" onclick="changeQty(-1)"
                                    class="px-4 py-2 text-lg font-bold hover:bg-rose-50 transition-colors">−</button>
                            <input type="number" name="quantity" id="qty" value="1" min="1" max="50"
                                   class="w-14 text-center border-none focus:outline-none text-sm font-bold">
                            <button type="button" onclick="changeQty(1)"
                                    class="px-4 py-2 text-lg font-bold hover:bg-rose-50 transition-colors">+</button>
                        </div>
                        <button type="submit" class="btn-primary flex-1 text-center">🛒 Add to Cart</button>
                    </form>
                @else
                    <span class="badge badge-out inline-block mb-5">Out of Stock</span>
                    <p class="text-sm opacity-60">This item is currently unavailable. Check back soon!</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Related Products --}}
    @if($related->count())
    <div class="mt-14">
        <h2 class="font-display text-2xl font-bold mb-6" style="color:var(--charcoal)">You Might Also Like</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($related as $product)
                @include('products._card', ['product' => $product])
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
    function changeQty(delta) {
        const input = document.getElementById('qty');
        const newVal = Math.max(1, Math.min(50, parseInt(input.value) + delta));
        input.value = newVal;
    }
</script>
@endpush
