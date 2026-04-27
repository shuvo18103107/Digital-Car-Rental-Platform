<?php

namespace App\Filament\Resources\Agreements\Schemas;

use Carbon\Carbon;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
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

                Section::make('Handover details')
                    ->icon('heroicon-o-wrench-screwdriver')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('towing_name')
                            ->label('Towing company')
                            ->default('— Not yet set')
                            ->color(fn ($state) => $state === null ? 'warning' : 'success'),

                        TextEntry::make('towing_phone')
                            ->label('Towing phone')
                            ->default('— Not yet set'),

                        TextEntry::make('walkaround_comments')
                            ->label('Walkaround notes')
                            ->default('— Not yet completed')
                            ->columnSpanFull(),
                    ]),

                Section::make('Signature')
                    ->schema([
                        ImageEntry::make('signature_path')
                            ->label('')
                            ->getStateUsing(fn ($record) => route('admin.signature', $record))
                            ->height(80)
                            ->columnSpanFull(),
                    ]),

                Section::make('Identity documents')
                    ->icon('heroicon-o-identification')
                    ->collapsible()
                    ->schema([
                        RepeatableEntry::make('documents')
                            ->schema([
                                TextEntry::make('document_type_label')
                                    ->label('Document')
                                    ->badge()
                                    ->color(fn ($record) => match ($record?->document_type) {
                                        'passport' => 'info',
                                        'licence_front' => 'success',
                                        'licence_back' => 'warning',
                                        'visa' => 'gray',
                                        default => 'gray',
                                    }),

                                TextEntry::make('file_size_formatted')
                                    ->label('Size'),

                                TextEntry::make('original_name')
                                    ->label('Filename')
                                    ->limit(30),

                                TextEntry::make('id')
                                    ->label('Download')
                                    ->formatStateUsing(fn () => '↓ Download')
                                    ->url(fn ($record) => $record ? route('admin.documents.download', $record) : '#')
                                    ->openUrlInNewTab()
                                    ->color('primary'),
                            ])
                            ->columns(4)
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
