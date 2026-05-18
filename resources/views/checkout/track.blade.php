@extends('layouts.app')
@section('title', 'Track Your Order')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
    <div class="flex items-center gap-3 mb-10 border-b border-[#F5E6D0]/50 pb-6">
        <span class="text-3xl">🚚</span>
        <div>
            <h1 class="font-display text-3xl font-extrabold text-[#3D1A08]">Order Tracker</h1>
            <p class="text-xs text-[#6B3A1F]/70 mt-1">Get real-time updates on your freshly baked treats.</p>
        </div>
    </div>

    {{-- Search Form --}}
    <div class="bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs p-6 md:p-8 mb-8">
        <form action="{{ route('order.track') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            <div>
                <label for="order_number" class="block text-xs font-bold uppercase tracking-wider text-[#6B3A1F]/80 mb-2">Order Reference</label>
                <input type="text" name="order_number" id="order_number" value="{{ request('order_number') }}" required placeholder="e.g. ORD-64A7E9..."
                       class="w-full px-4 py-3.5 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/50 text-sm font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all">
            </div>
            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-[#6B3A1F]/80 mb-2">Email Address</label>
                <input type="email" name="email" id="email" value="{{ request('email') }}" required placeholder="e.g. customer@example.com"
                       class="w-full px-4 py-3.5 rounded-2xl bg-[#FDF6EC] border border-[#F5E6D0]/50 text-sm font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition-all">
            </div>
            <div>
                <button type="submit" class="btn-primary w-full py-4 justify-center rounded-2xl text-xs uppercase tracking-wider font-extrabold shadow-md hover:shadow-lg transition-all">
                    Track Order
                </button>
            </div>
        </form>
    </div>

    @if(request()->has('order_number'))
        @if($order)
            {{-- Order Details & Visual Stepper --}}
            <div class="space-y-8">
                
                {{-- visual Stepper card --}}
                <div class="bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs p-6 md:p-8">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-[#F5E6D0]/45 pb-6 mb-8">
                        <div>
                            <span class="text-xs font-bold uppercase tracking-widest text-rose-500">Live Progress Status</span>
                            <h2 class="font-display font-extrabold text-xl text-[#3D1A08] mt-1">{{ $order->order_number }}</h2>
                        </div>
                        <div class="text-left sm:text-right">
                            <span class="text-xs text-[#6B3A1F]/60 font-semibold block">Date Placed</span>
                            <span class="text-sm font-bold text-[#3D1A08]">{{ $order->created_at->format('M d, Y h:i A') }}</span>
                        </div>
                    </div>

                    @if($order->status === 'cancelled')
                        <div class="bg-rose-50 border border-rose-100 p-6 rounded-2xl text-center">
                            <span class="text-4xl">❌</span>
                            <h3 class="font-display font-bold text-lg text-rose-700 mt-2">Order Cancelled</h3>
                            <p class="text-sm text-rose-600/90 mt-1 max-w-md mx-auto">This order has been cancelled. If you believe this is an error or need further assistance, please contact our support team.</p>
                        </div>
                    @else
                        {{-- Premium visual Timeline Step Track --}}
                        @php
                            $statuses = ['pending', 'paid', 'processing', 'delivered'];
                            $currentIndex = array_search($order->status, $statuses);
                            if ($currentIndex === false && $order->status === 'cancelled') $currentIndex = -1;
                            
                            $steps = [
                                ['🛒', 'Order Placed', 'Pending payment confirmation.'],
                                ['💳', 'Payment Confirmed', 'Verified & secure.'],
                                ['👨‍🍳', 'Baking & Preparing', 'Freshly crafting your goodies.'],
                                ['🎉', 'Delivered', 'Delicious treats arrived!'],
                            ];
                        @endphp
                        
                        <div class="relative flex flex-col md:flex-row justify-between items-stretch md:items-center gap-8 md:gap-4 md:px-4">
                            {{-- horizontal line for larger viewports --}}
                            <div class="absolute top-[26px] left-10 right-10 h-0.5 bg-[#F5E6D0] hidden md:block z-0">
                                <div class="h-full bg-rose-500 transition-all duration-500" style="width: {{ $currentIndex !== false ? ($currentIndex / (count($steps) - 1)) * 100 : 0 }}%"></div>
                            </div>

                            @foreach($steps as $idx => $step)
                                @php
                                    $isCompleted = $idx < $currentIndex;
                                    $isActive = $idx === $currentIndex;
                                    $isFuture = $idx > $currentIndex;
                                @endphp
                                <div class="flex md:flex-col items-center gap-4 md:gap-3 text-left md:text-center md:flex-1 relative z-10">
                                    {{-- node icon --}}
                                    <div class="w-14 h-14 rounded-full flex items-center justify-center border-2 transition-all duration-300 shadow-sm
                                        {{ $isCompleted ? 'bg-rose-500 border-rose-500 text-white' : '' }}
                                        {{ $isActive ? 'bg-white border-rose-500 text-rose-500 ring-4 ring-rose-500/10' : '' }}
                                        {{ $isFuture ? 'bg-[#FDF6EC] border-[#F5E6D0] text-[#6B3A1F]/40' : '' }}">
                                        @if($isCompleted)
                                            <span class="text-lg font-bold">✓</span>
                                        @else
                                            <span class="text-xl">{{ $step[0] }}</span>
                                        @endif
                                    </div>
                                    
                                    {{-- label description --}}
                                    <div>
                                        <h4 class="font-display font-extrabold text-sm {{ $isActive || $isCompleted ? 'text-[#3D1A08]' : 'text-[#6B3A1F]/60' }}">
                                            {{ $step[1] }}
                                        </h4>
                                        <p class="text-[10px] text-[#6B3A1F]/60 leading-normal max-w-xs mt-0.5">{{ $step[2] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Delivery details & Items Summary --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    {{-- Customer Details --}}
                    <div class="bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs p-6 space-y-4">
                        <h3 class="font-display font-extrabold text-lg text-[#3D1A08] border-b border-[#F5E6D0]/45 pb-3">Delivery Information</h3>
                        <div class="space-y-3 text-xs">
                            <div class="flex justify-between">
                                <span class="text-[#6B3A1F]/70">Recipient</span>
                                <span class="font-bold text-[#3D1A08]">{{ $order->customer_name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-[#6B3A1F]/70">Email Address</span>
                                <span class="font-bold text-[#3D1A08]">{{ $order->email }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-[#6B3A1F]/70">Phone Number</span>
                                <span class="font-bold text-[#3D1A08]">{{ $order->phone }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-[#6B3A1F]/70">Delivery Address</span>
                                <span class="font-bold text-[#3D1A08] text-right max-w-[200px]">{{ $order->address }}, {{ $order->city }}</span>
                            </div>
                            @if($order->notes)
                            <div class="flex justify-between border-t border-[#FDF6EC] pt-3">
                                <span class="text-[#6B3A1F]/70">Special Notes</span>
                                <span class="font-semibold text-[#6B3A1F] italic text-right max-w-[200px]">{{ $order->notes }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- Items Details --}}
                    <div class="bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs p-6 space-y-4">
                        <h3 class="font-display font-extrabold text-lg text-[#3D1A08] border-b border-[#F5E6D0]/45 pb-3">Order Items</h3>
                        <div class="space-y-3 text-xs max-h-48 overflow-y-auto pr-1">
                            @foreach($order->items as $item)
                            <div class="flex justify-between items-center">
                                <span class="text-[#6B3A1F]/80 truncate pr-4">
                                    {{ $item->product_name }} 
                                    <span class="font-bold text-[#3D1A08]">× {{ $item->quantity }}</span>
                                </span>
                                <span class="font-bold text-[#3D1A08]">₦{{ number_format($item->price * $item->quantity, 0) }}</span>
                            </div>
                            @endforeach
                        </div>
                        <div class="border-t border-[#F5E6D0]/45 pt-4 flex justify-between items-center text-sm">
                            <span class="font-extrabold text-[#3D1A08]">Total Paid Amount</span>
                            <span class="font-display font-bold text-lg text-rose-600">₦{{ number_format($order->total_amount, 0) }}</span>
                        </div>
                    </div>

                </div>

            </div>
        @else
            {{-- Error Message - Not Found --}}
            <div class="bg-rose-50 border border-rose-100 p-8 rounded-3xl text-center max-w-md mx-auto">
                <span class="text-4xl">🧁</span>
                <h3 class="font-display font-bold text-lg text-rose-700 mt-3">Order Not Found</h3>
                <p class="text-sm text-rose-600/90 mt-1">We couldn't locate any order matching the reference and email address provided. Please double-check your credentials and try again.</p>
            </div>
        @endif
    @endif
</div>
@endsection
