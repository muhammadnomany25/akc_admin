<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum OrderStatus: string implements HasColor, HasIcon, HasLabel
{

    case New = 'new';

    case InProgress = 'inProgress';

    case Completed = 'Completed';

    case Duplicated = 'Duplicated';

    case Reassigned = 'Reassigned';

    public function getLabel(): string
    {
        return match ($this) {
            self::New => 'new',
            self::InProgress => 'inProgress',
            self::Duplicated => 'Duplicated',
            self::Reassigned => 'Reassigned',
            self::Completed => 'Completed'
        };
    }

    public function label(): string
    {
        return trans('status.' . $this->value);
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::New => 'info',
            self::InProgress => 'warning',
            self::Duplicated, self::Completed => 'success',
            self::Reassigned => 'danger'
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::New => 'heroicon-m-sparkles',
            self::InProgress => 'heroicon-m-arrow-path',
            self::Duplicated => 'heroicon-m-truck',
            self::Reassigned => 'heroicon-m-check-badge',
            self::Completed => 'heroicon-m-check-badge'
        };
    }
}
