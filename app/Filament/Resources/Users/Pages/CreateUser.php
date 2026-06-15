<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Override;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    #[Override]
    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Usuario creado correctamente';
    }
}
