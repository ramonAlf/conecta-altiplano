<?php

namespace App\Filament\Resources\CoverageZones\Pages;

use App\Filament\Resources\CoverageZones\CoverageZoneResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCoverageZone extends ViewRecord
{
    protected static string $resource = CoverageZoneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
