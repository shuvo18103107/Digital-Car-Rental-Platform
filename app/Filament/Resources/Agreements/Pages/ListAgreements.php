<?php

namespace App\Filament\Resources\Agreements\Pages;

use App\Filament\Resources\Agreements\AgreementResource;
use App\Filament\Widgets\AgreementStatsWidget;
use App\Filament\Widgets\AgreementStatusChart;
use App\Filament\Widgets\AgreementSubmissionsChart;
use Filament\Resources\Pages\ListRecords;

class ListAgreements extends ListRecords
{
    protected static string $resource = AgreementResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            AgreementStatsWidget::class,
            AgreementStatusChart::class,
            AgreementSubmissionsChart::class,
        ];
    }
}
