<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('All'),
            'new' => Tab::make()->query(fn ($query) => $query->where('status', 'new')),
            'InProgress' => Tab::make()->query(fn ($query) => $query->where('status', 'inProgress')),
            'Completed' => Tab::make()->query(fn ($query) => $query->where('status', 'Completed')),
            'Duplicated' => Tab::make()->query(fn ($query) => $query->where('status', 'Duplicated')),
            'Reassigned' => Tab::make()->query(fn ($query) => $query->where('status', 'Reassigned')),
        ];
    }
}
