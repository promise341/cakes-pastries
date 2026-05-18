@extends('layouts.app')
@section('title', 'Checkout')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">
    <h1 class="font-display text-4xl font-bold mb-8" style="color:var(--charcoal)">Checkout</h1>

    <div class="flex flex-col lg:flex-row gap-8">

        {{-- Checkout Form --}}
        <div class="flex-1">
            <form action="{{ route('checkout.store') }}" method="POST" class="bg-white rounded-2xl shadow-sm p-8 space-y-6">
                @csrf

                <h2 class="font-display text-xl font-bold mb-2" style="color:var(--charcoal)">Delivery Details</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold mb-1">Full Name *</label>
                        <input type="text" name="customer_name" value="{{ old('customer_name') }}"
                               placeholder="e.g. Amaka Johnson"
                               class="w-full border rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-rose-300 @error('customer_name') border-red-400 @enderror"
                               style="border-color:var(--blush)">
                        @error('customer_name')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Phone Number *</label>
                        <input type="tel" name="phone" value="{{ old('phone') }}"
                               placeholder="e.g. 08012345678"
                               class="w-full border rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-rose-300 @error('phone') border-red-400 @enderror"
                               style="border-color:var(--blush)">
                        @error('phone')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Email Address *</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           placeholder="e.g. amaka@email.com"
                           class="w-full border rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-rose-300 @error('email') border-red-400 @enderror"
                           style="border-color:var(--blush)">
                    @error('email')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs opacity-50 mt-1">Your order confirmation will be sent here.</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Delivery Address *</label>
                    <textarea name="address" rows="3"
                              placeholder="Enter your full delivery address..."
                              class="w-full border rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-rose-300 @error('address') border-red-400 @enderror"
                              style="border-color:var(--blush)">{{ old('address') }}</textarea>
                    @error('address')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Order Notes <span class="opacity-50">(optional)</span></label>
                    <textarea name="notes" rows="2"
                              placeholder="Any special requests or instructions?"
                              class="w-full border rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-rose-300"
                              style="border-color:var(--blush)">{{ old('notes') }}</textarea>
                </div>

                <div class="bg-rose-50 rounded-xl p-4 text-sm flex items-start gap-3">
                    <span class="text-2xl">🔒</span>
                    <div>
                        <p class="font-semibold">Secure Payment via Paystack</p>
                        <p class="opacity-70 mt-0.5">You'll be redirected to Paystack's secure payment page to complete your order.</p>
                    </div>
                </div>

                <button type="submit" class="btn-primary w-full text-center text-base py-3">
                    Place Order & Pay ₦{{ number_format($total, 0) }} →
                </button>
            </form>
        </div>

        {{-- Order Summary Sidebar --}}
        <div class="lg:w-72 shrink-0">
            <div class="bg-white rounded-2xl shadow-sm p-6 sticky top-24">
                <h2 class="font-display text-xl font-bold mb-5" style="color:var(--charcoal)">Order Summary</h2>

                <div class="space-y-3 text-sm">
                    @foreach($cart as $item)
                    <div class="flex items-center gap-3">
                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                             class="w-12 h-12 rounded-lg object-cover shrink-0"
                             onerror="this.src='https://placehold.co/48x48/F2C4B0/6B3F2A?text=🎂'">
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold truncate">{{ $item['name'] }}</p>
                            <p class="opacity-60 text-xs">× {{ $item['quantity'] }}</p>
                        </div>
                        <span class="font-bold shrink-0">₦{{ number_format($item['price'] * $item['quantity'], 0) }}</span>
                    </div>
                    @endforeach
                </div>

                <div class="border-t mt-4 pt-4 flex justify-between font-bold text-base" style="border-color:var(--blush)">
                    <span>Total</span>
                    <span style="color:var(--rose)">₦{{ number_format($total, 0) }}</span>
                </div>

                <a href="{{ route('cart.index') }}" class="block text-center text-xs mt-4 opacity-50 hover:opacity-100">
                    ← Edit cart
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
