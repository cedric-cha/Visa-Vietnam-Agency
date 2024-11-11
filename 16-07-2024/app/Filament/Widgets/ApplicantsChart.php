<?php

namespace App\Filament\Widgets;

use App\Models\Applicant;
use Filament\Widgets\ChartWidget;

class ApplicantsChart extends ChartWidget
{
    protected static ?string $heading = 'Total Applicants Per Month';
    protected static bool $isLazy = false;
    protected static ?int $sort = 2;
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
        $trends = Applicant::metrics()
            ->countByMonth()
            ->forYear(now()->year)
            ->fillMissingData()
            ->trends();

        return [
            'datasets' => [
                [
                    'label' => 'Total',
                    'data' => $trends['data'],
                    'fill' => 'start',
                ],
            ],
            'labels' => $trends['labels'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
