<?php

namespace App\Filament\Widgets;

use App\Models\Agreement;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;

class AgreementSubmissionsChart extends ChartWidget
{
    protected static bool $isDiscovered = true;

    protected static ?int $sort = 3;

    protected ?string $heading = 'Submissions (Last 6 Months)';

    protected ?string $description = 'Monthly agreement submissions';

    protected ?string $maxHeight = '240px';

    protected int | string | array $columnSpan = 1;

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $months = collect(range(5, 0))->map(function (int $i): array {
            $month = now()->subMonths($i);

            return [
                'label' => $month->format('M Y'),
                'submitted' => Agreement::whereYear('submitted_at', $month->year)
                    ->whereMonth('submitted_at', $month->month)
                    ->count(),
                'approved' => Agreement::whereYear('submitted_at', $month->year)
                    ->whereMonth('submitted_at', $month->month)
                    ->where('status', 'approved')
                    ->count(),
            ];
        });

        return [
            'datasets' => [
                [
                    'label' => 'Submitted',
                    'data' => $months->pluck('submitted')->toArray(),
                    'borderColor' => '#6366f1',
                    'backgroundColor' => 'rgba(99, 102, 241, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                    'pointBackgroundColor' => '#6366f1',
                    'pointRadius' => 4,
                ],
                [
                    'label' => 'Approved',
                    'data' => $months->pluck('approved')->toArray(),
                    'borderColor' => '#22c55e',
                    'backgroundColor' => 'rgba(34, 197, 94, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                    'pointBackgroundColor' => '#22c55e',
                    'pointRadius' => 4,
                ],
            ],
            'labels' => $months->pluck('label')->toArray(),
        ];
    }

    protected function getOptions(): array | RawJs | null
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                    'labels' => ['usePointStyle' => true],
                ],
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
