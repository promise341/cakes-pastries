@extends('layouts.app')
@section('title', 'Your Cart')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-12">
    <div class="flex items-center gap-3 mb-10 border-b border-[#F5E6D0]/50 pb-6">
        <span class="text-3xl">🛒</span>
        <div>
            <h1 class="font-display text-3xl font-extrabold text-[#3D1A08]">Shopping Cart</h1>
            <p class="text-xs text-[#6B3A1F]/70 mt-1">Review your freshly baked treats before checking out.</p>
        </div>
    </div>

    @if(empty($cart))
        <div class="text-center py-20 bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs max-w-lg mx-auto">
            <div class="text-6xl mb-5">🧁</div>
            <h2 class="font-display text-2xl font-bold text-[#3D1A08] mb-2">Your cart is empty</h2>
            <p class="text-sm text-[#6B3A1F]/70 mb-8 max-w-xs mx-auto">Looks like you haven't added any of our delicious creations to your cart yet.</p>
            <a href="{{ route('products.index') }}" class="btn-primary py-3 px-8 shadow-md rounded-full text-sm">
                Browse Delicacies
            </a>
        </div>
    @else
        <div class="flex flex-col lg:flex-row gap-8">

            {{-- Cart Items --}}
            <div class="flex-grow space-y-4">
                @foreach($cart as $id => $item)
                <div class="bg-white rounded-2xl border border-[#F5E6D0]/40 shadow-xs p-5 flex flex-col sm:flex-row items-center gap-5 transition-all duration-200 hover:shadow-sm">
                    <img src="{{ $item['image'] }}"
                         alt="{{ $item['name'] }}"
                         class="w-20 h-20 rounded-xl object-cover shrink-0 bg-[#FDF6EC]"
                         onerror="this.src='https://placehold.co/100?text=🎂'">

                    <div class="flex-grow min-w-0 text-center sm:text-left">
                        <h3 class="font-display font-bold text-base text-[#3D1A08] truncate">{{ $item['name'] }}</h3>
                        <p class="text-xs font-semibold text-rose-600 mt-1">₦{{ number_format($item['price'], 0) }} each</p>
                    </div>

                    {{-- Quantity form --}}
                    <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center gap-2">
                        @csrf @method('PATCH')
                        <div class="flex items-center border border-[#F5E6D0] rounded-full overflow-hidden bg-white shadow-inner">
                            <button type="button" onclick="adjustQty(this, -1)"
                                    class="w-8 h-8 flex items-center justify-center font-extrabold text-[#6B3A1F] hover:bg-[#FDF6EC] transition-colors">−</button>
                            <input type="number" name="quantity" value="{{ $item['quantity'] }}"
                                   min="1" max="50" onchange="this.form.submit()" readonly
                                   class="w-10 text-center bg-transparent border-none focus:outline-none text-xs font-bold text-[#3D1A08]">
                            <button type="button" onclick="adjustQty(this, 1)"
                                    class="w-8 h-8 flex items-center justify-center font-extrabold text-[#6B3A1F] hover:bg-[#FDF6EC] transition-colors">+</button>
                        </div>
                    </form>

                    <div class="w-24 text-center sm:text-right shrink-0">
                        <p class="text-[10px] uppercase tracking-wider text-[#6B3A1F]/60">Subtotal</p>
                        <p class="font-display font-bold text-lg text-[#3D1A08] mt-0.5">
                            ₦{{ number_format($item['price'] * $item['quantity'], 0) }}
                        </p>
                    </div>

                    <form action="{{ route('cart.remove', $id) }}" method="POST" class="shrink-0">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-8 h-8 flex items-center justify-center text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-full transition-all" title="Remove Item">✕</button>
                    </form>
                </div>
                @endforeach

                <div class="flex justify-between items-center pt-2">
                    <a href="{{ route('products.index') }}" class="text-xs font-bold uppercase tracking-widest text-[#6B3A1F]/70 hover:text-rose-600 transition-colors">
                        ← Continue Shopping
                    </a>
                    
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-xs font-bold uppercase tracking-widest text-rose-500 hover:text-rose-700 transition-colors">
                            Clear Entire Cart
                        </button>
                    </form>
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="lg:w-80 shrink-0">
                <div class="bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs p-6 sticky top-24 space-y-6">
                    <h2 class="font-display text-xl font-extrabold text-[#3D1A08] border-b border-[#F5E6D0]/50 pb-4">Order Summary</h2>

                    <div class="space-y-3 text-xs max-h-48 overflow-y-auto pr-1">
                        @foreach($cart as $item)
                        <div class="flex justify-between items-center">
                            <span class="text-[#6B3A1F]/80 truncate pr-4">{{ $item['name'] }} <span class="font-bold text-[#3D1A08]">× {{ $item['quantity'] }}</span></span>
                            <span class="font-bold text-[#3D1A08] shrink-0">₦{{ number_format($item['price'] * $item['quantity'], 0) }}</span>
                        </div>
                        @endforeach
                    </div>

                    {{-- Coupon Apply Block --}}
                    <div class="border-t border-[#F5E6D0]/50 pt-4 space-y-3">
                        @if(session()->has('coupon'))
                            <div class="flex justify-between items-center text-xs font-semibold bg-emerald-50 text-emerald-700 p-2.5 rounded-xl border border-emerald-100">
                                <span>Code: <span class="font-bold uppercase">{{ session('coupon.code') }}</span></span>
                                <form action="{{ route('cart.coupon.remove') }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-[10px] text-rose-500 hover:underline">Remove</button>
                                </form>
                            </div>
                        @else
                            <form action="{{ route('cart.coupon.apply') }}" method="POST" class="flex gap-2">
                                @csrf
                                <input type="text" name="coupon_code" placeholder="Enter coupon..." required
                                       class="w-full px-3 py-2 text-xs font-bold uppercase rounded-xl bg-[#FDF6EC] border border-[#F5E6D0]/40 text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500">
                                <button type="submit" class="px-4 py-2 bg-[#3D1A08] text-[#F5E6D0] hover:bg-[#5C2B14] rounded-xl text-[10px] uppercase tracking-wider font-extrabold shadow-sm">
                                    Apply
                                </button>
                            </form>
                        @endif
                    </div>

                    <div class="border-t border-[#F5E6D0]/50 pt-4 space-y-2">
                        <div class="flex justify-between text-xs font-semibold text-[#6B3A1F]">
                            <span>Subtotal</span>
                            <span>₦{{ number_format($total, 0) }}</span>
                        </div>
                        @if($discount > 0)
                        <div class="flex justify-between text-xs font-bold text-emerald-600">
                            <span>Discount</span>
                            <span>- ₦{{ number_format($discount, 0) }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between items-center border-t border-[#FDF6EC] pt-2">
                            <div>
                                <span class="text-[10px] uppercase tracking-wider text-[#6B3A1F]/60 font-semibold block">Total Due</span>
                                <span class="text-[10px] text-emerald-600 font-bold block">✓ Delivery fee included</span>
                            </div>
                            <span class="font-display font-bold text-2xl text-rose-600">₦{{ number_format(max(0, $total - $discount), 0) }}</span>
                        </div>
                    </div>

                    <div class="space-y-3 pt-2">
                        <a href="{{ route('checkout.index') }}" class="btn-primary w-full py-3.5 text-center justify-center font-bold tracking-wider uppercase text-xs rounded-full shadow-md hover:shadow-lg transition-all block">
                            Proceed to Checkout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    function adjustQty(btn, delta) {
        const input = btn.parentElement.querySelector('input[name="quantity"]');
        const newVal = Math.max(1, Math.min(50, parseInt(input.value) + delta));
        input.value = newVal;
        input.form.submit();
    }
</script>
@endsection
