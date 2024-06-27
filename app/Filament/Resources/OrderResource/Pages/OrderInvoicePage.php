<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\Blog\PostResource;
use App\Filament\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderInvoice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\Summarizers\Summarizer;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Query\Builder;

class OrderInvoicePage extends ManageRelatedRecords
{
    protected static ?string $model = OrderInvoicePage::class;

    protected static string $resource = OrderResource::class;

    protected static string $relationship = 'invoiceItems';

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';

    public function getTitle(): string | Htmlable
    {
        $recordTitle = $this->getRecordTitle();

        $recordTitle = $recordTitle instanceof Htmlable ? $recordTitle->toHtml() : $recordTitle;

        return "{$recordTitle} Invoice";
    }

    public function getBreadcrumb(): string
    {
        return 'OrderInvoice';
    }

    public static function getNavigationLabel(): string
    {
        return 'Order Invoice';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
//                Forms\Components\TextInput::make('item_name_en')
//                    ->required(),
//
//                Forms\Components\Select::make('customer_id')
//                    ->relationship('customer', 'name')
//                    ->searchable()
//                    ->required(),
//
//                Forms\Components\Toggle::make('is_visible')
//                    ->label('Approved for public')
//                    ->default(true),
//
//                Forms\Components\MarkdownEditor::make('content')
//                    ->required()
//                    ->label('Content'),
            ])
            ->columns(1);
    }

//    public function infolist(Infolist $infolist): Infolist
//    {
//        return $infolist
//            ->columns(1)
//            ->schema([
//                TextEntry::make('title'),
//                TextEntry::make('customer.name'),
//                IconEntry::make('is_visible')
//                    ->label('Visibility'),
//                TextEntry::make('content')
//                    ->markdown(),
//            ]);
//    }


//'order_id',
//'item_name_en',
//'item_name_ar',
//'quantity',
//'item_cost',

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('item_name_en')
                    ->label('Title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('item_name_ar')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('quantity')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('item_cost')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->money('kwd')
                    ->getStateUsing(function (OrderInvoice $record) {
                        return $record->quantity * $record->item_cost;
                    }),

                Tables\Columns\TextColumn::make('total_cost')
                    ->label('Total Cost')
                    ->summarize(Summarizer::make()
                        ->money('kwd')
                        ->using(fn (Builder $query): int => $query->sum('quantity') * $query->sum('item_cost') ))

            ])
            ->filters([
                //
            ])
            ->headerActions([
//                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
//                Tables\Actions\ViewAction::make(),
//                Tables\Actions\EditAction::make(),
//                Tables\Actions\DeleteAction::make(),
            ])
            ->groupedBulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
