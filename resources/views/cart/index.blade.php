@extends('layouts.app')
@section('title', 'Your Cart')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">
    <h1 class="font-display text-4xl font-bold mb-8" style="color:var(--charcoal)">Your Cart</h1>

    @if(empty($cart))
        <div class="text-center py-20 bg-white rounded-2xl shadow-sm">
            <div class="text-6xl mb-4">🛒</div>
            <h2 class="font-display text-2xl font-bold mb-2">Your cart is empty</h2>
            <p class="opacity-60 mb-6">Looks like you haven't added anything yet.</p>
            <a href="{{ route('products.index') }}" class="btn-primary">Browse Products</a>
        </div>
    @else
        <div class="flex flex-col lg:flex-row gap-8">

            {{-- Cart Items --}}
            <div class="flex-1 space-y-4">
                @foreach($cart as $id => $item)
                <div class="bg-white rounded-2xl shadow-sm p-5 flex items-center gap-5">
                    <img src="{{ $item['image'] }}"
                         alt="{{ $item['name'] }}"
                         class="w-20 h-20 rounded-xl object-cover shrink-0"
                         onerror="this.src='https://placehold.co/80x80/F2C4B0/6B3F2A?text=🎂'">

                    <div class="flex-1 min-w-0">
                        <h3 class="font-display font-bold truncate" style="color:var(--charcoal)">{{ $item['name'] }}</h3>
                        <p class="text-sm" style="color:var(--rose)">₦{{ number_format($item['price'], 0) }} each</p>
                    </div>

                    {{-- Quantity form --}}
                    <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center gap-2">
                        @csrf @method('PATCH')
                        <div class="flex items-center border rounded-full overflow-hidden" style="border-color:var(--blush)">
                            <button type="button" onclick="adjustQty(this, -1)"
                                    class="px-3 py-1 hover:bg-rose-50 font-bold">−</button>
                            <input type="number" name="quantity" value="{{ $item['quantity'] }}"
                                   min="1" max="50" onchange="this.form.submit()"
                                   class="w-12 text-center border-none focus:outline-none text-sm font-bold">
                            <button type="button" onclick="adjustQty(this, 1)"
                                    class="px-3 py-1 hover:bg-rose-50 font-bold">+</button>
                        </div>
                    </form>

                    <p class="font-bold w-24 text-right" style="color:var(--charcoal)">
                        ₦{{ number_format($item['price'] * $item['quantity'], 0) }}
                    </p>

                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-400 hover:text-red-600 transition-colors text-lg" title="Remove">✕</button>
                    </form>
                </div>
                @endforeach

                <form action="{{ route('cart.clear') }}" method="POST" class="text-right">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-sm text-red-500 hover:underline">Clear cart</button>
                </form>
            </div>

            {{-- Order Summary --}}
            <div class="lg:w-72 shrink-0">
                <div class="bg-white rounded-2xl shadow-sm p-6 sticky top-24">
                    <h2 class="font-display text-xl font-bold mb-5" style="color:var(--charcoal)">Order Summary</h2>

                    <div class="space-y-2 text-sm mb-4">
                        @foreach($cart as $item)
                        <div class="flex justify-between">
                            <span class="opacity-70">{{ $item['name'] }} × {{ $item['quantity'] }}</span>
                            <span>₦{{ number_format($item['price'] * $item['quantity'], 0) }}</span>
                        </div>
                        @endforeach
                    </div>

                    <div class="border-t pt-4 flex justify-between font-bold text-lg mb-6" style="border-color:var(--blush)">
                        <span>Total</span>
                        <span style="color:var(--rose)">₦{{ number_format($total, 0) }}</span>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="btn-primary w-full text-center block">
                        Proceed to Checkout →
                    </a>
                    <a href="{{ route('products.index') }}" class="block text-center text-sm mt-3 opacity-60 hover:opacity-100">
                        ← Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    function adjustQty(btn, delta) {
        const input = btn.parentElement.querySelector('input[name="quantity"]');
        const newVal = Math.max(1, Math.min(50, parseInt(input.value) + delta));
        input.value = newVal;
        input.form.submit();
    }
</script>
@endpush
