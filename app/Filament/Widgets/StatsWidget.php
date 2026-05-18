<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $todayRevenue  = Order::where('payment_status', 'paid')->whereDate('created_at', today())->sum('total_amount');
        $totalRevenue  = Order::where('payment_status', 'paid')->sum('total_amount');
        $pendingOrders = Order::where('status', 'pending')->count();
        $totalOrders   = Order::count();
        $totalProducts = Product::where('status', 'active')->count();
        $lowStock      = Product::where('status', 'active')->where('stock', '<=', 5)->count();

        return [
            Stat::make("Today's Revenue", '₦' . number_format($todayRevenue, 2))
                ->description('Payments received today')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Total Revenue', '₦' . number_format($totalRevenue, 2))
                ->description('All-time paid orders')
                ->color('success'),
            Stat::make('Pending Orders', $pendingOrders)
                ->description('Awaiting processing')
                ->color($pendingOrders > 0 ? 'warning' : 'success'),
            Stat::make('Total Orders', $totalOrders)
                ->description('All orders placed')
                ->color('primary'),
            Stat::make('Active Products', $totalProducts)
                ->description('Products in store')
                ->color('info'),
            Stat::make('Low Stock Alerts', $lowStock)
                ->description('Products with ≤5 units')
                ->color($lowStock > 0 ? 'danger' : 'success'),
        ];
    }
}
