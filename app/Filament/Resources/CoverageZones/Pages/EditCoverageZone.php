<?php

namespace App\Filament\Resources\CoverageZones\Pages;

use App\Filament\Resources\CoverageZones\CoverageZoneResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCoverageZone extends EditRecord
{
    protected static string $resource = CoverageZoneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
