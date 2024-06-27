<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Enums\OrderStatus;
use App\Filament\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderNote;
use Filament\Actions\Action;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
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

    public function getTitle(): string|Htmlable
    {
        $recordTitle = $this->getRecordTitle();

        $recordTitle = $recordTitle instanceof Htmlable ? $recordTitle->toHtml() : $recordTitle;

        return "{$recordTitle} Notes";
    }

    public function getBreadcrumb(): string
    {
        return 'OrderNotes';
    }

    public static function getNavigationLabel(): string
    {
        return 'Order Notes';
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('create')
                ->label('Add Notes')
                ->form([
                    MarkdownEditor::make('notes')
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
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('content')
                    ->label('Note')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label("By"),

            ])
            ->actions([
                ViewAction::make()
                    ->form([
                        MarkdownEditor::make('content')
                            ->columnSpan('full'),

                         Select::make('user_id')
                             ->relationship(name: 'user', titleAttribute: 'name')
                             ->searchable()
                             ->preload(),
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->persistSortInSession(true);
    }
}
