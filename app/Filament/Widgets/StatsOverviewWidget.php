<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Product;
use App\Models\Seller;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
                ->description('All registered users')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),

            Stat::make('Total Sellers', User::where('role', 'seller')->count())
                ->description('Registered sellers')
                ->descriptionIcon('heroicon-m-building-storefront')
                ->color('info'),

            Stat::make('Verified Sellers', Seller::where('is_verified', true)->count())
                ->description('Verified sellers')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make('Total Products', Product::count())
                ->description('All products')
                ->descriptionIcon('heroicon-m-cube')
                ->color('primary'),

            Stat::make('Active Products', Product::where('status', 'aktif')->count())
                ->description('Published products')
                ->descriptionIcon('heroicon-m-eye')
                ->color('success'),

            Stat::make('Low Stock Products', Product::where('stock', '<=', 10)->where('stock', '>', 0)->count())
                ->description('Stock ≤ 10 items')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('warning'),
        ];
    }
}