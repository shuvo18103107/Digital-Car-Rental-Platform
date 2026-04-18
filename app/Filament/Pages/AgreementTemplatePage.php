<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms\Components\RichEditor;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class AgreementTemplatePage extends Page
{
    protected string $view = 'filament.pages.agreement-template-page';

    protected static ?string $navigationLabel = 'Agreement Terms';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static ?int $navigationSort = 2;

    public array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'agreement_body' => Setting::get('agreement_body', ''),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                RichEditor::make('agreement_body')
                    ->label('Terms and conditions')
                    ->toolbarButtons([
                        'bold', 'italic', 'underline', 'strike',
                        'bulletList', 'orderedList',
                        'h2', 'h3',
                        'undo', 'redo',
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        Setting::set('agreement_body', $data['agreement_body']);

        Notification::make()
            ->title('Terms updated. Future agreements will use the new version.')
            ->success()
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Save terms and conditions')
                ->icon(Heroicon::OutlinedCheck)
                ->requiresConfirmation()
                ->modalHeading('Save terms and conditions?')
                ->modalDescription('Changes apply to future submissions only. Previously signed agreements are permanently locked to the version at time of signing.')
                ->modalSubmitActionLabel('Save')
                ->action(fn () => $this->save()),
        ];
    }
}
