<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->label('Nombre')
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Correo electrónico')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email_verified_at')
                    ->dateTime('d M Y H:i')
                    ->label('Verificado el')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('two_factor_confirmed_at')
                    ->dateTime('d M Y H:i')
                    ->label('Confirmado el')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->label('Creado el'),
                TextColumn::make('updated_at')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->label('Actualizado el')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('verified')
                    ->label('Solo verificados')
                    ->toggle()
                    ->query(fn(Builder $query) => $query->whereNotNull('email_verified_at')),
            ])
            ->recordActions([
                ViewAction::make()->hiddenLabel(),
                EditAction::make()->hiddenLabel(),
                DeleteAction::make()->hiddenLabel(),
                Action::make('assignRoles')
                    ->label('Asignar roles')
                    ->icon(Heroicon::ShieldCheck)
                    ->hiddenLabel()
                    ->fillForm(fn(User $record): array => [
                        'roles' => $record->roles->pluck('id')->all(),
                    ])
                    ->schema([
                        Select::make('roles')
                            ->label('Roles')
                            ->multiple()
                            ->searchable()
                            ->options(fn(): array => Role::query()->orderBy('name')->pluck('name', 'id')->all())
                            ->required(),
                    ])
                    ->action(function (array $data, User $record): void {
                        $record->syncRoles(
                            Role::query()->whereIn('id', $data['roles'])->pluck('name')
                        );
                    }),

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make('assignRole')
                        ->label('Asignar rol')
                        ->icon(Heroicon::ShieldCheck)
                        ->schema([
                            Select::make('role_id')
                                ->label('Rol')
                                ->searchable()
                                ->options(fn(): array => Role::query()->orderBy('name')->pluck('name', 'id')->all())
                                ->required(),
                        ])
                        ->action(function (Collection $records, array $data): void {
                            $role = Role::query()->findOrFail($data['role_id']);
                            $records->each(fn(User $user) => $user->assignRole($role));
                        })
                        ->deselectRecordsAfterCompletion()
                        ->successNotificationTitle('Rol asignado'),
                ]),
            ]);
    }
}
