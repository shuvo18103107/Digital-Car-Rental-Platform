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

                Section::make('Towing / Breakdown')
                    ->columns(2)
                    ->collapsed()
                    ->schema([
                        TextInput::make('towing_name')
                            ->label('Approved Mechanic Name')
                            ->maxLength(100),

                        TextInput::make('towing_phone')
                            ->label('Towing Phone')
                            ->tel()
                            ->maxLength(20),
                    ]),

                Section::make('Vehicle Walkaround')
                    ->collapsed()
                    ->schema([
                        Textarea::make('walkaround_comments')
                            ->label('Comments')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
