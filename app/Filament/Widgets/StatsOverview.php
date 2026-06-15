<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Usuarios', User::query()->count())->label('Usuarios'),
            Stat::make('Verificados', User::query()->whereNotNull('email_verified_at')->count())->label('Verificados'),
            Stat::make('No verificados', User::query()->whereNull('email_verified_at')->count())->label('No verificados'),
        ];
    }
}
