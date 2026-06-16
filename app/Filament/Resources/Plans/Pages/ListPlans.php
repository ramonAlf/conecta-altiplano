<?php

namespace App\Filament\Resources\Plans\Pages;

use App\Filament\Resources\Plans\PlansResource;
use App\Models\Plan;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;

class ListPlans extends ListRecords
{
    protected static string $resource = PlansResource::class;

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
                ->icon(Heroicon::ListBullet)
                ->badge(fn () => Plan::count())
                ->modifyQueryUsing(fn (Builder $query) => $query),
            'active' => Tab::make()
                ->label('Activos')
                ->icon(Heroicon::CheckCircle)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_active', true)),
            'inactive' => Tab::make()
                ->label('Inactivos')
                ->icon(Heroicon::XCircle)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_active', false)),
            'special' => Tab::make()
                ->label('Con precio especial')
                ->icon(Heroicon::CurrencyDollar)
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNotNull('special_price')),
        ];
    }
}
