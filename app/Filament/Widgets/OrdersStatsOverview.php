<?php

namespace App\Filament\Widgets;

use App\Enums\OrderStatus;
use App\Models\Applicant;
use App\Models\Order;
use Eliseekn\LaravelMetrics\Enums\Period;
use Eliseekn\LaravelMetrics\LaravelMetrics;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrdersStatsOverview extends BaseWidget
{
    protected static bool $isLazy = false;

    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        $ordersCount = LaravelMetrics::query(
            Order::query()->where('status', OrderStatus::PROCESSED->value)
        )
            ->countByDay()
            ->forYear(now()->year)
            ->forMonth(now()->month)
            ->metricsWithVariations(1, Period::YEAR->value);

        $ordersPrice = LaravelMetrics::query(
            Order::query()->where('status', OrderStatus::PROCESSED->value)
        )
            ->sumByDay('total_fees')
            ->forYear(now()->year)
            ->forMonth(now()->month)
            ->metricsWithVariations(1, Period::YEAR->value);

        $applicants = Applicant::metrics()
            ->countByDay()
            ->forYear(now()->year)
            ->forMonth(now()->month)
            ->metricsWithVariations(1, Period::YEAR->value);

        return [
            Stat::make('Total Processed Orders (This Month)', $ordersCount['count'])
                ->description($ordersCount['variation'] ? ucfirst($ordersCount['variation']['type']).' of '.$ordersCount['variation']['value'] : '')
                ->descriptionIcon($ordersCount['variation'] && $ordersCount['variation']['type'] === 'increase' ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($ordersCount['variation'] && $ordersCount['variation']['type'] === 'increase' ? 'primary' : 'danger'),
            Stat::make('Total Processed Orders Amount (This Month)', '$'.$ordersPrice['count'])
                ->description($ordersPrice['variation'] ? ucfirst($ordersPrice['variation']['type']).' of $'.$ordersPrice['variation']['value'] : '')
                ->descriptionIcon($ordersPrice['variation'] && $ordersPrice['variation']['type'] === 'increase' ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($ordersPrice['variation'] && $ordersPrice['variation']['type'] === 'increase' ? 'primary' : 'danger')
                ->icon('heroicon-o-check-circle'),
            Stat::make('Total Applicants (This Month)', $applicants['count'])
                ->description($applicants['variation'] ? ucfirst($applicants['variation']['type']).' of '.$applicants['variation']['value'] : '')
                ->descriptionIcon($applicants['variation'] && $applicants['variation']['type'] === 'increase' ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($applicants['variation'] && $applicants['variation']['type'] === 'increase' ? 'primary' : 'danger')
                ->icon('heroicon-o-user-group'),
        ];
    }
}
