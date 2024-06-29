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
                    ->label(__(trans('orders.client_name'))),

                Field::make('client_phone')
                    ->label(__(trans('orders.client_phone'))),

                Field::make('client_address')
                    ->label(__(trans('orders.client_address'))),

                Field::make('client_flat_number')
                    ->label(__(trans('orders.client_flat_number'))),

                Field::make('status')
                    ->label(__(trans('orders.status_'))),

                Field::make('technician.name')
                    ->label(__(trans('orders.technician'))),

                Field::make('notes')
                    ->label(__(trans('orders.notes'))),

            ])
            ->relationManagers([
                //
            ]);
    }
}
