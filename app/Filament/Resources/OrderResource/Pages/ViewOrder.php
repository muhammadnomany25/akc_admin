<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Pages\Activities;
use App\Filament\Resources\Blog\PostResource;
use App\Filament\Resources\OrderResource;
use App\Models\Blog\Post;
use App\Models\Order;
use App\Models\OrderNote;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Hash;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;


    protected function getActions(): array
    {
        return [];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('activities')
                ->url(fn ($record) => Activities::getSubjectUrl($record)),
        ];
    }
}
