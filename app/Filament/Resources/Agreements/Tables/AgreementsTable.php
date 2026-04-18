<?php

namespace App\Filament\Resources\Agreements\Tables;

use App\Models\Agreement;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Response;

class AgreementsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('signature_path')
                    ->label('Signature')
                    ->getStateUsing(fn ($record) => route('admin.signature', $record))
                    ->height(48)
                    ->width(120),

                TextColumn::make('agreement_number')
                    ->label('Agreement #')
                    ->weight('bold')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('driver_name')
                    ->label('Driver')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('license_number')
                    ->label('Licence #')
                    ->searchable(),

                TextColumn::make('plate_number')
                    ->label('Plate')
                    ->searchable(),

                TextColumn::make('pickup_date')
                    ->label('Pickup')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('submitted_at')
                    ->label('Submitted')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ]),

                IconColumn::make('email_sent')
                    ->label('Emailed')
                    ->boolean()
                    ->trueIcon(Heroicon::OutlinedCheckCircle)
                    ->falseIcon(Heroicon::OutlinedXCircle)
                    ->trueColor('success')
                    ->falseColor('gray'),
            ])
            ->defaultSort('submitted_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),
            ])
            ->recordClasses(fn ($record) => $record->status === 'pending' ? 'bg-amber-50' : null)
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([]),
                Action::make('exportCsv')
                    ->label('Export CSV')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->color('gray')
                    ->action(function () {
                        $filename = 'agreements-export-'.now()->format('Y-m-d').'.csv';
                        $records = Agreement::orderBy('submitted_at', 'desc')->get();

                        $headers = [
                            'Content-Type' => 'text/csv',
                            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
                        ];

                        $callback = function () use ($records) {
                            $handle = fopen('php://output', 'w');
                            fputcsv($handle, [
                                'agreement_number', 'car_make_model', 'plate_number',
                                'bond_amount', 'weekly_rent', 'pickup_date', 'pickup_time',
                                'driver_name', 'renter_address', 'license_number',
                                'renter_contact', 'driver_email', 'towing_name', 'towing_phone',
                                'walkaround_comments', 'status', 'rejection_note',
                                'approved_at', 'approved_by', 'rejected_at', 'rejected_by',
                                'email_sent', 'email_sent_at', 'is_reset', 'reset_at',
                                'reset_by', 'ip_address', 'submitted_at',
                            ]);
                            foreach ($records as $record) {
                                fputcsv($handle, [
                                    $record->agreement_number,
                                    $record->car_make_model,
                                    $record->plate_number,
                                    $record->bond_amount,
                                    $record->weekly_rent,
                                    $record->pickup_date?->format('Y-m-d'),
                                    $record->pickup_time,
                                    $record->driver_name,
                                    $record->renter_address,
                                    $record->license_number,
                                    $record->renter_contact,
                                    $record->driver_email,
                                    $record->towing_name,
                                    $record->towing_phone,
                                    $record->walkaround_comments,
                                    $record->status,
                                    $record->rejection_note,
                                    $record->approved_at,
                                    $record->approved_by,
                                    $record->rejected_at,
                                    $record->rejected_by,
                                    $record->email_sent ? '1' : '0',
                                    $record->email_sent_at,
                                    $record->is_reset ? '1' : '0',
                                    $record->reset_at,
                                    $record->reset_by,
                                    $record->ip_address,
                                    $record->submitted_at,
                                ]);
                            }
                            fclose($handle);
                        };

                        return Response::stream($callback, 200, $headers);
                    }),
            ]);
    }
}
