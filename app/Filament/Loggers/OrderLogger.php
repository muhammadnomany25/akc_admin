<?php

namespace App\Filament\Loggers;

use App\Models\Order;
use App\Filament\Resources\OrderResource;
use Illuminate\Contracts\Support\Htmlable;
use Noxo\FilamentActivityLog\Loggers\Logger;
use Noxo\FilamentActivityLog\ResourceLogger\Field;
use Noxo\FilamentActivityLog\ResourceLogger\RelationManager;
use Noxo\FilamentActivityLog\ResourceLogger\ResourceLogger;
use Spatie\Permission\Traits\HasRoles;

class OrderLogger extends Logger
{

    public static ?string $model = Order::class;

    public static function getLabel(): string | Htmlable | null
    {
        return OrderResource::getModelLabel();
    }

    public static function resource(ResourceLogger $logger): ResourceLogger
    {
        return $logger
            ->fields([
                Field::make('client_name')
                    ->label(__('Client name')),

                Field::make('client_phone')
                    ->label(__('Client Phone')),

                Field::make('client_address')
                    ->label(__('Client Address')),

                Field::make('client_flat_number')
                    ->label(__('Client Flat number')),

                Field::make('status')
                    ->label(__('Status')),

                Field::make('technician.name')
                    ->label(__('Technician')),

                Field::make('notes')
                    ->label(__('Notes')),

            ])
            ->relationManagers([
                //
            ]);
    }
}
