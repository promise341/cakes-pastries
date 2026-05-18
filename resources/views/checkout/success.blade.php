@extends('layouts.app')
@section('title', 'Order Confirmed!')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-16 text-center">

    <div class="bg-white rounded-3xl shadow-md p-10">
        <div class="text-6xl mb-4">🎉</div>
        <h1 class="font-display text-3xl font-bold mb-3" style="color:var(--charcoal)">
            Order Confirmed!
        </h1>
        <p class="opacity-70 mb-2">
            Thank you, <strong>{{ $order->customer_name }}</strong>! Your order has been placed successfully.
        </p>
        <p class="text-sm opacity-50 mb-8">
            A confirmation email has been sent to <strong>{{ $order->email }}</strong>.
        </p>

        {{-- Order Details Card --}}
        <div class="bg-rose-50 rounded-2xl p-6 text-left mb-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-bold text-sm uppercase tracking-wider" style="color:var(--gold)">Order Details</h2>
                <span class="badge badge-available">Paid ✓</span>
            </div>

            <div class="grid grid-cols-2 gap-3 text-sm mb-5">
                <div>
                    <p class="opacity-50 text-xs">Order Number</p>
                    <p class="font-bold">#{{ $order->id }}</p>
                </div>
                <div>
                    <p class="opacity-50 text-xs">Total Amount</p>
                    <p class="font-bold" style="color:var(--rose)">₦{{ number_format($order->total_amount, 0) }}</p>
                </div>
                <div>
                    <p class="opacity-50 text-xs">Phone</p>
                    <p class="font-semibold">{{ $order->phone }}</p>
                </div>
                <div>
                    <p class="opacity-50 text-xs">Payment Ref</p>
                    <p class="font-semibold text-xs truncate">{{ $order->payment_reference }}</p>
                </div>
                <div class="col-span-2">
                    <p class="opacity-50 text-xs">Delivery Address</p>
                    <p class="font-semibold">{{ $order->address }}</p>
                </div>
            </div>

            <h3 class="font-bold text-xs uppercase tracking-wider opacity-50 mb-3">Items Ordered</h3>
            <div class="space-y-2">
                @foreach($order->items as $item)
                <div class="flex justify-between text-sm">
                    <span>{{ $item->product?->name ?? 'Product' }} × {{ $item->quantity }}</span>
                    <span class="font-semibold">₦{{ number_format($item->subtotal, 0) }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('products.index') }}" class="btn-primary">Continue Shopping</a>
            <a href="{{ route('home') }}" class="btn-outline">Back to Home</a>
        </div>
    </div>

</div>
@endsection
