<?php

namespace App\Filament\Resources\CoverageZones\Pages;

use App\Filament\Resources\CoverageZones\CoverageZoneResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCoverageZones extends ListRecords
{
    protected static string $resource = CoverageZoneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
