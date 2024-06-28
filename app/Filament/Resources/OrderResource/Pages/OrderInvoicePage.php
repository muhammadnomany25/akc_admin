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

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public function getTitle(): string | Htmlable
    {
        return trans('orders.invoiceAction');
    }

    public function getBreadcrumb(): string
    {
        return 'OrderInvoice';
    }

    public static function getNavigationLabel(): string
    {
        return trans('orders.invoiceAction');
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('item_name_en')
            ->columns([
                Tables\Columns\TextColumn::make('item_name_en')
                    ->label(trans('invoice.item_name_en'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('item_name_ar')
                    ->label(trans('invoice.item_name_ar'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('quantity')
                    ->label(trans('invoice.quantity'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('item_cost')
                    ->label(trans('invoice.item_cost'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('total')
                    ->label(trans('invoice.total'))
                    ->money('kwd')
                    ->getStateUsing(function (OrderInvoice $record) {
                        return $record->quantity * $record->item_cost;
                    }),

                Tables\Columns\TextColumn::make('total_cost')
                    ->label(trans('invoice.total_cost'))
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
