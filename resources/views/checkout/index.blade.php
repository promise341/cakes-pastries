@extends('layouts.app')
@section('title', 'Premium Checkout')

@section('content')
@php 
    $defaultAddress = auth()->check() ? auth()->user()->addresses()->where('is_default', true)->first() : null;
@endphp
<div class="max-w-6xl mx-auto px-4 py-12 space-y-8" x-data="{ payMethod: 'paystack' }">
    
    <nav class="text-xs uppercase tracking-widest text-[#6B3A1F]/70 flex flex-wrap items-center gap-2">
        <a href="{{ route('home') }}" class="hover:text-rose-600 transition-colors font-bold">Home</a> 
        <span class="opacity-50">/</span>
        <a href="{{ route('cart.index') }}" class="hover:text-rose-600 transition-colors font-bold">Cart</a> 
        <span class="opacity-50">/</span>
        <span class="font-extrabold text-rose-600">Checkout</span>
    </nav>

    <div class="flex flex-col lg:flex-row gap-10">

        {{-- Left Form Column --}}
        <div class="flex-grow space-y-6">
            
            <form action="{{ route('checkout.store') }}" method="POST" class="bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs p-8 sm:p-10 space-y-6">
                @csrf

                <div class="border-b border-[#F5E6D0]/40 pb-4 mb-4">
                    <h2 class="font-display text-2xl font-extrabold text-[#3D1A08]">Hand-Delivery</h2>
                    <p class="text-xs text-[#6B3A1F]/60">We prepare all baked goods fresh on the day of delivery.</p>
                </div>

                {{-- Autofill alert if default address was loaded --}}
                @if($defaultAddress)
                <div class="p-3.5 bg-emerald-50 rounded-2xl border border-emerald-100 flex items-center gap-3 text-xs font-semibold text-emerald-700 animate-fadein">
                    <span>📍</span>
                    <span>Autofilled using your default delivery address: <strong class="underline">{{ $defaultAddress->customer_name }}</strong>.</span>
                </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Customer Name --}}
                    <div class="relative">
                        <input type="text" name="customer_name" id="name" required placeholder=" "
                               value="{{ $defaultAddress ? $defaultAddress->customer_name : (auth()->check() ? auth()->user()->name : old('customer_name')) }}"
                               class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all">
                        <label for="name" class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60 peer-placeholder-shown:text-xs peer-placeholder-shown:top-4 peer-placeholder-shown:font-semibold peer-focus:top-2 peer-focus:text-[9px] peer-focus:text-rose-500 pointer-events-none">Full Name</label>
                        @error('customer_name') <p class="text-[10px] text-rose-500 mt-1 font-semibold pl-2">⚠️ {{ $message }}</p> @enderror
                    </div>

                    {{-- Customer Phone --}}
                    <div class="relative">
                        <input type="tel" name="phone" id="phone" required placeholder=" "
                               value="{{ $defaultAddress ? $defaultAddress->phone : old('phone') }}"
                               class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all">
                        <label for="phone" class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60 peer-placeholder-shown:text-xs peer-placeholder-shown:top-4 peer-placeholder-shown:font-semibold peer-focus:top-2 peer-focus:text-[9px] peer-focus:text-rose-500 pointer-events-none">Phone Contact</label>
                        @error('phone') <p class="text-[10px] text-rose-500 mt-1 font-semibold pl-2">⚠️ {{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Customer Email --}}
                <div class="relative">
                    <input type="email" name="email" id="email" required placeholder=" "
                           value="{{ auth()->check() ? auth()->user()->email : old('email') }}"
                           class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all">
                    <label for="email" class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60 peer-placeholder-shown:text-xs peer-placeholder-shown:top-4 peer-placeholder-shown:font-semibold peer-focus:top-2 peer-focus:text-[9px] peer-focus:text-rose-500 pointer-events-none">Email Coordinates</label>
                    @error('email') <p class="text-[10px] text-rose-500 mt-1 font-semibold pl-2">⚠️ {{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    {{-- Delivery Address --}}
                    <div class="sm:col-span-2 relative">
                        <input type="text" name="address" id="address" required placeholder=" "
                               value="{{ $defaultAddress ? $defaultAddress->address_line_1 . ($defaultAddress->address_line_2 ? ', ' . $defaultAddress->address_line_2 : '') : old('address') }}"
                               class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all">
                        <label for="address" class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60 peer-placeholder-shown:text-xs peer-placeholder-shown:top-4 peer-placeholder-shown:font-semibold peer-focus:top-2 peer-focus:text-[9px] peer-focus:text-rose-500 pointer-events-none">Street Address</label>
                        @error('address') <p class="text-[10px] text-rose-500 mt-1 font-semibold pl-2">⚠️ {{ $message }}</p> @enderror
                    </div>

                    {{-- City --}}
                    <div class="relative">
                        <input type="text" name="city" id="city" required placeholder=" "
                               value="{{ $defaultAddress ? $defaultAddress->city . ', ' . $defaultAddress->state : old('city') }}"
                               class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all">
                        <label for="city" class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60 peer-placeholder-shown:text-xs peer-placeholder-shown:top-4 peer-placeholder-shown:font-semibold peer-focus:top-2 peer-focus:text-[9px] peer-focus:text-rose-500 pointer-events-none">City / State</label>
                        @error('city') <p class="text-[10px] text-rose-500 mt-1 font-semibold pl-2">⚠️ {{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Notes --}}
                <div class="relative">
                    <textarea name="notes" id="notes" rows="2" placeholder=" "
                              class="peer w-full px-4 py-3.5 pt-5 pb-2 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/50 text-xs font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all">{{ old('notes') }}</textarea>
                    <label for="notes" class="absolute left-4 top-2 text-[9px] uppercase tracking-wider font-extrabold text-[#6B3A1F]/60 peer-placeholder-shown:text-xs peer-placeholder-shown:top-4 peer-placeholder-shown:font-semibold peer-focus:top-2 peer-focus:text-[9px] peer-focus:text-rose-500 pointer-events-none">Special Instructions/Bake notes</label>
                </div>

                {{-- Payment Method Chooser --}}
                <div class="space-y-3 pt-2">
                    <span class="text-[10px] uppercase tracking-wider text-[#6B3A1F]/60 font-extrabold block">Secure Settlement Options</span>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <label class="p-4 rounded-2xl border cursor-pointer flex flex-col justify-between transition-all"
                               :class="payMethod === 'paystack' ? 'border-[#3D1A08] bg-[#FDF6EC]' : 'border-[#F5E6D0]/50 bg-white hover:border-[#6B3A1F]'">
                            <input type="radio" name="payment_gateway" value="paystack" class="hidden" @click="payMethod = 'paystack'" checked>
                            <span class="text-xs font-extrabold text-[#3D1A08]">💳 Paystack Gateway</span>
                            <span class="text-[10px] text-[#6B3A1F]/60 mt-1 font-bold">Supports Cards, USSD, and Bank Transfers.</span>
                        </label>
                        <label class="p-4 rounded-2xl border cursor-pointer flex flex-col justify-between transition-all"
                               :class="payMethod === 'stripe' ? 'border-[#3D1A08] bg-[#FDF6EC]' : 'border-[#F5E6D0]/50 bg-white hover:border-[#6B3A1F]'">
                            <input type="radio" name="payment_gateway" value="stripe" class="hidden" @click="payMethod = 'stripe'">
                            <span class="text-xs font-extrabold text-[#3D1A08]">🧁 Stripe International</span>
                            <span class="text-[10px] text-[#6B3A1F]/60 mt-1 font-bold">Global currency checkout with Stripe stub.</span>
                        </label>
                    </div>
                </div>

                {{-- Stripe Stub Card Form --}}
                <div x-show="payMethod === 'stripe'" class="p-5 rounded-2xl bg-[#FDF6EC]/40 border border-[#F5E6D0]/30 space-y-4 animate-fadein">
                    <div class="flex items-center justify-between text-xs border-b border-[#F5E6D0]/30 pb-2">
                        <span class="font-extrabold text-[#3D1A08]">Stripe Mock Checkout Simulator</span>
                        <span class="bg-rose-100 text-rose-600 text-[9px] font-extrabold px-2 py-0.5 rounded-full">Test Environment</span>
                    </div>
                    
                    <div class="relative">
                        <input type="text" placeholder="4242 4242 4242 4242" 
                               class="w-full px-4 py-3 rounded-xl bg-white border border-[#F5E6D0] text-xs font-bold focus:outline-none">
                        <span class="absolute right-4 top-3.5 text-xs">💳</span>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <input type="text" placeholder="MM / YY" 
                               class="w-full px-4 py-3 rounded-xl bg-white border border-[#F5E6D0] text-xs font-bold focus:outline-none">
                        <input type="password" placeholder="CVC" 
                               class="w-full px-4 py-3 rounded-xl bg-white border border-[#F5E6D0] text-xs font-bold focus:outline-none">
                    </div>
                </div>

                <button type="submit" class="btn-primary w-full py-4 justify-center rounded-2xl text-xs uppercase tracking-wider font-extrabold shadow-md hover:shadow-lg transition-all mt-2">
                    Complete Secure Checkout ₦{{ number_format(max(0, $total - $discount), 0) }} 🧁
                </button>
            </form>
        </div>

        {{-- Right summary Sidebar --}}
        <div class="lg:w-80 shrink-0">
            <div class="bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs p-6 sticky top-24 space-y-6">
                <h2 class="font-display text-xl font-extrabold text-[#3D1A08] border-b border-[#F5E6D0]/50 pb-4">Checkout Items</h2>

                <div class="space-y-3 text-xs">
                    @foreach($cart as $item)
                    <div class="flex justify-between items-center">
                        <span class="text-[#6B3A1F]/80 truncate pr-4">{{ $item['name'] }} <span class="font-bold text-[#3D1A08]">× {{ $item['quantity'] }}</span></span>
                        <span class="font-bold text-[#3D1A08]">₦{{ number_format($item['price'] * $item['quantity'], 0) }}</span>
                    </div>
                    @endforeach
                </div>

                <div class="border-t border-[#F5E6D0]/50 pt-4 space-y-2">
                    <div class="flex justify-between text-xs font-semibold text-[#6B3A1F]">
                        <span>Subtotal</span>
                        <span>₦{{ number_format($total, 0) }}</span>
                    </div>
                    @if($discount > 0)
                    <div class="flex justify-between text-xs font-bold text-emerald-600">
                        <span>Discount Applied</span>
                        <span>- ₦{{ number_format($discount, 0) }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between items-center border-t border-[#FDF6EC] pt-2">
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-[#6B3A1F]/60 font-semibold block">Total Due</span>
                            <span class="text-[10px] text-emerald-600 font-bold block">✓ Delivery fee included</span>
                        </div>
                        <span class="font-display font-bold text-lg text-rose-600">₦{{ number_format(max(0, $total - $discount), 0) }}</span>
                    </div>
                </div>

                <a href="{{ route('cart.index') }}" class="block text-center text-[10px] uppercase tracking-widest font-extrabold text-[#6B3A1F]/60 hover:text-rose-600 transition-colors">
                    ← Adjust Items
                </a>
            </div>
        </div>

    </div>

</div>
@endsection
