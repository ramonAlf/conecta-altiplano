<?php

namespace App;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum CoverageType: string implements HasColor, HasLabel
{
    case Fiber = 'fiber';
    case Wireless = 'wireless';

    public function getLabel(): string
    {
        return match ($this) {
            self::Fiber => 'Fibra óptica',
            self::Wireless => 'Inalámbrico',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Fiber => 'success',
            self::Wireless => 'warning',
        };
    }
}
