<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Orders', Order::count())
                ->description('All time orders')
                ->icon('heroicon-o-shopping-bag')
                ->color('primary'),

            Stat::make('Paid Orders', Order::where('payment_status', 'paid')->count())
                ->description('Successfully paid')
                ->icon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make('Total Revenue', '₦' . number_format(
                Order::where('payment_status', 'paid')->sum('total_amount'), 0
            ))
                ->description('From paid orders')
                ->icon('heroicon-o-banknotes')
                ->color('warning'),

            Stat::make('Products', Product::count())
                ->description(Product::where('status', 'available')->count() . ' available')
                ->icon('heroicon-o-cake')
                ->color('info'),
        ];
    }
}
