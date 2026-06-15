<?php

namespace App\Filament\Resources\Roles\Schemas;

use Database\Seeders\Data\RolesAndPermissionsDefinition;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre')
                    ->helperText('El nombre del rol')
                    ->columnSpanFull()
                    ->required()
                    ->maxLength(255),
                CheckboxList::make('permissions')
                    ->columnSpanFull()
                    ->label('Permisos')
                    ->helperText('Los permisos del rol')
                    ->relationship(
                        name: 'permissions',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn(Builder $query): Builder => $query
                            ->where('guard_name', RolesAndPermissionsDefinition::GUARD)
                            ->orderBy('name'),
                    )
                    ->columns(2)
                    ->searchable()
                    ->bulkToggleable(),
            ]);
    }
}
