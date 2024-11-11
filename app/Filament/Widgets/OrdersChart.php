<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;

class OrdersChart extends ChartWidget
{
    protected static ?string $heading = 'Processed Orders Amount Per Month (USD)';
    protected static bool $isLazy = false;
    protected static ?int $sort = 1;
    protected static ?string $maxHeight = '250px';

    protected static ?array $options = [
        'plugins' => [
            'legend' => [
                'display' => false,
            ],
        ],
    ];

    protected function getData(): array
    {
        $trends = Order::metrics()
            ->sumByMonth('total_fees')
            ->forYear(now()->year)
            ->fillMissingData()
            ->trends();

        return [
            'datasets' => [
                [
                    'label' => 'Amount',
                    'data' => $trends['data'],
                    'fill' => 'start',
                ],
            ],
            'labels' => $trends['labels'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
