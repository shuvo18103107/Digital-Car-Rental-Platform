<?php

namespace App\Filament\Resources\Agreements\Pages;

use App\Filament\Resources\Agreements\AgreementResource;
use App\Jobs\GenerateAgreementPDF;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;

class EditAgreement extends EditRecord
{
    protected static string $resource = AgreementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),

            Action::make('saveAndApprove')
                ->label('Save & Approve')
                ->icon(Heroicon::OutlinedCheckCircle)
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Save and approve this agreement?')
                ->modalDescription('Changes will be saved, then a PDF will be generated and emailed to owner, admin, and driver.')
                ->modalSubmitActionLabel('Save & Approve')
                ->visible(fn () => $this->record->status === 'pending')
                ->action(function () {
                    $this->save(shouldRedirect: false);

                    $this->record->update([
                        'status' => 'approved',
                        'approved_at' => now(),
                        'approved_by' => auth()->user()->email,
                    ]);

                    GenerateAgreementPDF::dispatch($this->record);

                    Notification::make()
                        ->title('Agreement saved and approved. PDF and emails are being sent.')
                        ->success()
                        ->send();

                    $this->redirect(AgreementResource::getUrl('view', ['record' => $this->record]));
                }),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }
}
