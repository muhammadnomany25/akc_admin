<?php

namespace App\Filament\Resources\TechnicianResource\Pages;

use App\Filament\Resources\TechnicianResource;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;
use App\Filament\Resources\UserResource;
use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Actions\Action;

class EditTechnician extends EditRecord
{
    protected static string $resource = TechnicianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('changePassword')
                ->form([
                    TextInput::make('new_password')
                        ->password()
                        ->label('New Password')
                        ->required()
                        ->revealable(),
                    TextInput::make('new_password_confirmation')
                        ->password()
                        ->label('Confirm Password')
                        ->required()
                        ->same('new_password')
                        ->revealable()
                ])
                ->action(function (array $data): void {
                    $this->record->update([
                        'password' => Hash::make($data['new_password']),
                    ]);
                    Notification::make()
                        ->title('Success')
                        ->body('Password Updated Successfully')
                        ->success()
                        ->send();
                })
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phoneNumber')
                    ->tel()
                    ->telRegex('/^(\+965[4569]\d{7})$/'),
            ]);
    }
}
