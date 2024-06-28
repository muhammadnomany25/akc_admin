<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Pages\Activities;
use App\Filament\Resources\Blog\PostResource;
use App\Filament\Resources\OrderResource;
use App\Models\Blog\Post;
use App\Models\Order;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    public static function getNavigationLabel(): string
    {
        return trans('orders.viewAction');
    }

    protected function getActions(): array
    {
        return [];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('activities')
                ->url(fn($record) => Activities::getSubjectUrl($record)),

            Action::make('technician')
                ->label(trans('orders.changeOrAssignTechnician'))
                ->form([
                    Select::make('technician_id')
                        ->relationship(name: 'technician', titleAttribute: 'name')
                        ->searchable()
                        ->label(trans('orders.technician'))
                        ->preload()
                        ->default($this->record->technician_id),
                ])
                ->action(function (array $data, Order $record): void {
                    $this->record->update([
                        'technician_id' => $data['technician_id'],
                    ]);

                    Notification::make()
                        ->title('Success')
                        ->body('Order Updated Successfully')
                        ->success()
                        ->send();
                    $this->refreshFormData(['technician_id']);
                })
        ];
    }
}
