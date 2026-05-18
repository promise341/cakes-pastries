@extends('layouts.app')
@section('title', 'My Dashboard')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-12 space-y-10">
    
    {{-- Welcome Header --}}
    <div class="flex items-center gap-3 border-b border-[#F5E6D0]/50 pb-6">
        <span class="text-4xl">👑</span>
        <div>
            <h1 class="font-display text-3xl font-extrabold text-[#3D1A08]">Hello, {{ auth()->user()->name }}!</h1>
            <p class="text-xs text-[#6B3A1F]/70 mt-1">Welcome to your personal dessert dashboard. View your order stats and tracking details below.</p>
        </div>
    </div>

    {{-- Metrics Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        {{-- Card 1: Total Orders --}}
        <div class="metric-card bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs p-6 flex items-center gap-4 transition-all duration-300 hover:shadow-md hover:-translate-y-1">
            <div class="w-12 h-12 rounded-2xl bg-[#FDF6EC] flex items-center justify-center text-xl shrink-0">📦</div>
            <div>
                <span class="text-[10px] uppercase tracking-wider text-[#6B3A1F]/60 font-semibold block">Total Orders</span>
                <span id="metricOrders" class="text-2xl font-extrabold text-[#3D1A08]">{{ $totalOrders }}</span>
            </div>
        </div>

        {{-- Card 2: Total Spent --}}
        <div class="metric-card bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs p-6 flex items-center gap-4 transition-all duration-300 hover:shadow-md hover:-translate-y-1">
            <div class="w-12 h-12 rounded-2xl bg-[#FDF6EC] flex items-center justify-center text-xl shrink-0">💳</div>
            <div>
                <span class="text-[10px] uppercase tracking-wider text-[#6B3A1F]/60 font-semibold block">Total Spent</span>
                <span id="metricSpent" class="text-2xl font-extrabold text-[#3D1A08]">₦{{ number_format($totalSpent, 0) }}</span>
            </div>
        </div>

        {{-- Card 3: Pending Deliveries --}}
        <div class="metric-card bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs p-6 flex items-center gap-4 transition-all duration-300 hover:shadow-md hover:-translate-y-1">
            <div class="w-12 h-12 rounded-2xl bg-[#FDF6EC] flex items-center justify-center text-xl shrink-0">🚚</div>
            <div>
                <span class="text-[10px] uppercase tracking-wider text-[#6B3A1F]/60 font-semibold block">Pending Deliveries</span>
                <span id="metricDeliveries" class="text-2xl font-extrabold text-[#3D1A08]">{{ $pendingDeliveries }}</span>
            </div>
        </div>

    </div>

    {{-- Orders History Section --}}
    <div class="space-y-6">
        <h2 class="font-display text-2xl font-bold text-[#3D1A08]">My Order History</h2>

        @if($orders->isEmpty())
            <div class="text-center py-16 bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs max-w-lg mx-auto">
                <span class="text-5xl">🧁</span>
                <h3 class="font-display text-xl font-bold text-[#3D1A08] mt-4 mb-2">No orders placed yet</h3>
                <p class="text-xs text-[#6B3A1F]/70 max-w-xs mx-auto mb-6">Create your first order to experience our delicious treats delivered right to your door!</p>
                <a href="{{ route('products.index') }}" class="btn-primary py-3 px-8 rounded-full text-xs uppercase tracking-widest font-extrabold shadow-sm">
                    Browse Delicacies
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($orders as $order)
                <div class="bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs p-6 transition-all duration-200 hover:shadow-sm">
                    
                    {{-- Order Header --}}
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-[#F5E6D0]/30 pb-4 mb-4">
                        <div>
                            <div class="flex items-center gap-3">
                                <span class="font-display font-extrabold text-lg text-[#3D1A08]">{{ $order->order_number }}</span>
                                
                                {{-- Payment Status Badge --}}
                                @if($order->payment_status === 'paid')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase bg-emerald-50 text-emerald-600 border border-emerald-100">Paid</span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase bg-amber-50 text-amber-600 border border-amber-100">Unpaid</span>
                                @endif
                                
                                {{-- Delivery Status Badge --}}
                                @php
                                    $badgeColors = [
                                        'pending'    => 'bg-rose-50 text-rose-500 border-rose-100',
                                        'paid'       => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                        'processing' => 'bg-sky-50 text-sky-600 border-sky-100',
                                        'delivered'  => 'bg-teal-50 text-teal-600 border-teal-100',
                                        'cancelled'  => 'bg-red-50 text-red-600 border-red-100',
                                    ];
                                    $badgeColor = $badgeColors[$order->status] ?? 'bg-gray-50 text-gray-600 border-gray-100';
                                @endphp
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase border {{ $badgeColor }}">
                                    {{ $order->status }}
                                </span>
                            </div>
                            <span class="text-[10px] text-[#6B3A1F]/60 mt-1 block">Placed on {{ $order->created_at->format('M d, Y h:i A') }}</span>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <span class="font-display font-extrabold text-xl text-rose-600">₦{{ number_format($order->total_amount, 0) }}</span>
                            <a href="{{ route('order.track') }}?order_number={{ $order->order_number }}&email={{ urlencode($order->email) }}" 
                               class="px-4 py-2 rounded-full border border-[#F5E6D0] hover:bg-[#FDF6EC] transition-all text-xs font-bold text-[#6B3A1F] shadow-xs">
                                Track Live →
                            </a>
                        </div>
                    </div>

                    {{-- Order Items Sublist --}}
                    <div class="space-y-2">
                        <p class="text-[10px] uppercase tracking-wider text-[#6B3A1F]/50 font-bold">Ordered Treats</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                            @foreach($order->items as $item)
                            <div class="flex justify-between items-center bg-[#FDF6EC]/40 p-2.5 rounded-xl border border-[#F5E6D0]/10">
                                <span class="font-semibold text-[#3D1A08] truncate max-w-[200px]">{{ $item->product_name }}</span>
                                <span class="text-[#6B3A1F] font-bold">×{{ $item->quantity }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // fluid scale reveal on metrics using GSAP
        gsap.from('.metric-card', {
            opacity: 0,
            y: 20,
            stagger: 0.15,
            duration: 0.8,
            ease: 'power3.out'
        });
    });
</script>
@endsection
