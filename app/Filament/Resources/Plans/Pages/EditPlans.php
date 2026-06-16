<?php

namespace App\Filament\Resources\Plans\Pages;

use App\Filament\Resources\Plans\PlansResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPlans extends EditRecord
{
    protected static string $resource = PlansResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
