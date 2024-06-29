<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderNote;
use Filament\Actions\Action;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Auth;


class OrderNotesPage extends ManageRelatedRecords
{
    protected static ?string $model = OrderNotesPage::class;

    protected static string $resource = OrderResource::class;

    protected static string $relationship = 'notes';

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';

    public static function getModelLabel(): string
    {
        return trans('notes.notes');
    }

    public static function getNavigationLabel(): string
    {
        return trans('orders.notesAction');
    }

    public function getTitle(): string|Htmlable
    {
        return trans('notes.notes_');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('create')
                ->label(trans('notes.add_notes'))
                ->form([
                    MarkdownEditor::make('notes')
                        ->label(trans('notes.notes'))
                        ->columnSpan('full')
                ])
                ->action(function (array $data, Order $record): void {
                    OrderNote::create([
                        'content' => $data['notes'],
                        'order_id' => $this->record->id,
                        'user_id' => Auth::user()->id,
                    ]);

                    Notification::make()
                        ->title('Success')
                        ->body('Password Updated Successfully')
                        ->success()
                        ->send();
                })
        ];
    }


    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('content')
                    ->label(trans('notes.notes'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label(trans('notes.by')),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(trans('notes.createdAt')),

            ])
            ->actions([
                ViewAction::make()
                    ->label(trans('notes.details'))
                    ->form([
                        MarkdownEditor::make('content')
                            ->label(trans('notes.notes'))
                            ->columnSpan('full'),

                        Select::make('user_id')
                            ->label(trans('notes.by'))
                            ->relationship(name: 'user', titleAttribute: 'name')
                            ->searchable()
                            ->preload(),
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->persistSortInSession(true);
    }
}
