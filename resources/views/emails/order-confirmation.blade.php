<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmed</title>
    <style>
        body { font-family: 'Georgia', serif; background: #FDF8F0; margin: 0; padding: 20px; color: #2C1810; }
        .container { max-width: 560px; margin: 0 auto; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(107,63,42,0.1); }
        .header { background: #C0675A; color: #fff; padding: 32px 32px 24px; text-align: center; }
        .header h1 { margin: 0; font-size: 24px; }
        .header p { margin: 8px 0 0; opacity: 0.9; font-size: 14px; }
        .body { padding: 32px; }
        .section-title { font-size: 11px; text-transform: uppercase; letter-spacing: 1.5px; color: #D4A853; font-weight: bold; margin: 0 0 12px; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; background: #FDF8F0; border-radius: 12px; padding: 20px; margin-bottom: 24px; }
        .info-item p { margin: 0; }
        .info-item .label { font-size: 11px; opacity: 0.5; margin-bottom: 2px; }
        .info-item .value { font-size: 14px; font-weight: bold; }
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        .items-table th { text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; opacity: 0.5; padding: 0 0 8px; border-bottom: 1px solid #F2C4B0; }
        .items-table td { padding: 10px 0; border-bottom: 1px solid #FDF8F0; font-size: 14px; }
        .total-row td { font-weight: bold; font-size: 16px; color: #C0675A; border-bottom: none; padding-top: 16px; }
        .footer { background: #6B3F2A; color: #fff; text-align: center; padding: 24px; font-size: 12px; opacity: 0.9; }
        .footer a { color: #F2C4B0; }
        .badge { display: inline-block; background: #d1fae5; color: #065f46; padding: 4px 12px; border-radius: 999px; font-size: 12px; font-weight: bold; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <p style="font-size:36px; margin:0 0 8px">🎂</p>
        <h1>Order Confirmed!</h1>
        <p>Thank you for your order, {{ $order->customer_name }}.</p>
    </div>

    <div class="body">
        <p style="font-size:14px; opacity:0.7; margin-top:0">
            We've received your order and it's now being prepared. You'll hear from us when it's on its way!
        </p>

        <p class="section-title">Order Summary</p>
        <div class="info-grid">
            <div class="info-item">
                <p class="label">Order Number</p>
                <p class="value">#{{ $order->id }}</p>
            </div>
            <div class="info-item">
                <p class="label">Payment Status</p>
                <p class="value"><span class="badge">Paid ✓</span></p>
            </div>
            <div class="info-item">
                <p class="label">Phone</p>
                <p class="value">{{ $order->phone }}</p>
            </div>
            <div class="info-item">
                <p class="label">Date</p>
                <p class="value">{{ $order->created_at->format('d M Y') }}</p>
            </div>
            <div class="info-item" style="grid-column: span 2">
                <p class="label">Delivery Address</p>
                <p class="value">{{ $order->address }}</p>
            </div>
        </div>

        <p class="section-title">Items Ordered</p>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th style="text-align:center">Qty</th>
                    <th style="text-align:right">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product?->name ?? 'Product' }}</td>
                    <td style="text-align:center">{{ $item->quantity }}</td>
                    <td style="text-align:right">₦{{ number_format($item->subtotal, 0) }}</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="2">Total</td>
                    <td style="text-align:right">₦{{ number_format($order->total_amount, 0) }}</td>
                </tr>
            </tbody>
        </table>

        @if($order->notes)
        <p class="section-title">Your Notes</p>
        <p style="font-size:13px; opacity:0.7; background:#FDF8F0; padding:12px 16px; border-radius:8px;">
            {{ $order->notes }}
        </p>
        @endif

        <p style="font-size:13px; opacity:0.6; margin-top:24px; margin-bottom:0">
            Questions? Reply to this email or call us at <strong>+234 800 000 0000</strong>.
        </p>
    </div>

    <div class="footer">
        <p style="margin:0 0 4px">🎂 <strong>Cakes and Pastries</strong> · Lagos, Nigeria</p>
        <p style="margin:0; opacity:0.7">Made with love for every celebration</p>
    </div>
</div>
</body>
</html>
