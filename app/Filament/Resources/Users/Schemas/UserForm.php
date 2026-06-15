<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Operation;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre')
                    ->required(),
                TextInput::make('email')
                    ->label('Correo electrónico')
                    ->email()
                    ->required(),
                TextInput::make('password')
                    ->password()
                    ->label('Contraseña')
                    ->hiddenOn(Operation::View->value)
                    ->revealable()
                    ->placeholder(
                        fn(string $operation): ?string => $operation === Operation::Edit->value
                            ? 'Dejar en blanco para no cambiar'
                            : null
                    )
                    ->required(fn(string $operation): bool => $operation === Operation::Create->value)
                    ->dehydrated(fn(?string $state): bool => filled($state))
            ]);
    }
}
