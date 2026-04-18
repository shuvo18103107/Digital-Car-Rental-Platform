<?php

namespace App\Filament\Widgets;

use App\Models\Agreement;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;

class AgreementStatusChart extends ChartWidget
{
    protected static bool $isDiscovered = true;

    protected static ?int $sort = 2;

    protected ?string $heading = 'Agreements by Status';

    protected ?string $description = 'Breakdown of all agreements';

    protected ?string $maxHeight = '240px';

    protected int | string | array $columnSpan = 1;

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Agreements',
                    'data' => [
                        Agreement::where('status', 'pending')->count(),
                        Agreement::where('status', 'approved')->count(),
                        Agreement::where('status', 'rejected')->count(),
                    ],
                    'backgroundColor' => ['#f59e0b', '#22c55e', '#ef4444'],
                    'borderRadius' => 6,
                    'borderSkipped' => false,
                ],
            ],
            'labels' => ['Pending', 'Approved', 'Rejected'],
        ];
    }

    protected function getOptions(): array | RawJs | null
    {
        return [
            'plugins' => [
                'legend' => ['display' => false],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => ['stepSize' => 1],
                    'grid' => ['display' => true],
                ],
                'x' => [
                    'grid' => ['display' => false],
                ],
            ],
        ];
    }
}
