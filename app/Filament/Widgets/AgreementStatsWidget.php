<?php

namespace App\Filament\Widgets;

use App\Models\Agreement;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AgreementStatsWidget extends StatsOverviewWidget
{
    protected static bool $isDiscovered = true;

    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $total = Agreement::count();
        $pending = Agreement::where('status', 'pending')->count();
        $approved = Agreement::where('status', 'approved')->count();
        $rejected = Agreement::where('status', 'rejected')->count();

        return [
            Stat::make('Total Agreements', $total)
                ->description('All time')
                ->color('primary')
                ->icon(Heroicon::OutlinedDocumentText),

            Stat::make('Pending Review', $pending)
                ->description('Awaiting admin action')
                ->color('warning')
                ->icon(Heroicon::OutlinedClock),

            Stat::make('Approved', $approved)
                ->description('Active agreements')
                ->color('success')
                ->icon(Heroicon::OutlinedCheckCircle),

            Stat::make('Rejected', $rejected)
                ->description('Driver can resubmit')
                ->color('danger')
                ->icon(Heroicon::OutlinedXCircle),
        ];
    }
}
