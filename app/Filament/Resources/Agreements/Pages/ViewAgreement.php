<?php

namespace App\Filament\Resources\Agreements\Pages;

use App\Filament\Resources\Agreements\AgreementResource;
use App\Jobs\GenerateAgreementPDF;
use App\Jobs\SendAgreementEmails;
use App\Jobs\SendRejectionEmail;
use App\Models\Agreement;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Storage;

class ViewAgreement extends ViewRecord
{
    protected static string $resource = AgreementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->label('Edit details')
                ->icon(Heroicon::OutlinedPencilSquare)
                ->visible(fn () => $this->record->status === 'pending'),

            Action::make('approve')
                ->label('Approve & send')
                ->icon(Heroicon::OutlinedCheckCircle)
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Approve this agreement?')
                ->modalDescription('A PDF will be generated and emailed to the owner, admin, and driver.')
                ->modalSubmitActionLabel('Approve')
                ->visible(fn () => $this->record->status === 'pending')
                ->action(function () {
                    /** @var \App\Models\User $admin */
                    $admin = auth()->user();
                    $this->record->update([
                        'status' => 'approved',
                        'approved_at' => now(),
                        'approved_by' => $admin->email,
                    ]);
                    GenerateAgreementPDF::dispatch($this->record);
                    Notification::make()
                        ->title('Agreement approved. PDF and emails are being sent.')
                        ->success()
                        ->send();
                    $this->refreshFormData(['status', 'approved_at', 'approved_by']);
                }),

            Action::make('reject')
                ->label('Reject')
                ->icon(Heroicon::OutlinedXCircle)
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading('Reject this agreement')
                ->modalDescription('The driver will receive an email with your reason.')
                ->modalSubmitActionLabel('Reject')
                ->schema([
                    Textarea::make('rejection_note')
                        ->label('Rejection reason (sent to driver by email)')
                        ->required()
                        ->rows(4),
                ])
                ->visible(fn () => $this->record->status === 'pending')
                ->action(function (array $data) {
                    /** @var \App\Models\User $admin */
                    $admin = auth()->user();
                    $this->record->update([
                        'status' => 'rejected',
                        'rejection_note' => $data['rejection_note'],
                        'rejected_at' => now(),
                        'rejected_by' => $admin->email,
                    ]);
                    SendRejectionEmail::dispatch($this->record);
                    Notification::make()
                        ->title('Agreement rejected. Driver has been notified by email.')
                        ->warning()
                        ->send();
                    $this->refreshFormData(['status', 'rejection_note', 'rejected_at', 'rejected_by']);
                }),

            Action::make('downloadPdf')
                ->label('Download PDF')
                ->icon(Heroicon::OutlinedArrowDownTray)
                ->color('gray')
                ->visible(fn () => $this->record->status === 'approved' && $this->record->pdf_path)
                ->url(fn () => route('admin.agreements.download-pdf', $this->record))
                ->openUrlInNewTab(),

            Action::make('resendEmails')
                ->label('Resend emails')
                ->icon(Heroicon::OutlinedEnvelope)
                ->color('gray')
                ->requiresConfirmation()
                ->modalHeading('Resend PDF to owner, admin, and driver?')
                ->modalSubmitActionLabel('Resend')
                ->visible(fn () => $this->record->status === 'approved' && $this->record->email_sent)
                ->action(function () {
                    SendAgreementEmails::dispatch($this->record);
                    Notification::make()
                        ->title('Emails are being resent.')
                        ->success()
                        ->send();
                }),

            Action::make('reset')
                ->label('Reset licence lock')
                ->icon(Heroicon::OutlinedArrowPath)
                ->color('warning')
                ->requiresConfirmation()
                ->modalHeading(fn () => "Reset licence lock for {$this->record->driver_name}?")
                ->modalDescription('This allows the driver to submit a new agreement. Their existing record is preserved in history.')
                ->modalSubmitActionLabel('Reset')
                ->visible(fn () => in_array($this->record->status, ['approved', 'rejected']) && ! $this->record->is_reset)
                ->action(function () {
                    /** @var \App\Models\User $admin */
                    $admin = auth()->guard()->user();
                    $this->record->update([
                        'is_reset' => true,
                        'reset_at' => now(),
                        'reset_by' => $admin->email,
                    ]);
                    Notification::make()
                        ->title('Licence lock cleared. Driver can now submit a new agreement.')
                        ->success()
                        ->send();
                    $this->refreshFormData(['is_reset', 'reset_at', 'reset_by']);
                }),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        $plateConflict = Agreement::where('plate_number', $this->record->plate_number)
            ->where('status', 'approved')
            ->where('id', '!=', $this->record->id)
            ->where('is_reset', false)
            ->first();

        if (! $plateConflict) {
            return [];
        }

        Notification::make()
            ->title("Plate conflict: {$this->record->plate_number} is already on an active approved agreement ({$plateConflict->agreement_number} — {$plateConflict->driver_name}).")
            ->warning()
            ->persistent()
            ->send();

        return [];
    }
}
