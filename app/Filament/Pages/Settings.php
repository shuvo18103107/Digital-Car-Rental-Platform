<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class Settings extends Page
{
    protected string $view = 'filament.pages.settings';

    protected static ?string $navigationLabel = 'Settings';

    protected static ?int $navigationSort = 4;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

}