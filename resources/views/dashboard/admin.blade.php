@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-12 space-y-10">

    {{-- Welcome Admin --}}
    <div class="flex items-center gap-3 border-b border-[#F5E6D0]/50 pb-6">
        <span class="text-4xl">🔐</span>
        <div>
            <h1 class="font-display text-3xl font-extrabold text-[#3D1A08]">Admin Analytics Console</h1>
            <p class="text-xs text-[#6B3A1F]/70 mt-1">Real-time statistics overview and interactive customer orders manager.</p>
        </div>
    </div>

    {{-- Admin Navigation Strip --}}
    <div class="flex gap-3 overflow-x-auto pb-2 border-b border-[#FDF6EC] text-[10px] uppercase tracking-wider font-extrabold text-[#6B3A1F]">
        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2.5 rounded-xl bg-[#3D1A08] text-[#F5E6D0] hover:scale-105 transition-transform shrink-0">📈 Dashboard</a>
        <a href="{{ route('admin.products.index') }}" class="px-4 py-2.5 rounded-xl bg-white border border-[#F5E6D0] hover:bg-[#FDF6EC] hover:scale-105 transition-transform shrink-0">🧁 Products</a>
        <a href="{{ route('admin.categories.index') }}" class="px-4 py-2.5 rounded-xl bg-white border border-[#F5E6D0] hover:bg-[#FDF6EC] hover:scale-105 transition-transform shrink-0">📂 Categories</a>
        <a href="{{ route('admin.coupons.index') }}" class="px-4 py-2.5 rounded-xl bg-white border border-[#F5E6D0] hover:bg-[#FDF6EC] hover:scale-105 transition-transform shrink-0">🎫 Coupons</a>
        <a href="{{ route('admin.users.index') }}" class="px-4 py-2.5 rounded-xl bg-white border border-[#F5E6D0] hover:bg-[#FDF6EC] hover:scale-105 transition-transform shrink-0">👥 Users Access</a>
    </div>

    {{-- Analytics Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        {{-- Card 1: Total Revenue --}}
        <div class="stat-card bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs p-6 space-y-2 transition-all duration-300 hover:shadow-md hover:-translate-y-1">
            <span class="text-3xl">💰</span>
            <div>
                <span class="text-[10px] uppercase tracking-wider text-[#6B3A1F]/60 font-bold block">Total Revenue</span>
                <span id="statSales" class="text-2xl font-extrabold text-[#3D1A08]">₦0</span>
            </div>
        </div>

        {{-- Card 2: Active Products --}}
        <div class="stat-card bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs p-6 space-y-2 transition-all duration-300 hover:shadow-md hover:-translate-y-1">
            <span class="text-3xl">🧁</span>
            <div>
                <span class="text-[10px] uppercase tracking-wider text-[#6B3A1F]/60 font-bold block">Active Products</span>
                <span id="statProducts" class="text-2xl font-extrabold text-[#3D1A08]">0</span>
            </div>
        </div>

        {{-- Card 3: Users Registered --}}
        <div class="stat-card bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs p-6 space-y-2 transition-all duration-300 hover:shadow-md hover:-translate-y-1">
            <span class="text-3xl">👥</span>
            <div>
                <span class="text-[10px] uppercase tracking-wider text-[#6B3A1F]/60 font-bold block">Registered Users</span>
                <span id="statUsers" class="text-2xl font-extrabold text-[#3D1A08]">0</span>
            </div>
        </div>

        {{-- Card 4: Pending Orders --}}
        <div class="stat-card bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs p-6 space-y-2 transition-all duration-300 hover:shadow-md hover:-translate-y-1">
            <span class="text-3xl">⏳</span>
            <div>
                <span class="text-[10px] uppercase tracking-wider text-[#6B3A1F]/60 font-bold block">Pending Orders</span>
                <span id="statPending" class="text-2xl font-extrabold text-[#3D1A08]">0</span>
            </div>
        </div>

    </div>

    {{-- Interactive Orders Table --}}
    <div class="bg-white rounded-3xl border border-[#F5E6D0]/40 shadow-xs p-6 space-y-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-display text-2xl font-bold text-[#3D1A08]">Recent Customer Orders</h2>
            <span class="text-xs font-semibold text-[#6B3A1F]/60">Showing {{ $orders->count() }} recent listings</span>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-[#FDF6EC]">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-[#FDF6EC] text-[#6B3A1F]/80 uppercase font-extrabold tracking-wider border-b border-[#F5E6D0]/50">
                        <th class="p-4">Order Reference</th>
                        <th class="p-4">Customer Details</th>
                        <th class="p-4">Total Amount</th>
                        <th class="p-4">Date Placed</th>
                        <th class="p-4">Order Status</th>
                        <th class="p-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#FDF6EC]">
                    @foreach($orders as $order)
                    <tr class="hover:bg-[#FDF6EC]/20 transition-all">
                        <td class="p-4 font-bold text-[#3D1A08]">
                            {{ $order->order_number }}
                            <span class="block text-[10px] font-bold mt-1">
                                @if($order->payment_status === 'paid')
                                    <span class="text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-100">Paid</span>
                                @else
                                    <span class="text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full border border-amber-100">Unpaid</span>
                                @endif
                            </span>
                        </td>
                        <td class="p-4">
                            <p class="font-bold text-[#3D1A08]">{{ $order->customer_name }}</p>
                            <p class="text-[#6B3A1F]/70 text-[10px]">{{ $order->email }}</p>
                        </td>
                        <td class="p-4 font-display font-bold text-sm text-[#3D1A08]">
                            ₦{{ number_format($order->total_amount, 0) }}
                        </td>
                        <td class="p-4 text-[#6B3A1F]/80">
                            {{ $order->created_at->format('M d, Y h:i A') }}
                        </td>
                        <td class="p-4">
                            <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                                @csrf
                                <select name="status" onchange="this.form.submit()" 
                                        class="px-3 py-2 rounded-xl bg-[#FDF6EC] border border-[#F5E6D0] font-semibold text-[#3D1A08] focus:outline-none focus:ring-2 focus:ring-rose-500 cursor-pointer">
                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </form>
                        </td>
                        <td class="p-4 text-center">
                            <a href="{{ route('order.track') }}?order_number={{ $order->order_number }}&email={{ urlencode($order->email) }}" 
                               target="_blank"
                               class="inline-block px-3 py-1.5 rounded-full border border-[#F5E6D0] text-[#6B3A1F] font-bold hover:bg-[#FDF6EC] transition-all">
                                View Stepper ↗
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="pt-4">
            {{ $orders->links() }}
        </div>

    </div>

</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // fluid reveal on card layouts using GSAP
        gsap.from('.stat-card', {
            opacity: 0,
            y: 20,
            stagger: 0.1,
            duration: 0.6,
            ease: 'power2.out'
        });

        // custom count-up numbers using GSAP ticker object
        const counter = (targetId, endValue, prefix = '') => {
            const obj = { val: 0 };
            gsap.to(obj, {
                val: endValue,
                duration: 1.5,
                ease: 'power3.out',
                onUpdate: () => {
                    document.getElementById(targetId).innerText = prefix + Math.floor(obj.val).toLocaleString();
                }
            });
        };

        // Trigger dynamic count-ups
        counter('statSales', {{ $totalSales }}, '₦');
        counter('statProducts', {{ $activeProductsCount }});
        counter('statUsers', {{ $totalUsersCount }});
        counter('statPending', {{ $pendingOrdersCount }});
    });
</script>
@endsection
