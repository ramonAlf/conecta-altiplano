<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make()
                ->label('Todos')
                ->icon('heroicon-o-user-group')
                ->badge(User::query()->count())
                ->modifyQueryUsing(fn(Builder $query) => $query),
            'active' => Tab::make()
                ->label('Verificados')
                ->icon('heroicon-o-check-circle')
                ->badgeColor('success')
                ->badge(User::query()->whereNotNull('email_verified_at')->count())
                ->modifyQueryUsing(fn(Builder $query) => $query->whereNotNull('email_verified_at')),
            'inactive' => Tab::make()
                ->label('No verificados')
                ->icon('heroicon-o-x-circle')
                ->badgeColor('danger')
                ->badge(User::query()->whereNull('email_verified_at')->count())
                ->modifyQueryUsing(fn(Builder $query) => $query->whereNull('email_verified_at')),
        ];
    }
}
