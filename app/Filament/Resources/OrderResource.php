<?php

namespace App\Filament\Resources;

use App\Enums\OrderStatus;
use App\Filament\Pages\Activities;
use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static ?string $modelLabel = null;
    protected static ?string $pluralModelLabel = null;

    public static function getPluralModelLabel(): string
    {
        return trans('orders.orders');
    }

    public static function getModelLabel(): string
    {
        return trans('orders.order');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\ToggleButtons::make('status')
                    ->label(trans('orders.status'))
                    ->inline()
                    ->options(self::getOrderStatusOptions())
                    ->required()
                    ->columnSpan(2),

                Forms\Components\TextInput::make('client_name')
                    ->required()
                    ->label(trans('orders.client_name'))
                    ->maxLength(255),

                Forms\Components\TextInput::make('client_phone')
                    ->tel()
                    ->string()
                    ->telRegex('/^([4569]\d{7})$/')
                    ->prefix('+965')
                    ->label(trans('orders.client_phone'))
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('client_address')
                    ->required()
                    ->label(trans('orders.client_address'))
                    ->maxLength(255),

                Forms\Components\TextInput::make('client_flat_number')
                    ->required()
                    ->label(trans('orders.client_flat_number'))
                    ->maxLength(255),

                Select::make('technician_id')
                    ->relationship(name: 'technician', titleAttribute: 'name')
                    ->searchable()
                    ->label(trans('orders.technician'))
                    ->preload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label(trans('orders.id')),

                Tables\Columns\TextColumn::make('client_name')
                    ->label(trans('orders.client_name'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('client_phone')
                    ->label(trans('orders.client_phone'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('client_address')
                    ->label(trans('orders.client_address'))
                    ->hidden(),

                Tables\Columns\TextColumn::make('client_flat_number')
                    ->label(trans('orders.client_flat_number'))
                    ->hidden(),

                Tables\Columns\TextColumn::make('status')
                    ->label(trans('orders.status'))
                    ->formatStateUsing(function ($state) {
                        return trans('status.' . $state);
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(trans('orders.created_at'))
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('technician.name')
                    ->label(trans('orders.technician'))
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('activities')
                    ->url(fn($record) => Activities::getSubjectUrl($record))
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                ExportBulkAction::make()
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'invoice' => Pages\OrderInvoicePage::route('/{record}/invoice'),
            'notes' => Pages\OrderNotesPage::route('/{record}/notes'),
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            Pages\ViewOrder::class,
            Pages\EditOrder::class,
            Pages\OrderNotesPage::class,
            Pages\OrderInvoicePage::class,
        ]);
    }

static function getOrderStatusOptions(): array
    {
        $options = [];
        foreach (OrderStatus::cases() as $status) {
            $options[$status->value] = $status->label();
        }
        return $options;
    }
}
