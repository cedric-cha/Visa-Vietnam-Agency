<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Enums\OrderStatus;
use App\Models\Order;
use Eliseekn\LaravelMetrics\LaravelMetrics;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static bool $isLazy = false;
    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Orders', Order::query()->count('id')),
            Stat::make('Total Pending Orders', LaravelMetrics::query(
                Order::query()->where('status', OrderStatus::PENDING->value)
            )
                ->countByMonth(count: 12)
                ->forYear(now()->year)
                ->metrics())->icon('heroicon-o-clock'),
            Stat::make('Total Processed Orders', LaravelMetrics::query(
                Order::query()->where('status', OrderStatus::PROCESSED->value)
            )
                ->countByMonth(count: 12)
                ->forYear(now()->year)
                ->metrics())->icon('heroicon-o-check-circle'),
            Stat::make('Total Cancelled Orders', LaravelMetrics::query(
                Order::query()->where('status', OrderStatus::CANCELLED->value)
            )
                ->countByMonth(count: 12)
                ->forYear(now()->year)
                ->metrics())->icon('heroicon-o-x-circle'),
        ];
    }
}
