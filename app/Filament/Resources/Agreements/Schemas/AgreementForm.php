<?php

namespace App\Filament\Resources\Agreements\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AgreementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Vehicle & Agreement Details')
                    ->columns(2)
                    ->schema([
                        TextInput::make('car_make_model')
                            ->label('Car Make & Model')
                            ->required()
                            ->maxLength(100),

                        TextInput::make('plate_number')
                            ->label('Plate Number')
                            ->required()
                            ->maxLength(30),

                        TextInput::make('weekly_rent')
                            ->label('Weekly Rent (AUD)')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->prefix('$'),

                        TextInput::make('bond_amount')
                            ->label('Bond Amount (AUD)')
                            ->numeric()
                            ->prefix('$'),

                        DatePicker::make('pickup_date')
                            ->label('Pickup Date')
                            ->required()
                            ->native(false),

                        TimePicker::make('pickup_time')
                            ->label('Pickup Time')
                            ->required()
                            ->seconds(false),
                    ]),

                Section::make('Driver / Renter Information')
                    ->columns(2)
                    ->schema([
                        TextInput::make('driver_name')
                            ->label('Full Name')
                            ->required()
                            ->maxLength(100),

                        TextInput::make('renter_contact')
                            ->label('Contact Number')
                            ->tel()
                            ->required()
                            ->maxLength(20),

                        TextInput::make('driver_email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(150),

                        TextInput::make('license_number')
                            ->label('Licence Number')
                            ->required()
                            ->maxLength(50),

                        Textarea::make('renter_address')
                            ->label('Address')
                            ->required()
                            ->rows(2)
                            ->columnSpanFull(),
                    ]),

                Section::make('Handover details (set by admin before approving)')
                    ->description('These are NOT filled by the driver. Complete them at vehicle handover before clicking Approve.')
                    ->icon('heroicon-o-wrench-screwdriver')
                    ->collapsible()
                    ->collapsed(false)
                    ->columns(2)
                    ->schema([
                        TextInput::make('towing_name')
                            ->label('Towing company name')
                            ->placeholder('e.g. AAA Towing Perth')
                            ->helperText('Your nominated breakdown recovery company. Driver must use this company if they break down.')
                            ->maxLength(100),

                        TextInput::make('towing_phone')
                            ->label('Towing company phone')
                            ->tel()
                            ->placeholder('e.g. 0412 999 888')
                            ->maxLength(20),

                        Textarea::make('walkaround_comments')
                            ->label('Vehicle walkaround notes')
                            ->placeholder('e.g. Minor scratch rear left door. Small chip windscreen bottom right. Otherwise clean.')
                            ->helperText('Record any existing damage noted during the physical vehicle inspection before handover. Leave blank if vehicle condition is perfect.')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
