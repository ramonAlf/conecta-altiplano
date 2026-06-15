<?php

namespace App\Filament\Resources\Roles\Tables;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Spatie\Permission\Models\Role;

class RolesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->label('Nombre')
                    ->sortable(),
                TextColumn::make('guard_name')
                    ->searchable()
                    ->label('Guardia')
                    ->sortable(),
                TextColumn::make('permissions_count')
                    ->label('Permisos asignados')
                    ->counts('permissions')
                    ->sortable(),
                TextColumn::make('users_count')
                    ->label('Usuarios asignados')
                    ->counts('users')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('assignUsers')
                    ->label('Asignar usuarios')
                    ->icon(Heroicon::UserPlus)
                    ->hiddenLabel()
                    ->modalHeading(fn(Role $record): string => "Usuarios del rol «{$record->name}»")
                    ->fillForm(fn(Role $record): array => [
                        'users' => $record->users()->pluck('users.id')->all(),
                    ])
                    ->schema([
                        Select::make('users')
                            ->label('Usuarios')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->options(fn(): array => User::query()->orderBy('name')->pluck('name', 'id')->all())
                            ->required(),
                    ])
                    ->action(function (array $data, Role $record): void {
                        $record->users()->sync($data['users']);
                    })
                    ->successNotificationTitle('Usuarios actualizados'),

                EditAction::make()->hiddenLabel(),
                DeleteAction::make()->hiddenLabel(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
