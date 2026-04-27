<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class SettingsPage extends Page
{
    protected string $view = 'filament.pages.settings-page';

    protected static ?string $navigationLabel = 'Portal Settings';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?int $navigationSort = 10;

    public array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'owner_name' => Setting::get('owner_name', ''),
            'owner_email' => Setting::get('owner_email', ''),
            'admin_email' => Setting::get('admin_email', ''),
            'company_name' => Setting::get('company_name', ''),
            'company_address' => Setting::get('company_address', ''),
            'company_phone' => Setting::get('company_phone', ''),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('Owner details (appear on PDFs and emails)')
                    ->schema([
                        TextInput::make('owner_name')
                            ->label('Owner name')
                            ->required()
                            ->helperText('Appears on every agreement PDF'),

                        TextInput::make('owner_email')
                            ->label('Owner email')
                            ->email()
                            ->required()
                            ->helperText('Receives a copy of every signed agreement'),

                        TextInput::make('company_address')
                            ->label('Owner address')
                            ->required()
                            ->helperText('Appears on PDFs and footer'),

                        TextInput::make('company_phone')
                            ->label('Owner phone')
                            ->required()
                            ->helperText('Appears on PDFs and footer'),

                        FileUpload::make('owner_signature_file')
                            ->label('Owner signature image')
                            ->image()
                            ->disk('local')
                            ->directory('private/signatures')
                            ->acceptedFileTypes(['image/png', 'image/jpeg'])
                            ->maxSize(1024 * 1024 * 5)
                            ->helperText('PNG or JPG. Max 5MB. This signature appears on all generated PDFs.')
                            ->saveUploadedFileUsing(function ($file) {
                                $filename = 'owner_signature.'.$file->getClientOriginalExtension();

                                $path = $file->storeAs('private/signatures', $filename, 's3');

                                Setting::set('owner_signature_path', $path);

                                return $path;
                            }),
                    ]),

                Section::make('Notification settings')
                    ->description('These are email addresses that receive copies of agreements — NOT your login credentials. To change your login email or password, go to My Profile (top-right avatar menu).')
                    ->schema([
                        TextInput::make('admin_email')
                            ->label('Company admin notification email')
                            ->email()
                            ->required()
                            ->helperText('Receives a PDF copy of every approved agreement. This is NOT your login email.'),

                        TextInput::make('company_name')
                            ->label('Company name')
                            ->required()
                            ->helperText('Appears in email subjects and PDF header'),
                    ]),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach (['owner_name', 'owner_email', 'admin_email', 'company_name', 'company_address', 'company_phone'] as $key) {
            Setting::set($key, $data[$key] ?? '');
        }

        Notification::make()->title('Settings saved')->success()->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Save settings')
                ->icon(Heroicon::OutlinedCheck)
                ->requiresConfirmation()
                ->modalHeading('Save settings?')
                ->modalSubmitActionLabel('Save')
                ->action(fn () => $this->save()),
        ];
    }
}
