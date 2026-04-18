<?php

namespace App\Filament\Resources\Agreements\Schemas;

use Carbon\Carbon;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AgreementInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Vehicle & Agreement')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('agreement_number')->label('Agreement #')->weight('bold'),
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'pending' => 'warning',
                                'approved' => 'success',
                                'rejected' => 'danger',
                                default => 'gray',
                            }),
                        TextEntry::make('car_make_model')->label('Car Make & Model'),
                        TextEntry::make('plate_number')->label('Plate Number'),
                        TextEntry::make('bond_amount')->label('Bond Amount')->money('AUD'),
                        TextEntry::make('weekly_rent')->label('Weekly Rent')->money('AUD'),
                        TextEntry::make('pickup_date')->label('Pickup Date')->date('d M Y'),
                        TextEntry::make('pickup_time')->label('Pickup Time')->formatStateUsing(
                            fn ($state) => Carbon::parse($state)->format('h:i A')
                        ),
                    ]),

                Section::make('Driver / Renter Information')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('driver_name')->label('Full Name'),
                        TextEntry::make('renter_contact')->label('Contact Number'),
                        TextEntry::make('driver_email')->label('Email'),
                        TextEntry::make('license_number')->label('Licence Number'),
                        TextEntry::make('renter_address')->label('Address')->columnSpanFull(),
                    ]),

                Section::make('Towing / Breakdown')
                    ->columns(2)
                    ->collapsed()
                    ->schema([
                        TextEntry::make('towing_name')->label('Approved Mechanic')->placeholder('Not provided'),
                        TextEntry::make('towing_phone')->label('Towing Phone')->placeholder('Not provided'),
                    ]),

                Section::make('Walkaround & Notes')
                    ->collapsed()
                    ->schema([
                        TextEntry::make('walkaround_comments')->label('Walkaround Comments')->placeholder('None')->columnSpanFull(),
                    ]),

                Section::make('Signature')
                    ->schema([
                        ImageEntry::make('signature_path')
                            ->label('')
                            ->disk('local')
                            ->height(80)
                            ->columnSpanFull(),
                    ]),

                Section::make('Admin & Audit')
                    ->columns(2)
                    ->collapsed()
                    ->schema([
                        TextEntry::make('submitted_at')->label('Submitted')->dateTime('d M Y, H:i'),
                        TextEntry::make('ip_address')->label('IP Address'),
                        TextEntry::make('approved_at')->label('Approved At')->dateTime('d M Y, H:i')->placeholder('—'),
                        TextEntry::make('approved_by')->label('Approved By')->placeholder('—'),
                        TextEntry::make('rejected_at')->label('Rejected At')->dateTime('d M Y, H:i')->placeholder('—'),
                        TextEntry::make('rejected_by')->label('Rejected By')->placeholder('—'),
                        TextEntry::make('rejection_note')->label('Rejection Note')->placeholder('—')->columnSpanFull(),
                        TextEntry::make('reset_at')->label('Reset At')->dateTime('d M Y, H:i')->placeholder('—'),
                        TextEntry::make('reset_by')->label('Reset By')->placeholder('—'),
                        TextEntry::make('email_sent_at')->label('Email Sent At')->dateTime('d M Y, H:i')->placeholder('—'),
                    ]),
            ]);
    }
}
