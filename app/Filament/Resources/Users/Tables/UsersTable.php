<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

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
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
